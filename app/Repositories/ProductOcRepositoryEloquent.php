<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\productOcRepository;
use App\Entities\ProductOc;
use App\Validators\ProductOcValidator;

/**
 * Class ProductOcRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductOcRepositoryEloquent extends BaseRepository implements ProductOcRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductOc::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductOcValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
