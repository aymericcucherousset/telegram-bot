<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Bot;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setMyName method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setmyname
 *
 * @implements TelegramMethod<bool>
 */
final class SetMyName implements TelegramMethod
{
    public function __construct(
        private readonly ?string $name = null,
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'setMyName';
    }

    /**
     * @return array{name?: string, language_code?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'language_code' => $this->languageCode,
        ]);
    }

    /**
    * @param array{ok: bool} $result
    *
    * @return bool
    */
    public function mapResponse(array $result): bool
    {
        return $result['ok'];
    }
}
