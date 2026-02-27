<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Message;

use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the sendDocument method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#senddocument
 *
 * @implements TelegramMethod<bool>
 */
final class SendDocument implements TelegramMethod
{
    /**
     * @param ChatId $chatId
     * @param string $document Path to document, URL, or file resource
     * @param string|null $caption
     * @param InlineKeyboardMarkup|null $keyboard
     */
    public function __construct(
        private readonly ChatId $chatId,
        private readonly string $document,
        private readonly ?string $caption = null,
        private readonly ?InlineKeyboardMarkup $keyboard = null,
    ) {}

    public function getMethod(): string
    {
        return 'sendDocument';
    }

    /**
     * @return array{chat_id: int|string, document: string|resource, caption?: string, reply_markup?: array{inline_keyboard: array<array<array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}>>}}
     */
    public function toArray(): array
    {
        $isLocalFile = !str_contains($this->document, 'http://') && !str_contains($this->document, 'https://') && file_exists($this->document);
        $document = $isLocalFile ? fopen($this->document, 'r') : $this->document;
        if (false === $document) {
            throw new \RuntimeException("Failed to open local file: {$this->document}");
        }
        $payload = [
            'chat_id' => $this->chatId->value(),
            'document' => $document,
        ];
        if ($this->caption) {
            $payload['caption'] = $this->caption;
        }
        if ($this->keyboard) {
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
