<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Bot;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setMyShortDescription method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setmyshortdescription
 *
 * @implements TelegramMethod<bool>
 */
final class SetMyShortDescription implements TelegramMethod
{
    public function __construct(
        private readonly ?string $shortDescription = null,
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'setMyShortDescription';
    }

    /**
     * @return array{short_description?: string, language_code?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'short_description' => $this->shortDescription,
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
