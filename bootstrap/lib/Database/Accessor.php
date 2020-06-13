<?php

/**
 * 這是一個被包裝的範例
 *
 * @author Shisha 2019-10-27
 * @license MIT
 */

namespace Database;

use PDO;

class Accessor
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param  array  $config
     */
    public function config(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 連接資料庫
     * 
     * @param  array  $config
     * @return $this
     * @throws Exception
     */
    public function connect($config = [])
    {
        $config = array_merge($this->config, $config);

        $host = $config['host'] ?? '127.0.0.1';
        $port = $config['port'] ?? '8889';
        $charset = $config['charset'] ?? 'utf8';
        $database = $config['database'] ?? 'sa';
        $username = $config['username'] ?? 'root';
        $password = $config['password'] ?? 'root';

        try {
            $this->connection = new PDO(
                "mysql:host={$host};port={$port};charset={$charset};dbname={$database}",
                $username,
                $password
            );
        } catch (\Exception $exce) {
            throw new \Exception("資料庫連線失敗: {$exce->getMessage()}");
        }

        return $this;
    }

    /**
     * 中斷連接資料庫
     * 
     * @return void
     */
    public function disconnect()
    {
        if ($this->connection instanceof PDO) {
            $this->connection->close();
        }

        $this->connection = null;
    }

    /**
     * 取得 PDO 實體
     * 
     * @return \PDO
     */
    public function getConnection()
    {
        // 若還未初始，則進行連線
        if (!($this->connection instanceof PDO)) {
            $this->connect();
        }

        return $this->connection;
    }

    /**
     * 動態呼叫 PDO 的方法。
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getConnection()->{$method}(...$parameters);
    }

    /* =========================================================================
     * = Helpers
     * =========================================================================
    **/

    /**
     * 取得資料表全部結果
     * 
     * @param  string  $tableName
     * @return array
     */
    public function fetchAll($tableName)
    {
        $query = $this->getConnection()
            ->prepare("SELECT * FROM `{$tableName}`");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 取得資料表欄位符合條件的第一筆查詢結果，若欄位為空則預設為id
     * 
     * @param  string  $tableName
     * @param  string  $id
     * @return array
     */
    public function find($tableName, $data, $fieldName = null)
    {
        $table = strtoupper($tableName);
        $field = strtoupper($fieldName ?? "{$tableName}_id");

        $query = $this->getConnection()
            ->prepare("SELECT * FROM `{$table}` WHERE $field = '{$data}'");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 獲取資料陣列新增至指定資料表
     * 
     * @param  string  $tableName
     * @param  array  $data
     * @return boolean
     */
    public function create($tableName, $data)
    {
        $insertFields = implode(",", array_keys($data));
        $insertValues = implode(",:", array_keys($data));

        $query = $this->getConnection()
            ->prepare("INSERT INTO `{$tableName}`({$insertFields}) VALUES (:{$insertValues})");

        return $query->execute($data);
    }

    /**
     * 獲取資料陣列新增至指定資料表
     * 
     * @param  string  $tableName
     * @param  string   $whereData
     * @param  array   $newData
     * @return boolean
     */
    public function update($tableName, $where, $newData)
    {
        $setArray = function($field) {
            return "`{$field}` = :{$field}";
        };
       
        $updateData = implode(",", array_map($setArray, array_keys($newData)));
        
        $query = $this->getConnection()
            ->prepare("UPDATE {$tableName} SET {$updateData} WHERE {$where}");

        return $query->execute($newData);
    }
}
