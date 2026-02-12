<?php

namespace App\Contexts\Project\Domain\Exception;

use Exception;

class FailedGenerateReadmeException extends Exception
{
    public function __construct(string $message = "README.mdの生成に失敗しました。")
    {
        return parent::__construct($message);
    }
}
