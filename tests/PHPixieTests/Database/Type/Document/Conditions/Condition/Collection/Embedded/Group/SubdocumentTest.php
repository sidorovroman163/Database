<?php

namespace PHPixieTests\Database\Type\Document\Conditions\Condition\Collection\Embedded\Group;

/**
 * @coversDefaultClass \PHPixie\Database\Type\Document\Conditions\Condition\Collection\Embedded\Group\Subdocument
 */
class SubdocumentTest extends \PHPixieTests\Database\Type\Document\Conditions\Condition\Collection\Embedded\GroupTest
{
    protected function embeddedGroup($field)
    {
        return new \PHPixie\Database\Type\Document\Conditions\Condition\Collection\Embedded\Group\Subdocument($field);
    }
}