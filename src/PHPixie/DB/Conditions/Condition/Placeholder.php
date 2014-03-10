<?php

namespace PHPixie\DB\Conditions\Condition;

class Placeholder extends \PHPixie\DB\Conditions\Condition
{
    protected $conditions;
    protected $defaultOperator;
    protected $allowEmpty;
    protected $builder;

    public function __construct($conditions, $defaultOperator = '=', $allowEmpty = true)
    {
        $this->conditions      = $conditions;
        $this->defaultOperator = $defaultOperator;
        $this->allowEmpty      = $allowEmpty;
    }
    
    public function builder() 
    {
        if ($this->builder === null)
            $this->builder = $this->conditions->builder($this->defaultOperator);
        
        return $this->builder;
    }
    
    public function getGroup() {
        $conditions = array();
        
        if ($this->builder !== null)
            $conditions = $this->builder->getConditions();
        
        if (empty($conditions)) {
            if(!$this->allowEmpty)
                throw new \PHPixie\DB\Exception\Builder("This placeholder cannot be empty");
            
            return null;
        }
        
        $group = $this->conditions->group();
        $group->setConditions($conditions);
        $group->setLogic($this->logic);
        if ($this->negated())
            $group->negate();
        return $group;
    }
}
