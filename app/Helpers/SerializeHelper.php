<?php

function collection($model, $transformer = false, $key = 'data') {

    if (false === $transformer) {
        $transformer = function($model) { return $model; };
    }

    if (! ($transformer instanceof Closure)) {
        $transformer = app()->make($transformer);
    }

    $manager = new \League\Fractal\Manager();
    $manager->setSerializer(new App\Transformers\ExtentionSerializer());
    $collect = new \League\Fractal\Resource\Collection($model->getCollection(), $transformer, $key);
    $resource = $collect->setPaginator(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($model));

    return $manager->createData($resource)->toArray();

}

function item($model, $transformer = false, $key = 'data') {

    if (false === $transformer) {
        $transformer = function($model) { return $model; };
    }

    if (! ($transformer instanceof Closure)) {
        $transformer = app()->make($transformer);
    }

    // 이거 없으면 잘 돌아가는거 같아서 일단 주석
    // if (is_object($model) && method_exists($model, 'toArray')) {
    //     $model = $model->toArray();
    // }

    $manager = new \League\Fractal\Manager();
    $manager->setSerializer(new App\Transformers\ExtentionSerializer());
    $resource = new \League\Fractal\Resource\Item($model, $transformer, $key);

    return $manager->createData($resource)->toArray();

}