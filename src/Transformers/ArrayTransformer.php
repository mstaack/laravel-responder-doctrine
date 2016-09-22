<?php

namespace Flugg\Responder\Transformers;

use League\Fractal\TransformerAbstract;

class ArrayTransformer extends TransformerAbstract
{

    public function transform($data)
    {
        return $data;
    }

}
