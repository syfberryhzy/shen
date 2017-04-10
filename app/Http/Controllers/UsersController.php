<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;

use Auth;

class UsersController extends Controller
{
    // __contruct是PHP　的构造器方法，当一个类对象被创建之前该方法将会被调用。我们在__construct方法中调用了.middleware
    // 方法，该方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作。我们通过only方法来指定动作使用Auth中间件进行过滤。
    public function __construct(){
        $this->middleware('auth',[
            'only'=>['edit','update','destroy']
        ]);
        //只让未登录用户访问注册页面
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    public function index(){
        // $users = User::all();
        // 分页
        $users = User::paginate(10);
        return view('users.index',compact('users'));
        // 问题
        // １.注册用户太少
        // ２.用户列表页不支持分页浏览，用户量大的时候会影响性能和用户体验
        // 解决
        // 在实际的项目开发过程中，我们经常会用到一些假数据来对数据库进行填充以方便测试，
        // 为此Laravel提供类一整套非常简单易用的数据填充方案。
        // 假数据的生成分为两个阶段
        // １.对要生成假数据的模型指定字段进行赋值－「 模型工厂」Faker扩张包
        // database/factories/ModelFactory.php
        // ２.批量生成假数据模型－「数据填充」
    }
    public function create(){
        return view('users.create');
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // 注册成功后能够自动登录，这样的应用用户体验会更棒。
        Auth::login($user);
        // 闪现消息
        session()->flash('success','欢迎，您将在这里开启一段新的旅程～');
        return redirect()->route('users.show',[$user]);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $this->authorize('update',$user);
        // 这里的update是指授权类里的update授权方法，$user 对应传参　update 授权方法的第二个参数。　
        return view('users.edit',compact('user'));
    }


    public function update($id, Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'required|confirmed|max:6',
        ]);


        $user = User::findOrFail($id);
        $this->authorize('update',$user);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        // $user->update([
        //     'name' => $request->name ,
        //     'password' => bcrypt($request->password) ,
        // ]);
        session()->flash('success','个人资料更新成功！');
        return redirect()->route('users.show', $id);

    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $THIS->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
}
