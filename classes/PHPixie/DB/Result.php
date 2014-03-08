<?php

namespace PHPixie\DB;

abstract class Result implements \Iterator
{
    public function asArray()
    {
        $this->rewind();
        $arr = array();
        foreach ($this as $row)
            $arr[] = $row;

        return $arr;
    }

    public function get($column)
    {
        if (!$this->valid())
            return;

        $current = $this->current();
        if (isset($current->$column))
            return $current->$column;
    }

    public function getColumn($column = null, $skipNulls = false)
    {
        $this->rewind();
        $values = array();
        foreach($this as $row)
            if ($column === null)
                $column = key(get_object_vars($row));
            
            if (isset($row->$column)) {
                $values[] = $row->$column;
            }elseif(!$skipNulls)
                $values[] = null;

        return $values;
    }

    abstract public function current();
    abstract public function next();
    abstract public function valid();
    abstract public function rewind();
}
