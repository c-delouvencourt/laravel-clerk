<?php

namespace CLDT\Clerk\Helpers;

class ClerkApiResponse
{

    protected int $statusCode = 200;
    protected bool $hasError = false;
    protected array $messages = [];

    protected array $data;

    public function __construct(int $statusCode, array $response = [], string $dataKey = null)
    {
        if ($statusCode < 200 || $statusCode >= 300) {
            $this->hasError = true;
            $this->messages = $response['errors'] ?? 'Unknown error';
            $this->statusCode = $statusCode;
            $this->data = [];
            return;
        }
        if (!isset($dataKey)) {
            $this->data = $response;
            return;
        }
        if (!isset($response[$dataKey])) {
            $this->data = [];
            return;
        }
        $this->data = $response[$dataKey];
    }

    public function hasError(): bool
    {
        return $this->hasError;
    }

    public function getMessage(): array
    {
        return $this->messages;
    }

    public function getFirstMessage(): string
    {
        return $this->messages[0]['message'] ?? "Unknown error";
    }

    public function getLastMessage(): string
    {
        return end($this->messages)['message'] ?? "Unknown error";
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFirst(): ?array
    {
        return $this->data[0] ?? null;
    }

    public function getLast(): ?array
    {
        return $this->data[count($this->data) - 1] ?? null;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function isPaginated(): bool
    {
        return isset($this->meta);
    }

    public function toArray(): array
    {
        $array = [
            'statusCode' => $this->statusCode,
            'hasError' => $this->hasError,
            'message' => $this->messages,
            'data' => $this->data
        ];

        return $array;
    }

    public function toString(): string
    {
        return json_encode($this->data);
    }

}