<?php

namespace PHPixieTests\DB\Conditions\Condition;

/**
 * @coversDefaultClass \PHPixie\DB\Conditions\Condition\Placeholder
 */
class PlaceholderTest extends \PHPixieTests\DB\Conditions\ConditionTest
{
    protected $conditionsMock;
    protected $builderMock;
    
    protected function setUp()
    {
        $this->builderMock = $this->quickMock('\PHPixie\DB\Conditions\Builder', array('getConditions'));
        $this->conditionsMock = $this->quickMock('\PHPixie\DB\Conditions', array('builder', 'group'));
        $this->condition = new \PHPixie\DB\Conditions\Condition\Placeholder($this->conditionsMock, '=');
    }

    /**
     * @covers ::builder
     * @covers ::__construct
     */
    public function testBuilder()
    {
        $this->expectBuilder();
        $this->assertEquals($this->builderMock, $this->condition->builder());
        $this->assertEquals($this->builderMock, $this->condition->builder());
    }
    
    /**
     * @covers ::getGroup
     */
    public function testGetGroupNoBuilderException()
    {
        $placeholder = new \PHPixie\DB\Conditions\Condition\Placeholder($this->conditionsMock, '=', false);
        $this->setExpectedException('\PHPixie\DB\Exception\Builder');
        $placeholder->getGroup();
    }
    
    /**
     * @covers ::getGroup
     */
    public function testGetGroupEmptyException()
    {
        $this->expectCalls($this->builderMock, array(), array('getConditions' => array()));
        $placeholder = new \PHPixie\DB\Conditions\Condition\Placeholder($this->conditionsMock, '>', false);
        $this->expectBuilder('>');
        $placeholder->builder();
        $this->setExpectedException('\PHPixie\DB\Exception\Builder');
        $placeholder->getGroup();
    }
    
    /**
     * @covers ::getGroup
     */
    public function testGetGroupEmpty()
    {
        $this->condition = new \PHPixie\DB\Conditions\Condition\Placeholder($this->conditionsMock);
        $this->assertEquals(null, $this->condition->getGroup());
    }
    
    /**
     * @covers ::getGroup
     */
    public function testGetGroup()
    {
        $groupMock = $this->quickMock('\PHPixie\DB\Conditions\Condition\Group', array('setConditions', 'negate', 'setLogic'));
        
        $this->expectCalls($groupMock, array(
            'setConditions' => array(array('test')),
            'setLogic' => array('or'),
            'negate' => array(),
        ));
        
        $this->expectCalls($this->builderMock, array(), array('getConditions' => array('test')));
        
        $this->conditionsMock
                    ->expects($this->any())
                    ->method('group')
                    ->will($this->returnValue($groupMock));
        $this->condition = new \PHPixie\DB\Conditions\Condition\Placeholder($this->conditionsMock);
        
        $this->expectBuilder();
        $this->condition->builder();
        $this->condition->setLogic('or');
        $this->condition->negate();
        $this->assertEquals($groupMock, $this->condition->getGroup());
    }
    
    protected function expectBuilder($operator = '=') {
        $this->conditionsMock
                ->expects($this->once())
                ->method('builder')
                ->with($operator)
                ->will($this->returnValue($this->builderMock));
    }
}
