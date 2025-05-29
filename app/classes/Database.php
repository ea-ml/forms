<?php

class Database {
    private static $instance = null;
    private $connection;
    private $config;

    private function __construct() {
        $configPath = __DIR__ . '/../config/database.php';
        
        
        if (!file_exists($configPath)) {
            throw new Exception("Database configuration file not found");
        }
        $this->config = require $configPath;
        
        if (!is_array($this->config)) {
            throw new Exception("Invalid database configuration format");
        }
        
        $required = ['host', 'dbname', 'username', 'password'];
        foreach ($required as $key) {
            if (!isset($this->config[$key])) {
                throw new Exception("Missing required database configuration key: {$key}");
            }
        }
        
        $this->connect();
    }

    private function connect() {
        try {
            
            $host = $this->config['host'];
            $port = $this->config['port'];
            $dsn = "mysql:host=$host;port=$port;dbname={$this->config['dbname']};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $this->connection = new PDO($dsn, $this->config['username'], $this->config['password'], $options);
            } catch (PDOException $e) {
                $error = [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'dsn' => $dsn,
                    'username' => $this->config['username']
                ];
                error_log("Database connection error: " . print_r($error, true));
                throw new PDOException("Connection failed: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
            }
        } catch (Exception $e) {
            die("Fatal database error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    public function commit() {
        return $this->connection->commit();
    }

    public function rollback() {
        return $this->connection->rollback();
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function insert($table, $data) {
        $fields = array_keys($data);
        $placeholders = array_map(function($field) {
            return ":$field";
        }, $fields);
        
        $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";
        
        return $this->query($sql, $data);
    }

    public function insertMany($table, $columns, $values) {
        $placeholders = [];
        $flattenedValues = [];
        
        foreach ($values as $index => $row) {
            $rowPlaceholders = [];
            foreach ($row as $colIndex => $value) {
                $param = ":param{$index}_{$colIndex}";
                $rowPlaceholders[] = $param;
                $flattenedValues[$param] = $value;
            }
            $placeholders[] = "(" . implode(", ", $rowPlaceholders) . ")";
        }

        $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") 
                VALUES " . implode(", ", $placeholders);

        return $this->query($sql, $flattenedValues);
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
} 