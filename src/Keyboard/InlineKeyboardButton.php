<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Keyboard;

final class InlineKeyboardButton
{
    private function __construct(
        private readonly string $text,
        private readonly ?string $callbackData,
        private readonly ?string $url
    ) {}

    public static function callback(string $text, string $data): self
    {
        return new self($text, $data, null);
    }

    public static function url(string $text, string $url): self
    {
        return new self($text, null, $url);
    }

    /**
     * @return array{text?: non-falsy-string, callback_data?: non-falsy-string, url?: non-falsy-string}
     */
    public function toArray(): array
    {
        return array_filter([
            'text' => $this->text,
            'callback_data' => $this->callbackData,
            'url' => $this->url,
        ]);
    }
}
