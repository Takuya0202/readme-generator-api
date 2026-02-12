<?php

namespace App\Contexts\Project\Infrastructure\Service;

use App\Contexts\Project\Domain\DTO\GenerateReadmeOutput;
use App\Contexts\Project\Domain\Service\GenerateReadmeService;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\GenerationConfig;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;

class GeminiReadmeGeneratorService implements GenerateReadmeService
{
    public function generate(string $name, string $problem, int $people, string $period, string $stack, ?string $effort, ?string $trouble): GenerateReadmeOutput
    {
        $prompt = $this->buildPrompt($name, $problem, $people, $period, $stack, $effort, $trouble);

        $result = Gemini::generativeModel(model: 'gemini-2.5-flash')
            ->withGenerationConfig(
                generationConfig: new GenerationConfig(
                    responseMimeType: ResponseMimeType::APPLICATION_JSON,
                    responseSchema: new Schema(
                        type: DataType::OBJECT,
                        properties: [
                            'summary' => new Schema(
                                type: DataType::STRING,
                                description: 'プロジェクトの要約'
                            ),
                            'markdown' => new Schema(
                                type: DataType::STRING,
                                description: 'Markdown形式のREADME.md。改行は\\nとして含める。'
                            )
                        ],
                        required: ['summary', 'markdown']
                    )
                )
            )
            ->generateContent($prompt);
        $data = json_decode($result->text(), true);

        return new GenerateReadmeOutput(
            summary: $data['summary'] ?? '',
            markdown: $data['markdown'] ?? '',
        );
    }


    private function buildPrompt(
        string $name,
        string $problem,
        int $people,
        string $period,
        string $stack,
        ?string $effort,
        ?string $trouble,
    ): string {
        // nullの場合は「特になし」に変換
        $effortText = $effort ?? '特になし';
        $troubleText = $trouble ?? '特になし';

        return <<<prompt
        あなたはプロフェッショナルなREADME.md作成者です。
        以下のプロジェクト情報をもとに、高品質なREADME.mdを生成してください。

        ## 出力形式
        - summary: プロジェクトの簡潔な要約（1〜2文）
        - markdown: 完全なREADME.mdの内容（Markdown形式）

        ## README.mdの構成
        1. # プロジェクト名
        2. ## 概要（プロジェクトが解決する課題を含む）
        3. ## 解決する課題（具体的に箇条書きで）
        4. ## 特徴
        5. ## 使用技術（技術スタックをshield.ioバッジで表示し、カテゴリ分け）
        6. ## 開発体制（チーム人数と開発期間）
        7. ## 工夫した点（あれば）
        8. ## 苦労した点（あれば）
        9. ## 使い方
        10. ## 貢献
        11. ## ライセンス

        ## 技術スタックの表示ルール
        - shield.ioを使用してバッジを生成
        - 例: ![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB)
        - フロントエンド、バックエンド、データベース、インフラ、その他などに適切に分類
        - カテゴリごとに見出し（### フロントエンドなど）を付ける

        ## 重要な注意事項
        - markdownフィールド内の改行は\\nとして表現してください
        - 与えられた情報を自然で読みやすい日本語に変換してください
        - プロフェッショナルで見栄えの良い構成にしてください
        - 情報が「特になし」の場合は、その項目は省略してください

        ## プロジェクト情報
        - アプリ名: {$name}
        - 解決したい課題: {$problem}
        - チーム人数: {$people}人
        - 開発期間: {$period}
        - 技術スタック: {$stack}
        - 工夫した点: {$effortText}
        - 苦労した点: {$troubleText}

        JSONスキーマに従って出力してください。
        prompt;
    }
}
