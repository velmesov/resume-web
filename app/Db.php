<?php

namespace app;

use PDO;

/**
 * Class Db
 *
 * @package app
 */
class Db
{
    /**
     * @var object $instance
     */
    private static $instance;

    /**
     * Объект подключения к базе
     *
     * @var object $db
     */
    private $db;

    /**
     * Название подключения из конфига
     *
     * @var string $connection_name
     */
    private static $connection_name;

    /**
     * Объект логирования
     *
     * @var object $log
     */
    private $log;

    /**
     * Результат запроса SELECT
     *
     * @var array
     */
    private $result;

    /**
     * Количество затронутых строк запросами SELECT, INSERT, UPDATE, DELETE
     *
     * @var integer $rowCount
     */
    private $rowCount;

    /**
     * Количество столбцов запроса SELECT
     *
     * @var integer $columnCount
     */
    private $columnCount;

    /**
     * id последней вставленной записи запроса INSERT
     *
     * @var integer $lastInsertId
     */
    private $lastInsertId;

    /**
     * Инициализация объекта
     *
     * @param string $connection_name
     * @return object
     */
    public static function init(string $connection_name)
    {
        if (self::$instance === null) {
            self::$instance = new self;
            self::$connection_name = $connection_name;
        }

        return self::$instance;
    }

    /**
     * Db construct
     */
    public function __construct()
    {
        $this->log = Log::init();
    }

    /**
     * Подключение к базе
     *
     * @return void
     */
    private function connection()
    {
        $db_config = ROOT . '/conf/db.php';

        if (file_exists($db_config)) {
            $conf = require $db_config;
            $conf = $conf['connections'][self::$connection_name];
        } else {
            $this->log->view(L['db_not_found_config'], true);
        }

        $dsn = $conf['driver'] . ':host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];

        if (empty($conf['sql_mode'])) {
            $options = [
                PDO::ATTR_ERRMODE => CONF['main']['debug'] ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT
            ];
        } else {
            $options = [
                PDO::ATTR_ERRMODE => CONF['main']['debug'] ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode="' . $conf['sql_mode'] . '"'
            ];
        }

        $this->db = new PDO($dsn, $conf['username'], $conf['password'], $options);
    }

    /**
     * Выполнение запросов
     *
     * @param string $sql
     * @param array  $parameters
     *
     * @return void
     */
    public function query(string $sql, array $parameters = [])
    {
        // Устанавливаем подключение
        $this->connection();

        // Подготавливаем запрос
        $stmt = $this->db->prepare($sql);

        // Биндим параметры если есть в запросе
        if (!empty($parameters)) {
            $this->bindValue($stmt, $parameters);
        }

        // Если не удалось выполнить запрос
        if (!$stmt->execute()) {
            $this->log->view(L['db_query_execution_failed'], true);
        }

        $this->setResultTypeQuery($stmt, $sql);
    }

    /**
     * Записывает результат в зависимости от типа запроса
     *
     * @param object $stmt
     * @param string $sql
     */
    private function setResultTypeQuery(object $stmt, string $sql)
    {
        $sql = trim($sql);

        if (stripos($sql, 'select') === 0) {
            // TODO: Добавить группировку строк PDO::FETCH_GROUP
            $this->setResult($stmt->fetchAll(PDO::FETCH_ASSOC));
            $this->setRowCount($stmt->rowCount());
            $stmt->closeCursor();
        } elseif (stripos($sql, 'insert') === 0) {
            $this->setRowCount($stmt->rowCount());
            $this->setLastInsertId($this->db->lastInsertId());
        } elseif (stripos($sql, 'update') === 0) {
            $this->setRowCount($stmt->rowCount());
        } elseif (stripos($sql, 'delete') === 0) {
            $this->setRowCount($stmt->rowCount());
        }
    }

    /**
     * Возвращает результат запроса SELECT
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * Записывает результат запроса SELECT в переменную
     *
     * @param array $data
     *
     * @return void
     */
    private function setResult(array $data)
    {
        $this->result = $data;
    }

    /**
     * Возвращает id последней вставленной записи
     *
     * @return integer
     */
    public function getLastInsertId(): int
    {
        return $this->lastInsertId;
    }

    /**
     * Записывает id последней вставленной записи
     *
     * @param integer $id
     *
     * @return void
     */
    private function setLastInsertId(int $id)
    {
        $this->lastInsertId = $id;
    }

    /**
     * Возвращает количество затронутых строк запросов INSERT, UPDATE, DELETE
     *
     * @return integer
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    /**
     * Записывает количество затронутых строк запросов INSERT, UPDATE, DELETE
     *
     * @param integer $count
     *
     * @return void
     */
    private function setRowCount(int $count)
    {
        $this->rowCount = $count;
    }

    /**
     * Привязка параметров со значениями
     *
     * @param object $stmt
     * @param array  $parameters
     *
     * @return void
     */
    private function bindValue(object $stmt, array $parameters)
    {
        foreach ($parameters as $key => $parameter) {
            $key++;
            switch (getType($parameter)) {
                case 'integer':
                    $stmt->bindValue($key, $parameter, PDO::PARAM_INT);
                    break;

                case 'string':
                    $stmt->bindValue($key, $parameter, PDO::PARAM_STR);
                    break;

                case 'boolean':
                    $stmt->bindValue($key, $parameter, PDO::PARAM_BOOL);
                    break;

                case 'NULL':
                    $stmt->bindValue($key, $parameter, PDO::PARAM_NULL);
                    break;

                default:
                    $this->log->view(L['db_unknown_parameter_type'], true);
            }
        }
    }

    private function __clone()
    { }

    private function __wakeup()
    { }

    /**
     * Закрываем соединение
     */
    public function __destruct()
    {
        if (is_object($this->db)) {
            $this->db = null;
        }
    }
}
