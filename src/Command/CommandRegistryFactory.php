<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

final class CommandRegistryFactory
{
    /**
     * @param iterable<CommandInterface> $commands
     */
    public function create(iterable $commands): CommandRegistryInterface
    {
        $registry = new CommandRegistry();

        $loader = new AttributeCommandLoader();
        $loader->load($commands, $registry);

        return $registry;
    }
}
