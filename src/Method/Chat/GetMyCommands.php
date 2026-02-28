<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getMyCommands method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getmycommands
 *
 * @implements TelegramMethod<array<int, array<string, mixed>>>
 */
final class GetMyCommands implements TelegramMethod
{
    /**
     * @param string|null $scope Optional. A JSON-serialized object, describing scope of users for which the commands are relevant.
     * @param string|null $languageCode Optional. A two-letter ISO 639-1 language code.
     */
    public function __construct(
        private readonly ?string $scope = null,
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'getMyCommands';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'scope' => $this->scope,
            'language_code' => $this->languageCode,
        ], static fn($v) => $v !== null);
    }

    /**
     * @param array{ok: bool, result: array<int, array<string, mixed>>} $result
     *
     * @return array<int, array<string, mixed>>
     */
    public function mapResponse(array $result): array
    {
        return $result['result'] ?? [];
    }
}
