<?php

namespace App\Http\Controllers\Api\Project;

use App\Contexts\Index\Application\UseCase\IndexProjectUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function __construct(
        readonly private IndexProjectUseCase $indexProjectUseCase
    ) {}
    public function __invoke(Request $request)
    {
        $output = $this->indexProjectUseCase->execute($request->user());
        return response()->json($output, 200);
    }
}
