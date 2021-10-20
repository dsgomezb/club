<?php

$aspectRatio = function ($constraint){
    $constraint->aspectRatio();
    $constraint->upsize();
};

$aspectRatioUpsize = function ($constraint){
    $constraint->aspectRatio();
};

return [
    'users' => [
        'thumb' => [
            'fit' => [220,220]
        ],
        'sm' => [
            'fit' => [500,500]
        ],
    ],
    'posts' => [
        'thumb' => [
            'fit' => [220,220]
        ],
        'index' => [
            'widen' => [500]
        ],
        'mini' => [
            'fit' => [500,333]
        ],
        'show' => [
            'fit' => [1200,600]
        ],
        'banner' => [
            'fit' => [1800,900]
        ],
    ],
];
