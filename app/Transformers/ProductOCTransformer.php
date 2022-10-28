<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ProductOC;

/**
 * Class ProductOCTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProductOCTransformer extends TransformerAbstract
{
    /**
     * Transform the ProductOC entity.
     *
     * @param \App\Entities\ProductOC $model
     *
     * @return array
     */
    public function transform(ProductOC $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
