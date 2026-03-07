<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_source',
        // 'utm_medium',
        // 'utm_term',
        // 'utm_content',
        // 'utm_id',
        // 'utm_source_platform',
        // 'utm_creative_format',
        // 'utm_marketing_tactic',
    ];
}
