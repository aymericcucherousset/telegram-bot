<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Aymericcucherousset\TelegramBot\Api\PsrRequestFactoryAdapter;
use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactory;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
final class PsrRequestFactoryAdapterTest extends TestCase
{
    public function testCreateDelegatesToPsrFactoryAndAppliesHeadersAndBody(): void
    {
        $psrFactory = $this->createMock(PsrRequestFactory::class);
        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $stream = $this->createMock(\Psr\Http\Message\StreamInterface::class);

        $psrFactory->expects(self::once())
            ->method('createRequest')
            ->with('POST', 'https://example.com')
            ->willReturn($request);

        $requestWithHeader1 = $this->createMock(RequestInterface::class);
        $requestWithHeader2 = $this->createMock(RequestInterface::class);

        $request->expects(self::once())
            ->method('withHeader')
            ->with('X-Test', 'abc')
            ->willReturn($requestWithHeader1);

        $requestWithHeader1->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($requestWithHeader2);

        $streamFactory->expects(self::once())
            ->method('createStream')
            ->with('body-content')
            ->willReturn($stream);

        $requestWithHeader2->expects(self::once())
            ->method('withBody')
            ->with($stream)
            ->willReturnSelf();

        $adapter = new PsrRequestFactoryAdapter($psrFactory, $streamFactory);
        $result = $adapter->create(
            'POST',
            'https://example.com',
            ['X-Test' => 'abc', 'Content-Type' => 'application/json'],
            'body-content'
        );

        self::assertInstanceOf(RequestInterface::class, $result);
    }

    public function testCreateWithoutBody(): void
    {
        $psrFactory = $this->createMock(PsrRequestFactory::class);
        $streamFactory = $this->createMock(StreamFactoryInterface::class);
        $request = $this->createMock(RequestInterface::class);

        $psrFactory->expects(self::once())
            ->method('createRequest')
            ->with('GET', 'https://example.com')
            ->willReturn($request);

        $request->expects(self::once())
            ->method('withHeader')
            ->with('X-Test', 'abc')
            ->willReturnSelf();

        $streamFactory->expects(self::never())
            ->method('createStream');

        $request->expects(self::never())
            ->method('withBody');

        $adapter = new PsrRequestFactoryAdapter($psrFactory, $streamFactory);
        $result = $adapter->create(
            'GET',
            'https://example.com',
            ['X-Test' => 'abc']
        );

        self::assertInstanceOf(RequestInterface::class, $result);
    }
}
