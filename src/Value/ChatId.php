<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Value;

use Stringable;

final readonly class ChatId implements Stringable
{
    private int|string $value;

    public function __construct(int|string $value)
    {
        if ($value === '') {
            throw new \InvalidArgumentException('ChatId cannot be empty.');
        }

        $this->value = $value;
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function value(): int|string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
