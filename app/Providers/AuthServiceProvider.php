<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\User;
use App\Policies\UserPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        // 我们需要在AuthServiceProvider类中对授权策略进行设置。AuthServiceProvider包含类一个policies
        // 属性，该属性用于将各种模型对应到管理它们的授权策略上。我们需要为用户模型User指定授权策略UserPolicy。

        User::class => UserPolicy::class,
        // 授权策略定义完成之后，我们便可以通过在用户控制器中使用authorize方法来验证用户授权策略。默认的app\Http\
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
