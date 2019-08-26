<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var string $message
     */
    private $message;
    /**
     * @var string $ipAddress
     */
    private $ipAddress;

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}
