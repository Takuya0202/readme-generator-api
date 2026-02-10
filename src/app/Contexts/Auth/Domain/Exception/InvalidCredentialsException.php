<?php

namespace App\Contexts\Auth\Domain\Exception;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function __construct(string $message = "メールアドレスとパスワードが一致しません")
    {
        return parent::__construct($message);
    }
}
