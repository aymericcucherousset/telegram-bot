<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Keyboard;

final class InlineKeyboardMarkup
{
    /**
     * @param InlineKeyboardButton[][] $rows
     */
    public function __construct(
        private readonly array $rows
    ) {}

    /**
     * @return array{
     *  inline_keyboard: array<array<array{
     *      text?: non-falsy-string,
     *      callback_data?: non-falsy-string,
     *      url?: non-falsy-string
     * }>>}
     */
    public function toArray(): array
    {
        return [
            'inline_keyboard' => array_map(
                static fn(array $row) => array_map(
                    static fn(InlineKeyboardButton $button) => $button->toArray(),
                    $row
                ),
                $this->rows
            ),
        ];
    }
}
