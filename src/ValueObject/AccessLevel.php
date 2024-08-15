<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject;

enum AccessLevel
{
    case ADMINISTRATOR;
    case USER;
}
