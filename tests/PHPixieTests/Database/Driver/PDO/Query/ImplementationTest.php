<?php
namespace PHPixieTests\Database\Driver\PDO\Query;

/**
 * @coversDefaultClass \PHPixie\Database\Driver\PDO\Query\Implementation
 */
abstract class ImplementationTest extends \PHPixieTests\Database\SQL\Query\ImplementationTest
{
    protected $queryClass;
    protected $resultClass = '\PHPixie\Database\Driver\PDO\Result';

    protected function getParser()
    {
        return $this->quickMock('\PHPixie\Database\Driver\PDO\Mysql\Parser', array('parse'), array());
    }

    protected function getConnection()
    {
        return $this->getMock('\PHPixie\Database\Driver\PDO\Connection', array('execute'), array(), '', null, false);
    }
    
    protected function getBuilder()
    {
        return $this->getMock('\PHPixie\Database\Driver\PDO\Query\Implementation\Builder', array('execute'), array(), '', null, false);
    }
    
    protected function query()
    {
        $class = $this->queryClass;
        return new $class($this->connection, $this->parser, $this->builder);
    }
}