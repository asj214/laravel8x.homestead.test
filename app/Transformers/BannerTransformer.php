<?php
namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;


class BannerTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['attachment'];

    public function transform(Banner $banner)
    {
        return [
            'id' => (int) $banner->id,
            'category_id' => (int) $category_id,
            'title' => $banner->title,
            'link' => $banner->link,
            'description' => $banner->description,
            'attachment' => null,
            'created_at' => $banner->created_at,
            'updated_at' => $banner->updated_at
        ];
    }

    public function includeAttachment(Banner $banner) {
        return $this->item($banner->attachment, new AttachmentTransformer);
    }

}