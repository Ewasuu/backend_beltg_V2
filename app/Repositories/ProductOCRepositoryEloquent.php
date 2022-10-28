<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\productOCRepository;
use App\Entities\ProductOC;
use App\Validators\ProductOCValidator;

/**
 * Class ProductOCRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductOCRepositoryEloquent extends BaseRepository implements ProductOCRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductOC::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductOCValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
