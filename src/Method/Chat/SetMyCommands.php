<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Method\Chat;

use Aymericcucherousset\TelegramBot\Method\TelegramMethod;

/**
 * Represents the setMyCommands method for the Telegram Bot API.
 * @see https://core.telegram.org/bots/api#setmycommands
 *
 * @implements TelegramMethod<bool>
 */
final class SetMyCommands implements TelegramMethod
{
    /**
     * @param array<int, array<string, mixed>> $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands.
     * @param string|null $scope Optional. A JSON-serialized object, describing scope of users for which the commands are relevant.
     * @param string|null $languageCode Optional. A two-letter ISO 639-1 language code.
     */
    public function __construct(
        private readonly array $commands,
        private readonly ?string $scope = null,
        private readonly ?string $languageCode = null,
    ) {}

    public function getMethod(): string
    {
        return 'setMyCommands';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'commands' => $this->commands,
            'scope' => $this->scope,
            'language_code' => $this->languageCode,
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
