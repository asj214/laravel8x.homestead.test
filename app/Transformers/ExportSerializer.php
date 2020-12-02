<?php
namespace App\Transformers;

use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;


class ExportSerializer extends ArraySerializer {

    public function collection($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }

    public function null()
    {
        return [];
    }

}