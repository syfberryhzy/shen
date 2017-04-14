<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function gravatar($size = '100'){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public static function boot(){
        parent::boot();

        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    public function statuses(){
        return $this->hasMany(Status::class);
    }

    public function feed(){
        $user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($user_ids, Auth::user()->id);
        return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
    }
    // 获取粉丝列表
    public function followers(){
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }
    // 获取用户关注人列表
    public function followings(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // 用户和粉丝模型进行类多对多关联之后，便可以使用Element模型为多对多提供的一系列简便的方法。
    // 如果用attach 方法或　sync方法在中间表上创建一个多对多记录，使用detach 方法在中间表上移除一个记录，
    // 创建和移除操作并不会影响到两个模型各自的数据，所有的数据变动都在中间表上进行。
    // attach , sync ,detach 这几个方法都允许传入　ｉｄ　数组参数
    // $user->followings()->attach([2]) attach 会出现id 重复的情况
    // $user->followings()->sync([2],false)　
    // 第一参数是要添加的id,第二参数指明是否要移除其它不包含在关联的id数组中的id,fasle 不移除，true　(默认)移除。

    // 关注
    public function follow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注
    public function unfollow($user_ids){
        if (!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    // 判断用户A 是否关注了用户B
    // 只需要判断用户B是否包含在用户A的关注人列表上即可
    public function isFollowing($user_id){
        return $this->followings->contains($user_id);
    }




}
