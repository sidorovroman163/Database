<?php
namespace PHPixieTests\DB\Driver\PDO\Adapters;

/**
 * @coversDefaultClass \PHPixie\DB\Driver\PDO\Adapter\Pgsql
 */
class PgsqlTest extends \PHPixieTests\DB\Driver\PDO\AdapterTest
{
    protected $listColumnsQuery = "select column_name from information_schema.columns where table_name = 'fairies' and table_catalog = current_database()";

    protected $listColumnsColumn = 'column_name';

    public function setUp()
    {
        parent::setUp();
        $this->connection
                        ->expects($this->at(0))
                        ->method('execute')
                        ->with('SET NAMES utf8')
                        ->will($this->returnValue(null));
        $this->adapter = new \PHPixie\DB\Driver\PDO\Adapter\Pgsql('test', $this->connection);
    }

    /**
     * @covers ::insertId
     */
    public function testInsertId()
    {
        $this->prepareQueryColumnAssertion('SELECT lastval() as id', 'get', 'id', 1);
        $this->assertEquals(1, $this->adapter->insertId());
    }

    /**
     * @covers ::insertId
     */
    public function testInsertIdNull()
    {
        $this->connection
                    ->expects($this->once())
                    ->method('execute')
                    ->with('SELECT lastval() as id')
                    ->will($this->returnCallback(function () {
                        throw new \Exception('test');
                    }));

        $this->setExpectedException('\PHPixie\DB\Exception');
        $this->adapter->insertId();
    }

}
