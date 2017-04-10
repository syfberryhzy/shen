<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // update方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。
    // 当两个id相同时，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作。
    // 如果id不相同的话，将抛出４０３异常信息来拒绝访问。
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser , User $user){
        return $currentUser->is_admin && $currentUser->id != $user->id ;
    }
}
