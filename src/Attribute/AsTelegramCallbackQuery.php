<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AsTelegramCallbackQuery implements AsTelegramAttributeInterface
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $description = null,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
