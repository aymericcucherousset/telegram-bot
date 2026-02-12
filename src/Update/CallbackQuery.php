<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Update;

use Aymericcucherousset\TelegramBot\Value\ChatId;

final class CallbackQuery
{
    public function __construct(
        public string $id,
        public string $data,
        public ChatId $chatId,
    ) {}
}
