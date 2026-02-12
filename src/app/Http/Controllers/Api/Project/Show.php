<?php

namespace App\Http\Controllers\Api\Project;

use App\Contexts\Project\Application\UseCase\ShowProjectUseCase;
use App\Contexts\Project\Domain\Exception\PermissionDeniedException;
use App\Contexts\Project\Domain\Exception\ProjectNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Show extends Controller
{
    public function __construct(
        private readonly ShowProjectUseCase $showProjectUseCase
    ) {}

    public function __invoke(Request $request, string $projectId)
    {
        $user = $request->user();

        try {
            $output = $this->showProjectUseCase->execute($projectId, $user);
            return response()->json($output, 200);
        } catch (ProjectNotFoundException $e) {
            return response('', 404);
        } catch (PermissionDeniedException $e) {
            return response('', 403);
        }
    }
}
