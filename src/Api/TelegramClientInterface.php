<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Api;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;

interface TelegramClientInterface
{
    public function sendMessage(
        ChatId $chatId,
        string $text,
        ParseMode $mode = ParseMode::Plain
    ): void;
}
