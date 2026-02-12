<?php

namespace App\Http\Controllers\Api\Project;

use App\Contexts\Project\Application\UseCase\CreateProjectUseCase;
use App\Contexts\Project\Domain\DTO\CreateProjectInput;
use App\Contexts\Project\Domain\Exception\FailedGenerateReadmeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Create as CreateProjectRequest;
use App\Http\Responses\MutationResponse;

class Create extends Controller
{
    public function __construct(
        private readonly CreateProjectUseCase $createProjectUseCase
    ) {}

    public function __invoke(CreateProjectRequest $request)
    {
        try {
            $input = new CreateProjectInput(
                name: $request->input('name'),
                problem: $request->input('problem'),
                people: $request->input('people'),
                period: $request->input('period'),
                stack: $request->input('stack'),
                effort: $request->input('effort'),
                trouble: $request->input('trouble'),
            );

            $user = $request->user();

            $output = $this->createProjectUseCase->execute($input, $user);
            return MutationResponse::success(
                message: "プロジェクトの作成に成功しました。",
                data: [
                    'project_id' => $output->id
                ]
            );
        } catch (FailedGenerateReadmeException $e) {
            return MutationResponse::error(
                $e->getMessage(),
            );
        }
    }
}
