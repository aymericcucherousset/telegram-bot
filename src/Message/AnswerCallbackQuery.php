<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Message;

final class AnswerCallbackQuery implements OutboundMessageInterface
{
    public function __construct(
        private readonly string $callbackQueryId,
        private readonly string $text,
        private readonly bool $showAlert = false,
    ) {}

    public function method(): string
    {
        return 'answerCallbackQuery';
    }

    /**
     * @return array{callback_query_id?: non-falsy-string, text?: non-falsy-string, show_alert?: true}
     */
    public function toArray(): array
    {
        return array_filter([
            'callback_query_id' => $this->callbackQueryId,
            'text' => $this->text,
            'show_alert' => $this->showAlert,
        ]);
    }
}
