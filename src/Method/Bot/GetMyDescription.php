<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Bot;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the getMyDescription method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#getmydescription
 *
 * @implements TelegramMethod<string>
 */
final class GetMyDescription implements TelegramMethod
{
    public function __construct(
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'getMyDescription';
    }

    /**
     * @return array{language_code?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'language_code' => $this->languageCode,
        ]);
    }

    /**
    * @param array{ok: bool, result: array{description: string, language_code: string}} $result
    *
    * @return string
    */
    public function mapResponse(array $result): string
    {
        return $result['result']['description'];
    }
}
