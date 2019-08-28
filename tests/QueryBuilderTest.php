<?php


namespace EasySwoole\ORM\Tests;


use EasySwoole\ORM\Driver\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    protected $builder;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->builder = new QueryBuilder();
        parent::__construct($name, $data, $dataName);
    }

    function testGet()
    {
        $this->builder->get('get');
        $this->assertEquals('SELECT  * FROM get',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM get',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->get('get',1);
        $this->assertEquals('SELECT  * FROM get LIMIT 1',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM get LIMIT 1',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->get('get',[2,10]);
        $this->assertEquals('SELECT  * FROM get LIMIT 2, 10',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM get LIMIT 2, 10',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->get('get',null,['col1','col2']);
        $this->assertEquals('SELECT  col1, col2 FROM get',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  col1, col2 FROM get',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->get('get',1,['col1','col2']);
        $this->assertEquals('SELECT  col1, col2 FROM get LIMIT 1',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  col1, col2 FROM get LIMIT 1',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->get('get',[2,10],['col1','col2']);
        $this->assertEquals('SELECT  col1, col2 FROM get LIMIT 2, 10',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  col1, col2 FROM get LIMIT 2, 10',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());
    }

    function testWhereGet()
    {
        $this->builder->where('col1',2)->get('whereGet');
        $this->assertEquals('SELECT  * FROM whereGet WHERE  col1 = ? ',$this->builder->getPrepareQuery());
        $this->assertEquals("SELECT  * FROM whereGet WHERE  col1 = 2 ",$this->builder->getQuery());
        $this->assertEquals([2],$this->builder->getBindParams());

        $this->builder->where('col1',2,">")->get('whereGet');
        $this->assertEquals('SELECT  * FROM whereGet WHERE  col1 > ? ',$this->builder->getPrepareQuery());
        $this->assertEquals("SELECT  * FROM whereGet WHERE  col1 > 2 ",$this->builder->getQuery());
        $this->assertEquals([2],$this->builder->getBindParams());

        $this->builder->where('col1',2)->where('col2','str')->get('whereGet');
        $this->assertEquals('SELECT  * FROM whereGet WHERE  col1 = ?  AND col2 = ? ',$this->builder->getPrepareQuery());
        $this->assertEquals("SELECT  * FROM whereGet WHERE  col1 = 2  AND col2 = 'str' ",$this->builder->getQuery());
        $this->assertEquals([2,'str'],$this->builder->getBindParams());

        $this->builder->where('col3',[1,2,3],'IN')->get('whereGet');
        $this->assertEquals('SELECT  * FROM whereGet WHERE  col3 IN ( ?, ?, ? ) ',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM whereGet WHERE  col3 IN ( 1, 2, 3 ) ',$this->builder->getQuery());
        $this->assertEquals([1,2,3],$this->builder->getBindParams());
    }

    function testJoinGet()
    {
        $this->builder->join('table2','table2.col1 = getTable.col2')->get('getTable');
        $this->assertEquals('SELECT  * FROM getTable  JOIN table2 on table2.col1 = getTable.col2',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM getTable  JOIN table2 on table2.col1 = getTable.col2',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());

        $this->builder->join('table2','table2.col1 = getTable.col2','LEFT')->get('getTable');
        $this->assertEquals('SELECT  * FROM getTable LEFT JOIN table2 on table2.col1 = getTable.col2',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM getTable LEFT JOIN table2 on table2.col1 = getTable.col2',$this->builder->getQuery());
        $this->assertEquals([],$this->builder->getBindParams());
    }

    function testJoinWhereGet()
    {
        $this->builder->join('table2','table2.col1 = getTable.col2')->where('table2.col1',2)->get('getTable');
        $this->assertEquals('SELECT  * FROM getTable  JOIN table2 on table2.col1 = getTable.col2 WHERE  table2.col1 = ? ',$this->builder->getPrepareQuery());
        $this->assertEquals('SELECT  * FROM getTable  JOIN table2 on table2.col1 = getTable.col2 WHERE  table2.col1 = 2 ',$this->builder->getQuery());
        $this->assertEquals([2],$this->builder->getBindParams());
    }

    function testUpdate()
    {

    }

    function testWhereUpdate()
    {

    }

    function testDelete()
    {

    }

    function testWhereDelete()
    {

    }

    function testInsert()
    {

    }
}