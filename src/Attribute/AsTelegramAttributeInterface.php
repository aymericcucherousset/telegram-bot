<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Attribute;

interface AsTelegramAttributeInterface
{
    public function getName(): string;
    public function getDescription(): ?string;
}
