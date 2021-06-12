<?php

namespace Paitoncamp\Fusiologger;

use Doctrine\DBAL\Connection;
use ActionLogger;

class DBCreator
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;
	
	/**
     * @var ActionLogger
     */
	 protected $dbCreatorLogger;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
		$this->dbCreatorLogger = new ActionLogger($connection);
    }


	public function createDatabase($name, array $config)
	{
		/** @var \Doctrine\DBAL\Connection */
		$tmpConnection = \Doctrine\DBAL\DriverManager::getConnection($config);

		// Check if the database already exists
		if (in_array($name, $tmpConnection->getSchemaManager()->listDatabases())) {
			return;
		}

		// Create the database
		$tmpConnection->getSchemaManager()->createDatabase($name);
		$tmpConnection->close();
	}
}