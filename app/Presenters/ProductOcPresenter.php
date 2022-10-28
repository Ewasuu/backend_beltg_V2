<?php

namespace App\Presenters;

use App\Transformers\ProductOcTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProductOcPresenter.
 *
 * @package namespace App\Presenters;
 */
class ProductOcPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProductOcTransformer();
    }
}
