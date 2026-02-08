<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;
use Aymericcucherousset\TelegramBot\Api\HttpTelegramClient;
use Aymericcucherousset\TelegramBot\Exception\ApiException;
use Aymericcucherousset\TelegramBot\Api\RequestFactoryInterface;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
final class HttpTelegramClientTest extends TestCase
{
    private function makeClient(
        ?ClientInterface $http = null,
        ?RequestFactoryInterface $factory = null,
        string $token = 'TOKEN'
    ): HttpTelegramClient {
        return new HttpTelegramClient(
            $http ?? $this->createMock(ClientInterface::class),
            $factory ?? $this->createMock(RequestFactoryInterface::class),
            $token
        );
    }

    public function testSendMessageSendsPostWithCorrectPayload(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $factory = $this->createMock(RequestFactoryInterface::class);
        $factory->expects(self::once())
            ->method('create')
            ->with(
                'POST',
                self::stringContains('/botTOKEN/sendMessage'),
                self::arrayHasKey('Content-Type'),
                self::callback(static function ($json) {
                    /** @var string $json */
                    $data = json_decode($json, true);
                    if (!is_array($data)) {
                        return false;
                    }
                    return isset($data['chat_id'], $data['text'])
                        && $data['chat_id'] === '123'
                        && $data['text'] === 'hi'
                        && !isset($data['parse_mode']);
                })
            )
            ->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn(json_encode(['ok' => true]));

        $http = $this->createMock(ClientInterface::class);
        $http->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $client->sendMessage(new ChatId(123), 'hi', ParseMode::Plain);
    }

    public function testSendMessageIncludesParseModeIfNotPlain(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $factory = $this->createMock(RequestFactoryInterface::class);
        $factory->expects(self::once())
            ->method('create')
            ->with(
                'POST',
                self::stringContains('/botTOKEN/sendMessage'),
                self::arrayHasKey('Content-Type'),
                self::callback(static function ($json) {
                    /** @var string $json */
                    $data = json_decode($json, true);
                    return is_array($data) && isset($data['parse_mode']) && $data['parse_mode'] === 'Markdown';
                })
            )
            ->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn(json_encode(['ok' => true]));

        $http = $this->createMock(ClientInterface::class);
        $http->method('sendRequest')->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $client->sendMessage(new ChatId(123), 'hi', ParseMode::Markdown);
    }

    public function testHttpExceptionIsWrapped(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $factory = $this->createMock(RequestFactoryInterface::class);
        $factory->method('create')->willReturn($request);

        $http = $this->createMock(ClientInterface::class);
        $http->method('sendRequest')->willThrowException($this->createMock(ClientExceptionInterface::class));

        $client = $this->makeClient($http, $factory);
        $this->expectException(ApiException::class);
        $client->sendMessage(new ChatId(123), 'hi');
    }

    public function testNon200StatusThrows(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $factory = $this->createMock(RequestFactoryInterface::class);
        $factory->method('create')->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(500);
        $response->method('getBody')->willReturn('fail');

        $http = $this->createMock(ClientInterface::class);
        $http->method('sendRequest')->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $this->expectException(ApiException::class);
        $client->sendMessage(new ChatId(123), 'hi');
    }

    public function testJsonOkFalseThrows(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $factory = $this->createMock(RequestFactoryInterface::class);
        $factory->method('create')->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn(json_encode(['ok' => false, 'description' => 'fail']));

        $http = $this->createMock(ClientInterface::class);
        $http->method('sendRequest')->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $this->expectException(ApiException::class);
        $client->sendMessage(new ChatId(123), 'hi');
    }
}
