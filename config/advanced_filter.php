<?php

return [
    'operators' => [
        'Equal' => ['=', 'equal'],
        'NotEqual' => ['!=', 'notEqual'],
    ],

    'custom_operators' => [

    ],

    'default_operator' => 'Equal',

    'prefix_operator_function' => 'filterWhere',

    'default_conjunction' => 'and',

    /*
    |--------------------------------------------------------------------------
    | Default Query Format
    |--------------------------------------------------------------------------
    |
    | This option controls the default query format.
    | This format is used when sending request.
    |
    | Supported:
    |   -  "separate:^"     : filter^name^value=abc&filter^email^operator=equal
    |   -  "array"          : filter[name][value]=abc&filter[name][operator]=equal
    |   -  "json" (Default) : filters=[{"field":"name","operator":"equal","value":"abc"}]
    |
    */

    'query_format' => 'json',

    'custom_query_format' => null,

    'param_filter_name' => 'filters', // or as prefix in "separate" query format

    'param_conjunction_name' => 'conjunction',

    'field_params' => [
        'field' => 'field', // used only in "json" query format
        'operator' => 'operator',
        'value' => 'value',
    ],

    'data_types' => [

        'string' => ['Equal', 'NotEqual', 'Contains'],

        'numeric' => ['Equal', 'NotEqual'],

        'date' => ['Equal', 'NotEqual'],

        'datetime' => ['Equal', 'NotEqual'],

        'array' => [

        ],
    ]
];
