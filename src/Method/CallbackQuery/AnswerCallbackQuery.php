<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\CallbackQuery;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the answerCallbackQuery method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#answercallbackquery
 *
 * @implements TelegramMethod<bool>
 */
final class AnswerCallbackQuery implements TelegramMethod
{
    public function __construct(
        private readonly string $callbackQueryId,
        private readonly string $text,
        private readonly bool $showAlert = false,
    ) {}

    public function getMethod(): string
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
