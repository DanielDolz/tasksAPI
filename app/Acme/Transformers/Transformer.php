<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 05/12/15
 * Time: 11:26
 */

namespace Acme\Transformers;

abstract class Transformer
{
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }
    
    public abstract function transform($item);
}