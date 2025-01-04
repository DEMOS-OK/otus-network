<?php

declare(strict_types=1);

namespace App\SocialNetwork\Infrastructure;

use PDO;

final readonly class PDOConnectionWrapper
{
    public function __construct(
        private PDO $writeConnection,
        private PDO $readConnection,
    ) {
    }

    public function write(): PDO
    {
        return $this->writeConnection;
    }

    public function read(): PDO
    {
        return $this->readConnection;
    }
}