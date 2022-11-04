<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductOc.
 *
 * @package namespace App\Entities;
 */
class ProductOc extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $casts = [
        'oc_date' => 'date',
        'oc_date_required' => 'date'
    ];

    protected $table = 'Product_oc';

    protected $primaryKey = ['sku', 'ocno'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sku',
        'ocno',
        'oc_date',
        'oc_date_required',
        'qty',

    ];

    protected function setKeysForSaveQuery($query)
    {
        $query->where('sku', '=', $this->getAttribute('sku'))->where('ocno', '=', $this->getAttribute('ocno'));

        return $query;
    }

}
