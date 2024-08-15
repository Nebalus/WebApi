<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject;

enum AccessLevel
{
    case SUPER_ADMINISTRATOR;
    case ADMINISTRATOR;
    case USER;
}
