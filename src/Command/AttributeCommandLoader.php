<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Command;

use Aymericcucherousset\TelegramBot\Attribute\AsTelegramCommand;
use ReflectionClass;
use Aymericcucherousset\TelegramBot\Command\CommandRegistryInterface;

final class AttributeCommandLoader
{
    /**
     * @param iterable<CommandInterface> $commands
     */
    public function load(
        iterable $commands,
        CommandRegistryInterface &$registry
    ): void {
        foreach ($commands as $command) {
            $reflection = new ReflectionClass($command);
            foreach ($reflection->getAttributes(AsTelegramCommand::class) as $attribute) {
                $config = $attribute->newInstance();

                $registry->register(
                    $config->name,
                    $command
                );
            }
        }
    }
}
