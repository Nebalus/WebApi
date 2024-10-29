<?php

namespace Nebalus\Webapi\Api\View\User;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\User;
use ReallySimpleJWT\Jwt;

class UserAuthView
{
    public static function render(Jwt $jwt, User $user): ResultInterface
    {
        $fields = [
            "jwt" => $jwt->getToken(),
            "user" => [
                "user_id" => $user->getUserId()->asInt(),
                "username" => $user->getUsername()->asString(),
                "email" => $user->getEmail()->asString(),
                "is_admin" => $user->isAdmin(),
                "is_enabled" => $user->isEnabled(),
                "creation_date_timestamp" => $user->getCreationDate()->getTimestamp()
            ]
        ];

        return Result::createSuccess("User successfully authenticated", 200, $fields);
    }
}