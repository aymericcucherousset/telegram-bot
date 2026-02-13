<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

final class EditMessageText implements TelegramMethod
{
    public function __construct(
        private readonly ChatId $chatId,
        private readonly int $messageId,
        private readonly string $text,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
        private readonly ParseMode $mode = ParseMode::Plain
    ) {}

    public function getMethod(): string
    {
        return 'editMessageText';
    }

    /**
     * @return array{chat_id: int|string, text: string, parse_mode?: string, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $payload = [
            'chat_id' => $this->chatId->value(),
            'message_id' => $this->messageId,
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
}
