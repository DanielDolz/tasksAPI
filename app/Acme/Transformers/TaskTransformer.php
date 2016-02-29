<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 05/12/15
 * Time: 11:29
 */

namespace Acme\Transformers;

class TaskTransformer extends Transformer
{
    public function transform($task)
    {

        return [
            'name' => $task['name'],
            'some_bool' => (boolean) $task['done'],
            'priority' => (int)$task['priority'],

        ];
    }
}