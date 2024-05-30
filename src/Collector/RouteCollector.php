<?php

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Controller\Linktree\LinktreeGetController;
use Nebalus\Webapi\Controller\User\UserCreateController;
use Nebalus\Webapi\Controller\User\UserDeleteController;
use Nebalus\Webapi\Controller\User\UserEditController;
use Nebalus\Webapi\Controller\User\UserListAllController;
use Nebalus\Webapi\Controller\User\UserAuthController;
use Nebalus\Webapi\Controller\Linktree\LinktreeCreateController;
use Nebalus\Webapi\Controller\Linktree\LinktreeDeleteController;
use Nebalus\Webapi\Controller\Linktree\LinktreeEditController;
use Nebalus\Webapi\Controller\Referral\ReferralCreateController;
use Nebalus\Webapi\Controller\Referral\ReferralDeleteController;
use Nebalus\Webapi\Controller\Referral\ReferralGetController;
use Nebalus\Webapi\Controller\Referral\ReferralEditController;
use Nebalus\Webapi\Controller\TempController;
use Nebalus\Webapi\Handler\ErrorHandler;
use Nebalus\Webapi\Middleware\AuthMiddleware;
use Nebalus\Webapi\Option\EnvData;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouteCollector
{
    private App $app;
    private EnvData $env;

    public function __construct(App $app, EnvData $env)
    {
        $this->app = $app;
        $this->env = $env;
    }

    public function init(): void
    {
        $this->app->addRoutingMiddleware();

        $this->initRoutes();
        $this->initErrorMiddleware();
    }

    private function initErrorMiddleware(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware($this->env->isDevelopment(), true, true);

        if ($this->env->isProduction() || true) {
            $errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);
        }
    }

    private function initRoutes(): void
    {
        // Definiert die Route
        $this->app->group("/user", function (RouteCollectorProxy $group) {
            $group->map(["POST"], "/login", [UserAuthController::class, "action"]);
            $group->map(["GET"], "/listall", [TempController::class, "action"]);
        });

        $this->app->group("/users/{username}", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
            $group->map(["PATCH"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
            $group->map(["DELETE"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
            $group->map(["POST"], "", [UserCreateController::class, "entryAction"])->add(AuthMiddleware::class);
            $group->group("/linktree", function (RouteCollectorProxy $group) {
                $group->map(["GET"], "", [TempController::class, "action"]);
                $group->map(["PATCH"], "/update", [TempController::class, "action"])->add(AuthMiddleware::class);
            });
        });

        $this->app->group("/referrals/[{code}]", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "", [ReferralGetController::class, "action"]);
            $group->map(["POST"], "", [ReferralCreateController::class, "action"])->add(AuthMiddleware::class);
            $group->map(["PATCH"], "", [ReferralEditController::class, "action"])->add(AuthMiddleware::class);
            $group->map(["DELETE"], "", [ReferralDeleteController::class, "action"])->add(AuthMiddleware::class);
        });

        $this->app->group("/analytics", function (RouteCollectorProxy $group) {
            $group->group("/signatures", function (RouteCollectorProxy $group) {
                $group->map(["GET"], "", [TempController::class, "action"]);
            });
            $group->group("/services/[{id}]", function (RouteCollectorProxy $group) {
            });
            $group->group("/charts/[{id}]", function (RouteCollectorProxy $group) {
            });
        });

        $this->app->group("/projects", function (RouteCollectorProxy $group) {
            $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
                $group->get("/version", [TempController::class, "action"]);
            });
        });
    }
}
