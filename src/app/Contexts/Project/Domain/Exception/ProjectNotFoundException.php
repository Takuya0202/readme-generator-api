<?php

namespace App\Contexts\Project\Domain\Exception;

use Exception;

class ProjectNotFoundException extends Exception
{
    public function __construct(string $message = "プロジェクトが見つかりません")
    {
        parent::__construct($message);
    }
}
