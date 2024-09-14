<?php

declare(strict_types=1);

namespace App\SocialNetwork\Domain\User\Entities;

use JsonException;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;

abstract class Entity implements Arrayable, JsonSerializable
{
    public static function make(): static
    {
        return new static();
    }

    /**
     * @throws JsonException
     */
    public function jsonSerialize(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}