<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Update;

use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\UserId;

final readonly class Message
{
    /**
     * @param array{message_id: int, chat: array{id: int|string}, from?: array{id: int}, text?: string, date?: int} $data
     * @return Message
     */
    public static function fromTelegram(array $data): self
    {
        return new self(
            id: $data['message_id'],
            chatId: new ChatId($data['chat']['id']),
            fromUserId: isset($data['from']['id']) ? new UserId($data['from']['id']) : null,
            text: $data['text'] ?? null,
            date: $data['date'] ?? null
        );
    }

    public function __construct(
        public int $id,
        public ChatId $chatId,
        public ?UserId $fromUserId,
        public ?string $text,
        public ?int $date = null
    ) {}

    /**
     * Indicates if the message is a Telegram command (/start, /ping, etc.)
     */
    public function isCommand(): bool
    {
        if ($this->text === null) {
            return false;
        }

        return str_starts_with(trim($this->text), '/');
    }

    /**
     * Return the name of the command without arguments
     * Ex: "/start test" => "start"
     * Ex: "/ping@my_bot" => "ping"
     */
    public function commandName(): string
    {
        if (!$this->isCommand()) {
            throw new \LogicException('Message is not a command.');
        }

        $text = trim((string) $this->text);

        $text = ltrim($text, '/');
        $text = explode(' ', $text, 2)[0];

        return explode('@', $text, 2)[0];
    }

    /**
     * Return an array of strings representing the arguments passed to the command.
     * Ex: "/ban user42 now" => ["user42", "now"]
     *
     * @return string[]
     */
    public function commandArguments(): array
    {
        if (!$this->isCommand()) {
            return [];
        }

        $parts = explode(' ', trim((string) $this->text));

        array_shift($parts);

        return array_values(array_filter($parts));
    }
}
