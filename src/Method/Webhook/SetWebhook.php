<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Webhook;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setWebhook method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setwebhook
 *
 * @implements TelegramMethod<bool>
 */
final class SetWebhook implements TelegramMethod
{
    /**
     * @param ?array<int, string> $allowedUpdates
     */
    public function __construct(
        private readonly string $url,
        private readonly ?array $allowedUpdates = null,
        private readonly ?string $secretToken = null,
    ) {}

    public function getMethod(): string
    {
        return 'setWebhook';
    }

    /**
     * @return array{url: string, allowed_updates?: array<int, string>, secret_token?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'url' => $this->url,
            'allowed_updates' => $this->allowedUpdates,
            'secret_token' => $this->secretToken,
        ], static fn($v) => $v !== null);
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
