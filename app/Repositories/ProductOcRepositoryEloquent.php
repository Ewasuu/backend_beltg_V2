<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\productOcRepository;
use App\Entities\ProductOc;
use App\Validators\ProductOcValidator;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityCreating;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityDeleting;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;

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

    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            $this->validator->with(array_merge($attributes, $values));
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        event(new RepositoryEntityCreating($this, $attributes));

        $model = $this->model->updateOrCreate($attributes, $values);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
