<?php

namespace App\Common;

Use \PDO;
use PDOException;
use PDOStatement;

class Database
{
    /**
     * host connection with DB
     *
     * @var string
     */
    private string $host;

    /**
     * Db name
     *
     * @var string
     */
    private string $name;

    /**
     * DB user
     *
     * @var string
     */
    private string $user;

    /**
     * DB password
     *
     * @var string
     */
    private string $pass;

    /**
     * table name
     *
     * @var string
     */
    private string $table;

    /**
     * instance of database connection
     *
     * @var PDO
     */
    private PDO $connection;

    /**
     * define table and set database connection
     *
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->host = getEnv('DB_HOST');
        $this->name = getEnv('DB_DATABASE');
        $this->user = getEnv('DB_USERNAME');
        $this->pass = getEnv('DB_PASSWORD');
        $this->table=$table;
        $this->setConnection();
    }


    /**
     * Method responsible for setting up a database connection
     *
     */
    private function setConnection(): void
    {
      try {
          $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->name,$this->user,$this->pass);
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          die('Error: '.$e->getMessage());
      }
    }

    /**
     * Method responsible for execute queries into the database
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $query, array $params = []): PDOStatement
    {
       try {
           $statement = $this->connection->prepare($query);
           $statement->execute($params);
           return $statement;

       } catch (PDOException $e) {
        die('Error: '.$e->getMessage());
       }
    }

    /**
     * Method responsible for inserting data into the database
     *
     * @param array $values [ field => value ]
     * @return integer
     */
    public function insert(array $values): int
    {
        // handling query data
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        //build query
        $query = 'INSERT INTO '. $this->table . ' (' . implode(',',$fields) . ') VALUES (' . implode(',',$binds) . ');';

        //run query insert
        $this->execute($query, array_values($values));

        //return the id of the entered record
        return $this->connection->lastInsertId();
        
    }


    /**
     * Method responsible for fetching data from the database
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select(?string $where=null, ?string $order=null, ?string $limit=null, string $fields = '*'): PDOStatement
    {
        // handling query data
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //build query
        $query = 'SELECT '.$fields.' FROM ' . $this->table . ' '.$where.' '.$order.' '.$limit.';';

        //run query select
        return $this->execute($query);

    }

    /**
     * Method responsible for update data in the database
     *
     * @param string $where
     * @param array $values [field => value]
     * @return boolean
     */
    public function update(string $where,array $values): bool
    {
        // handling query data
        $fields = array_keys($values);

        //build query
        $query = 'UPDATE '. $this->table . ' SET ' . implode('=?,',$fields) . '=? WHERE ' . $where;

        //run query insert
        $this->execute($query, array_values($values));

        //return success
        return true;
    }

    /**
     * Method responsible for delete data from database
     *
     * @param string $where
     * @return boolean
     */
    public function delete(string $where): bool
    {
         //build query
         $query = 'DELETE FROM '. $this->table . ' WHERE ' . $where;

         //run query insert
         $this->execute($query);
 
         //return success
         return true;
    }
}