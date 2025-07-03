<?php

namespace StreetSignal\Authzn;

use StreetSignal\Core\Tool\Acl;
use StreetSignal\Contracts\Acl as AclInterface;
use StreetSignal\Contracts\Repository\Entity\RoleRepository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AclInterface::class, Acl::class);

        $this->app->extend(Acl::class, function (Acl $acl) {
            return $acl->setRoleRepo($this->app[RoleRepository::class]);
        });

        // $this->app->singleton(Session::class, function ($app) {
        //     return new Session();
        // });
    }
}
