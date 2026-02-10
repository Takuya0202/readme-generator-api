<?php

namespace App\Contexts\Auth\Domain\Exception;

use Exception;

class UserAlreadyExistsException extends Exception
{
    public function __construct(string $message = "このユーザーは既に存在しています。")
    {
        parent::__construct($message);
    }
}
