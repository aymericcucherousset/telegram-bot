<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AsTelegramCommand
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly bool $adminOnly = false
    ) {}
}
