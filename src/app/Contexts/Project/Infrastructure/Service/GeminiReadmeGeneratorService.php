<?php

namespace App\Contexts\Project\Infrastructure\Service;

use App\Contexts\Project\Domain\DTO\GenerateReadmeOutput;
use App\Contexts\Project\Domain\Service\GenerateReadmeServiceInterface;
use Gemini\Laravel\Facades\Gemini;

class GeminiReadmeGeneratorService implements GenerateReadmeServiceInterface
{
    public function generate(string $title, string $problem, int $people, string $period, string $stack, string $effort, string $trouble): GenerateReadmeOutput
    {
        $prompt = $this->buildPrompt($title, $problem, $people, $period, $stack, $effort, $trouble);

        $result = Gemini::generativeModel(
            model: 'gemini-2.5-flash',
            GenerationConfig: [
                'responseMimeType' => 'application/json',
                'responseSchema' => [
                    'type' => 'object',
                    'properties' => [
                        'summary' => [
                            'type' => 'string',
                            'description' => 'プロジェクトの要約'
                        ],
                        'markdown' => [
                            'type' => 'string',
                            'description' => 'Markdown形式のREADME.md'
                        ]
                    ],
                    'required' => ['summary', 'markdown']
                ]
            ]
        )->generateContent($prompt);

        $data = json_decode($result->text(), true);

        return new GenerateReadmeOutput(
            summary: $data['summary'] ?? '',
            markdown: $data['markdown'] ?? '',
        );
    }


    private function buildPrompt(
        string $title,
        string $problem,
        int $people,
        string $period,
        string $stack,
        string $effort,
        string $trouble,
    ): string {
        return <<<prompt
        今から与えられたプロジェクト情報をもとに、README.mdを生成してください。

        詳細については以下の通りです。
        1. ユーザーからのプロダクトの概要をもとにプロダクトについて理解し、どのように受け取ったかを要約として出力し、その後markdown形式でプロダクトのREADME.mdを生成してください。
        2. よって、出力するものは文字列としての要約とmarkdown形式のREADME.mdです。
        3. 技術スタックに関しては与えられた技術スタックをもとにフロントエンドなのか、バックエンドなのか等を判断し、それらをREADME.mdに反映してください。
        4. 技術スタックはshield.ioを使用し、その技術スタックにあったshieldを生成してください(例 : ![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB))
        5. 技術スタックのshield.ioの使用をやめるように言われた場合は、shield.ioを使用せずにそのまま技術スタックを反映してください。
        6. 与えられたプロジェクトの情報をそのまま受け取って反映させるのではなく、その情報の意図を汲み取り、適切な日本語に変換して反映してください。

        与えられたプロジェクトに関しては以下の通りです。
        - アプリ名: {$title}
        - 解決したい課題: {$problem}
        - チーム人数: {$people}人
        - 開発期間: {$period}
        - 技術スタック: {$stack}
        - 工夫した点: {$effort}
        - 苦労した点: {$trouble}

        JSONスキーマ通りに出力してください。
        prompt;
    }
}
