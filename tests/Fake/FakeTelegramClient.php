<?php

declare(strict_types=1);

namespace Tests\Fake;

use Aymericcucherousset\TelegramBot\Api\TelegramClientInterface;
use Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;

class FakeTelegramClient implements TelegramClientInterface
{
    public function sendMessage(ChatId $chatId, string $text, ParseMode $mode = ParseMode::Plain, ?InlineKeyboardMarkup $keyboard = null): void {}
}
