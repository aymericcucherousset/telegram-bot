<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Message;

interface OutboundMessageInterface
{
    /**
     * @return mixed[]
     */
    public function toArray(): array;

    public function method(): string;
}
