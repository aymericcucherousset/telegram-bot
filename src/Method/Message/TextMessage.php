<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;
use Aymericcucherousset\TelegramBot\Update\Message;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;

/**
 * @implements TelegramMethod<Message>
 */
final class TextMessage implements TelegramMethod
{
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $text,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
        private readonly ParseMode $mode = ParseMode::Plain
    ) {}

    public function getMethod(): string
    {
        return 'sendMessage';
    }

    /**
     * @return array{chat_id: int|string, text: string, parse_mode?: string, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $payload = [
            'chat_id' => $this->chatId->value(),
            'text' => $this->text,
        ];

        if ($this->mode->telegramValue() !== null) {
            $payload['parse_mode'] = $this->mode->telegramValue();
        }

        if ($this->keyboard !== null) {
            $payload['reply_markup'] = $this->keyboard->toArray();
        }

        return $payload;
    }

    /**
    * @param array{ok: bool, result: array{message_id: int, chat: array{id: int|string}, from?: array{id: int}, text?: string, date?: int}} $result
    *
    * @return Message
    */
    public function mapResponse(array $result): Message
    {
        return Message::fromTelegram($result['result']);
    }
}
