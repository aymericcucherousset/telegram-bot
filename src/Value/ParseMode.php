<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Value;

enum ParseMode: string
{
    case Plain = 'plain';
    case Markdown = 'Markdown';
    case MarkdownV2 = 'MarkdownV2';
    case HTML = 'HTML';

    public function telegramValue(): ?string
    {
        return match ($this) {
            self::Plain => null,
            self::Markdown => 'Markdown',
            self::MarkdownV2 => 'MarkdownV2',
            self::HTML => 'HTML',
        };
    }
}
