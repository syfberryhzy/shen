<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 获取去除掉ID 为１的上所有用户ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除了ID 为１的所有用户　ID 数组
        $user->follow($follower_ids);

        // 除了１号用户以外的所有用户都来关注１号用户
        foreach($followers as $follower){
            $follower->follow($user_id);
        }

    }
}
