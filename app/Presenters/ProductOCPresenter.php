<?php

namespace App\Presenters;

use App\Transformers\ProductOCTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProductOCPresenter.
 *
 * @package namespace App\Presenters;
 */
class ProductOCPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProductOCTransformer();
    }
}
