<?php

namespace Nbz4live\JsonRpc\Server\DocBlock\Types;

use phpDocumentor\Reflection\Type;

/**
 * Class Date
 * @package Nbz4live\JsonRpc\Server\DocBlock\Types
 */
class Date implements Type
{
    protected $format;

    public function __construct($format = null)
    {
        $this->format = trim($format, '"');
    }

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'date';
    }
}
