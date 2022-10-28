<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ProductOc;

/**
 * Class ProductOcTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProductOcTransformer extends TransformerAbstract
{
    /**
     * Transform the ProductOc entity.
     *
     * @param \App\Entities\ProductOc $model
     *
     * @return array
     */
    public function transform(ProductOc $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
