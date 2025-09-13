<?php

declare(strict_types=1);

namespace Bin\Model;
abstract class Model
{
    private static $connection;

    protected $table;
    protected static $resultType;

    public function __construct()
    {

    }

    public static function getConnection()
    {
        if (null !== self::$connection) {
            return self::$connection;
        }

        $config = self::getDBConfig();

        if (empty($config) || $config['host'] === null || $config['port'] === null || $config['pass'] === null || $config['user'] === null || $config['dbname'] === null) {
            throw new \Exception('DB Config is invalid');
        }

        $conConfig = [
            'dsn' => $config['driver'] . ':dbname=' .$config['dbname'] . ';host=' . $config['host'],
            'user' => $config['user'],
            'password' => $config['pass']
        ];

        return self::$connection = (new Connection($conConfig))->connection();
    }

    private static function getDBConfig()
    {
        $driver = config('db:driver');
        self::$resultType = config('db:resultType');

        return array_merge(config('db:connection:' . $driver), ['driver' => $driver, 'resultType' => self::$resultType]);
    }

    final public static function select($sql, $data)
    {
        return self::action($sql, $data);
    }

    final public static function update($sql, $data)
    {
        return self::action($sql, $data);
    }

    final public static function delete($sql, $data)
    {
        return self::action($sql, $data);
    }

    private static function action($sql, $data)
    {
        $stmt = self::getConnection()->prepare($sql);

        $stmt->execute();

        //@todo 设置返回值类型
        return $stmt->fetchAll(self::$resultType);
    }
}