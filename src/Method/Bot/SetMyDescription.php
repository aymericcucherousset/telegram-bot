<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Bot;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setMyDescription method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setmydescription
 *
 * @implements TelegramMethod<bool>
 */
final class SetMyDescription implements TelegramMethod
{
    public function __construct(
        private readonly ?string $description = null,
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'setMyDescription';
    }

    /**
     * @return array{description?: string, language_code?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
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
