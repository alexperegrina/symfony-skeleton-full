<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class EntityDuplicateException extends Exception
{
    public function __construct($nameEntity = "Entity")
    {
        $message = "This '$nameEntity' already exist";
        parent::__construct($message);
    }
}