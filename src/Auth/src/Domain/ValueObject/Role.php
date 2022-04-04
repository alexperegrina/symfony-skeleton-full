<?php
declare(strict_types=1);

namespace Auth\Domain\ValueObject;

use AlexPeregrina\ValueObject\Domain\Enum\Enum;

class Role extends Enum
{
    public const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ADMIN = 'ROLE_ADMIN';
    public const USER = 'ROLE_USER';
    public const LANDING = 'ROLE_LANDING';
}