<?php

namespace App\Http\Controllers\Api\Project;

use App\Contexts\Project\Application\UseCase\ChatProjectUseCase;
use App\Contexts\Project\Domain\DTO\ChatProjectInput;
use App\Contexts\Project\Domain\Exception\FailedGenerateReadmeException;
use App\Contexts\Project\Domain\Exception\PermissionDeniedException;
use App\Contexts\Project\Domain\Exception\ProjectNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Chat as ChatProjectRequest;
use App\Http\Responses\MutationResponse;

class Chat extends Controller
{
    public function __construct(
        private readonly ChatProjectUseCase $chatProjectUseCase
    ) {}

    public function __invoke(ChatProjectRequest $request, string $projectId)
    {
        try {
            $input = new ChatProjectInput(
                projectId: $projectId,
                message: $request->input('message'),
            );

            $user = $request->user();

            $this->chatProjectUseCase->execute($input, $user);

            return MutationResponse::success(
                message: "README.mdを更新しました。"
            );
        } catch (ProjectNotFoundException $e) {
            return MutationResponse::error(
                message: $e->getMessage(),
                statusCode: 404
            );
        } catch (PermissionDeniedException $e) {
            return MutationResponse::error(
                message: $e->getMessage(),
                statusCode: 403
            );
        } catch (FailedGenerateReadmeException $e) {
            return MutationResponse::error(
                message: $e->getMessage(),
            );
        }
    }
}
