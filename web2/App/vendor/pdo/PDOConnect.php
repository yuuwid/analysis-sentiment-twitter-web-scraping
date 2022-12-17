<?php

namespace PDODB;

use PDO, PDOException;

class PDOConnect
{

    private $_pdo = null,
        $_stmt = null,
        $_results = null,
        $_error = [];


    public function __construct()
    {
        $host = env('DB_HOST', 'localhost');
        $port = env('DB_PORT', '3306');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $db_name = env('DB_NAME', 'test');

        $dbh = "mysql:host=$host;port=$port;dbname=$db_name";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        ];

        try {
            $this->_pdo = new PDO($dbh, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->_error['connect'] = $e->getMessage();
        }
    }

    public function __destruct()
    {
        return null;
    }


    public function query($query)
    {
        $this->_error = [];
        $this->_results = [];

        $this->_stmt = $this->_pdo->prepare($query);

        return $this;
    }

    public function execute(array $params = [])
    {
        foreach ($params as $param => $value) {
            $this->bind($param, $value);
        }

        try {
            $this->_results = $this->_stmt->execute();
            if (!$this->_results) {
                $this->_error = $this->_stmt->errorInfo();
            }
            return $this;
        } catch (PDOException $e) {
            $this->_error['execute'] = $e->getMessage();
            // Redirect::error('Database Error', $e->getMessage());
        }
    }

    public function fetch($fetchType = FETCH_DEFAULT)
    {
        try {
            if ($fetchType == FETCH_DEFAULT) {
                $this->_results = $this->_stmt->fetch(PDO::FETCH_ASSOC);
            } else if ($fetchType == FETCH_ALL) {
                $this->_results = $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $this->_results;
        } catch (PDOException $e) {
            $this->_error['fetch'] = $e->getMessage();
            // return null;
            // Redirect::error('Database Error', $e->getMessage());
        }
    }

    public function error()
    {
        return $this->_error;
    }

    private function bind($param, $value, $option = null)
    {
        if (is_null($option)) {
            switch ($value) {
                case is_int($value):
                    $option = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $option = PDO::PARAM_BOOL;
                    break;
                case is_string($value):
                    $option = PDO::PARAM_STR;
                    break;
                default:
                    $option = PDO::PARAM_STR;
            }
        }
        $this->_stmt->bindValue($param, $value, $option);
    }
}
