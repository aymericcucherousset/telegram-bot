<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Value\ChatId;

final class ChatIdTest extends TestCase
{
    public function testAcceptsInt(): void
    {
        $chatId = new ChatId(123);
        self::assertSame(123, $chatId->value());
    }

    public function testAcceptsString(): void
    {
        $chatId = new ChatId('@channel');
        self::assertSame('@channel', $chatId->value());
    }

    public function testRejectsEmptyString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ChatId('');
    }

    public function testEquals(): void
    {
        $id1 = new ChatId(123);
        $id2 = new ChatId(123);
        $id3 = new ChatId('@channel');
        self::assertTrue($id1->equals($id2));
        self::assertFalse($id1->equals($id3));
    }

    public function testToString(): void
    {
        $id = new ChatId(456);
        self::assertSame('456', (string) $id);
        $id2 = new ChatId('@channel');
        self::assertSame('@channel', (string) $id2);
    }
}
