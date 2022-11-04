<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProductOcValidator.
 *
 * @package namespace App\Validators;
 */
class ProductOcValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'data' => 'present|array',
            'data.*.sku' => 'required|string|max:30',
            'data.*.oc' => 'present|array',
            'data.*.oc.ocno' => 'string|max:15',
            'data.*.oc.oc_date' => 'date',
            'data.*.oc.oc_date_required' => 'date',
            'data.*.oc.qty' => 'numeric',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
