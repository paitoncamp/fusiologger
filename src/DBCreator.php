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
			$this->dbCreatorLogger->log('Fail to create database '.$name. '!, its already exist!');
			return;
		}

		// Create the database
		
		$tmpConnection->getSchemaManager()->createDatabase($name);
		$this->dbCreatorLogger->log('Database '.$name. ' created!');
		$tmpConnection->close();
	}
}