<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendPhoto method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#sendphoto
 *
 * @implements TelegramMethod<bool>
 */
final class PhotoMessage implements TelegramMethod
{
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $photo,
        private readonly ?string $caption = null,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendPhoto';
    }

    /**
     * @return array{chat_id: int|string, photo: string, caption?: string, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $payload = [
            'chat_id' => $this->chatId->value(),
            'photo' => $this->photo,
        ];

        if ($this->caption !== null) {
            $payload['caption'] = $this->caption;
        }

        if ($this->keyboard !== null) {
            $payload['reply_markup'] = $this->keyboard->toArray();
        }

        return $payload;
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
