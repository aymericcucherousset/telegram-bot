<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aymericcucherousset\TelegramBot\Value\UserId;

final class UserIdTest extends TestCase
{
    public function testAcceptsPositiveInt(): void
    {
        $userId = new UserId(1);
        self::assertSame(1, $userId->value());
    }

    public function testRejectsZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserId(0);
    }

    public function testRejectsNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserId(-5);
    }

    public function testEquals(): void
    {
        $id1 = new UserId(10);
        $id2 = new UserId(10);
        $id3 = new UserId(20);
        self::assertTrue($id1->equals($id2));
        self::assertFalse($id1->equals($id3));
    }
}
