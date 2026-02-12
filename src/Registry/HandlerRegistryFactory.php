<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Registry;

use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Loader\AttributeHandlerLoader;

final class HandlerRegistryFactory
{
    /**
     * @param iterable<HandlerInterface> $handlers
     */
    public function create(iterable $handlers): HandlerRegistryInterface
    {
        $registry = new HandlerRegistry();

        $loader = new AttributeHandlerLoader();
        $loader->load($handlers, $registry);

        return $registry;
    }
}
