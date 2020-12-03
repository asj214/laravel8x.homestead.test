<?php
namespace App\Transformers;

use App\Models\Attachment;
use League\Fractal\TransformerAbstract;


class AttachmentTransformer extends TransformerAbstract
{
    public function transform(Attachment $attach)
    {
        return [
            'id' => (int) $attach->id,
            'user_id' => (int) $attach->user_id,
            'attachment_type' => $attach->attachment_type,
            'attachment_id' => (int) $attach->attachment_id,
            'filename' => $attach->filename,
            'url' => $attach->url,
            'created_at' => $attach->created_at,
            'updated_at' => $attach->updated_at
        ];
    }
}