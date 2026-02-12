<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Loader;

use Aymericcucherousset\TelegramBot\Attribute\AsTelegramAttributeInterface;
use ReflectionClass;
use Aymericcucherousset\TelegramBot\Handler\HandlerInterface;
use Aymericcucherousset\TelegramBot\Registry\HandlerRegistryInterface;

final class AttributeHandlerLoader
{
    /**
     * @param iterable<HandlerInterface> $handlers
     */
    public function load(
        iterable $handlers,
        HandlerRegistryInterface &$registry
    ): void {
        foreach ($handlers as $handler) {
            $reflection = new ReflectionClass(objectOrClass: $handler);
            foreach ($reflection->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();
                if ($instance instanceof AsTelegramAttributeInterface) {
                    $registry->register(
                        $instance->getName(),
                        $handler
                    );
                }
            }
        }
    }
}
