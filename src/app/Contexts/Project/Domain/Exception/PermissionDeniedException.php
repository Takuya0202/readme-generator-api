<?php

namespace App\Contexts\Project\Domain\Exception;

use Exception;

class PermissionDeniedException extends Exception
{
    public function __construct(string $message = "このプロジェクトにはアクセスできません",)
    {
        return parent::__construct($message);
    }
}
