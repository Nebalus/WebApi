<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Collector;

use Nebalus\Webapi\Controller\Referral\ReferralGetController;
use Nebalus\Webapi\Controller\User\UserAuthController;
use Nebalus\Webapi\Handler\ErrorHandler;
use Nebalus\Webapi\Middleware\CorsMiddleware;
use Nebalus\Webapi\Option\EnvData;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class RouteCollector
{
    public function __construct(
        private readonly App $app,
        private readonly EnvData $env
    ) {
    }

    public function init(): void
    {
        $this->app->addRoutingMiddleware();
        $this->initErrorMiddleware();
        $this->app->add(CorsMiddleware::class);
        $this->initRoutes();
    }

    private function initErrorMiddleware(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware($this->env->isDevelopment(), true, true);

//        if ($this->env->isProduction()) {
            $errorMiddleware->setDefaultErrorHandler(ErrorHandler::class);
//        }
    }

    private function initRoutes(): void
    {
        $this->app->group("/admin", function (RouteCollectorProxy $group) {
        });

        $this->app->group("/user", function (RouteCollectorProxy $group) {
            $group->map(["POST"], "/auth", [UserAuthController::class, "authAction"]);
//            $group->group("/{username}", function (RouteCollectorProxy $group) {
//                $group->map(["GET"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
//                $group->map(["PATCH"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
//                $group->map(["DELETE"], "", [TempController::class, "action"])->add(AuthMiddleware::class);
//                $group->map(["POST"], "", [UserCreateController::class, "entryAction"])->add(AuthMiddleware::class);
//                $group->group("/linktree", function (RouteCollectorProxy $group) {
//                    $group->map(["GET"], "", [TempController::class, "action"]);
//                    $group->map(["PATCH"], "/update", [TempController::class, "action"])->add(AuthMiddleware::class);
//                });
//            });
        });

        $this->app->group("/referral/[{code}]", function (RouteCollectorProxy $group) {
            $group->map(["GET"], "", [ReferralGetController::class, "action"]);
//            $group->map(["POST"], "", [ReferralCreateController::class, "action"])->add(AuthMiddleware::class);
//            $group->map(["PATCH"], "", [ReferralEditController::class, "action"])->add(AuthMiddleware::class);
//            $group->map(["DELETE"], "", [ReferralDeleteController::class, "action"])->add(AuthMiddleware::class);
        });

//        $this->app->group("/analytic", function (RouteCollectorProxy $group) {
//            $group->group("/signature", function (RouteCollectorProxy $group) {
//                $group->map(["GET"], "", [TempController::class, "action"]);
//            });
//            $group->group("/service/[{id}]", function (RouteCollectorProxy $group) {
//            });
//            $group->group("/chart/[{id}]", function (RouteCollectorProxy $group) {
//            });
//        });
//
//        $this->app->group("/project", function (RouteCollectorProxy $group) {
//            $group->group("/cosmoventure", function (RouteCollectorProxy $group) {
//                $group->get("/version", [TempController::class, "action"]);
//            });
//        });
    }
}
