<?php

declare(strict_types=1);

namespace Aymericcucherousset\TelegramBot\Tests\Command;

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Command\AttributeCommandLoader;
use Aymericcucherousset\TelegramBot\Command\CommandRegistryInterface;
use Aymericcucherousset\TelegramBot\Command\CommandInterface;
use Aymericcucherousset\TelegramBot\Attribute\AsTelegramCommand;

/**
 * Test registry for command registration tracking
 */
class TestRegistry implements CommandRegistryInterface
{
    /**
     * @var array<int, array{string, CommandInterface}>
     */
    public array $calls = [];
    public function register(string $name, CommandInterface $command): void
    {
        $this->calls[] = [$name, $command];
    }
}


use Aymericcucherousset\TelegramBot\Command\CommandContext;

class PingCommand implements CommandInterface
{
    public function handle(CommandContext $context): void {}
}

#[AsTelegramCommand('ping')]
class PingCommandWithAttribute extends PingCommand {}

class StartCommand implements CommandInterface
{
    public function handle(CommandContext $context): void {}
}

#[AsTelegramCommand('start')]
class StartCommandWithAttribute extends StartCommand {}

final class AttributeCommandLoaderTest extends TestCase
{
    public function testRegistersCommandWithAttribute(): void
    {
        $command = new PingCommandWithAttribute();
        $registry = new TestRegistry();
        $loader = new AttributeCommandLoader();
        $loader->load([$command], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(1, $registry->calls);
        self::assertSame('ping', $registry->calls[0][0]);
        self::assertSame($command, $registry->calls[0][1]);
    }

    public function testIgnoresCommandWithoutAttribute(): void
    {
        $command = new PingCommand();
        $registry = new TestRegistry();
        $loader = new AttributeCommandLoader();
        $loader->load([$command], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(0, $registry->calls);
    }

    public function testRegistersMultipleCommands(): void
    {
        $ping = new PingCommandWithAttribute();
        $start = new StartCommandWithAttribute();
        $registry = new TestRegistry();
        $loader = new AttributeCommandLoader();
        $loader->load([$ping, $start], $registry);
        /** @var TestRegistry $registry */
        self::assertCount(2, $registry->calls);
        self::assertSame(['ping', $ping], $registry->calls[0]);
        self::assertSame(['start', $start], $registry->calls[1]);
    }
}
