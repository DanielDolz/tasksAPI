<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/01/16
 * Time: 18:27
 */

namespace Acme\Transformers;


class TagTransformer extends Transformer
{
    public function transform($tag)
{

    return [
        'title' => $tag['title']
        //'some_bool' => (boolean) $tag['prova'],
    ];
}
}