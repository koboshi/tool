<?php
/**
 * 数据库封装类
 * 基于PDO
 * @author SamDing
 */
namespace koboshi\Tool;

class Database
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $charset;

    /**
     * @var string
     */
    private $lastSql;

    /**
     * @var int
     */
    private $affectedRows = 0;

    /**
     * @var int
     */
    private $lastErrNo = 0;

    /**
     * @var string
     */
    private $lastErrMsg = '';

    /**
     * @var \PDO
     */
    private $pdoHandle;

    /**
     * Database constructor.
     * @param string $host
     * @param string $user
     * @param string $password
     * @param int $port
     * @param string $dbName
     * @param string $charset
     */
    public function __construct($host, $user, $password, $port = 3306, $dbName = '', $charset = 'utf8')
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->dbName = $dbName;
        $this->charset = $charset;
    }

    public function __destruct()
    {
        $this->pdoHandle = null;
        $this->pdoStmt = null;
    }

    private function connect($force = false)
    {
        if (is_null($this->pdoHandle) || $force)
        {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbName};charset={$this->charset}";
            $this->pdoHandle = new \PDO($dsn, $this->user, $this->password, array(
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
                \PDO::MYSQL_ATTR_COMPRESS => false
            ));
        }
    }

    /**
     * @param string $dbName
     */
    public function selectDatabase($dbName)
    {
        $this->exec("USE {$dbName};");
        $this->dbName = $dbName;
    }

    public function queryOne($sql, $params = array())
    {
        $statement = $this->_query($sql, $params);
        $output = $statement->fetch(\PDO::FETCH_ASSOC);
        return empty($output) ? array() : $output;
    }

    public function query($sql, $params = array())
    {
        $statement = $this->_query($sql, $params);
        $output = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return empty($output) ? array() : $output;
    }

    private function _query($sql, $params)
    {
        $this->connect();
        $statement = $this->pdoHandle->prepare($sql);
        foreach ($params as $k => $v) {
            $statement->bindParam($k, $v);
        }
        $statement->execute();
        $this->affectedRows = $statement->rowCount();
        return $statement;
    }

    public function insert()
    {

    }

    public function replace()
    {

    }

    public function ignore()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function exec($sql)
    {
        $this->connect();
        return $this->pdoHandle->exec($sql);
    }

    public function affectedRows()
    {
        return $this->affectedRows;
    }

    public function lastInsertId()
    {
        $this->connect();
        return $this->pdoHandle->lastInsertId();
    }

    public function begin()
    {
        $this->connect();
        if (!$this->pdoHandle->inTransaction())
        {
            throw new \PDOException('in transaction already!');
        }else {
            $this->pdoHandle->beginTransaction();
        }
    }

    public function commit()
    {
        $this->connect();
        $this->pdoHandle->commit();
    }

    public function rollback() {
        $this->connect();
        $this->pdoHandle->rollBack();
    }

    public function excape($str)
    {
        $this->connect();
        return $this->pdoHandle->quote($str);
    }
}