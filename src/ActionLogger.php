<?php

namespace Paitoncamp\FusioLogger;

use Doctrine\DBAL\Connection;

class ActionLogger
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function log($message)
    {
        $this->connection->insert('action_log', [
            'message' => $message,
        ]);
    }
}