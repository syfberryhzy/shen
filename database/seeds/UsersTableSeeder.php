<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建５０个假用户
        $users = factory(User::class)->times(50)->make();
        // times 和　make 方法是由　FactoryBuilder 类提供的API .
        // times 接受一个参数用于指定要创建的模型数量，
        // make 方法调用后将为模型创建一个集合。
        // 接着，我们使用类insert　方法来将生成假用户列表数据批量插入列数据库中。databases/seeders/DatabaseSeeder.php

        User::insert($users->toArray());

        $user = User::find(1);
        $user->name = 'Berry_Seeder';
        $user->email = '1913549290@qq.com';
        $user->password = bcrypt('password');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
