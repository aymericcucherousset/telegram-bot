<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Value;

use Stringable;

final readonly class UserId implements Stringable
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('UserId must be a positive integer.');
        }

        $this->value = $value;
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function value(): int
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
