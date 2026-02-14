<?php

declare(strict_types=1);

use Aymericcucherousset\TelegramBot\Api\HttpTelegramClient;
use Aymericcucherousset\TelegramBot\Api\RequestFactoryInterface;
use Aymericcucherousset\TelegramBot\Exception\ApiException;
use Aymericcucherousset\TelegramBot\Method\Message\TextMessage;
use Aymericcucherousset\TelegramBot\Value\ChatId;
use Aymericcucherousset\TelegramBot\Value\ParseMode;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
                        && $data['chat_id'] === 123
                        && $data['text'] === 'hi'
                        && !isset($data['parse_mode']);
                })
            )
            ->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn(json_encode([
            'ok' => true,
            'result' => [
                'message_id' => 1,
                'chat' => ['id' => 123],
                'text' => 'hi',
                'date' => time(),
            ],
        ]));

        $http = $this->createMock(ClientInterface::class);
        $http->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            null,
            ParseMode::Plain
        );
        $client->send($message);
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
        $response->method('getBody')->willReturn(json_encode([
            'ok' => true,
            'result' => [
                'message_id' => 1,
                'chat' => ['id' => 123],
                'text' => 'hi',
                'date' => time(),
            ],
        ]));

        $http = $this->createMock(ClientInterface::class);
        $http->method('sendRequest')->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            null,
            ParseMode::Markdown
        );
        $client->send($message);
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
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            null,
            ParseMode::Plain
        );
        $client->send($message);
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
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            null,
            ParseMode::Plain
        );
        $client->send($message);
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
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            null,
            ParseMode::Plain
        );
        $client->send($message);
    }

    public function testSendMessageWithKeyboard(): void
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
                    return is_array($data)
                        && isset($data['chat_id'], $data['text'], $data['reply_markup'])
                        && $data['chat_id'] === 123
                        && $data['text'] === 'hi'
                        && is_array($data['reply_markup'])
                        && isset($data['reply_markup']['inline_keyboard']);
                })
            )
            ->willReturn($request);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn(json_encode([
            'ok' => true,
            'result' => [
                'message_id' => 1,
                'chat' => ['id' => 123],
                'text' => 'hi',
                'date' => time(),
            ],
        ]));

        $http = $this->createMock(ClientInterface::class);
        $http->expects(self::once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $client = $this->makeClient($http, $factory);
        $keyboard = new \Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardMarkup([
            [\Aymericcucherousset\TelegramBot\Keyboard\InlineKeyboardButton::callback('Test', 'cb')],
        ]);
        $message = new TextMessage(
            new ChatId(123),
            'hi',
            $keyboard,
            ParseMode::Plain
        );
        $client->send($message);
    }
}
