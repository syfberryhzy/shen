<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class SessionsController extends Controller
{
    // Auth中间件提供的guest 属性，用于指定一些只允许未登录用户访问的动作，
    // 因此我们需要通过对guest属性进行设置，只让未登录用户访问登录页面和注册页面
    public function __construct(){
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
    public function create(){
        return view('sessions.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Auth::attempt()方法可接收两个参数，第一个参数为需要进行用户身份验证的数组，第二个参数为是否为用户开启
        // 「记住我」功能的布尔值。

        // 友好的转向
        // redirect()实例提供类一个　intended()　方法，该方法可将页面重定向到上一次请求尝试访问的页面上，
        // 并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
        if(Auth::attempt($credentials,$request->has('remember'))){
            //登录成功后的相关操作
            session()->flash('success','欢迎回来！');
            // return redirect()->route('users.show',[Auth::user()]);
            return redirect()->intended(route('users.show',[Auth::user()]));
        }else{
            //登录失败后的相关操作
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}
