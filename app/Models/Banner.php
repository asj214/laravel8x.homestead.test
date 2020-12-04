<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "banners";
    protected $dates = ['deleted_at'];
    protected $with = ['attachment'];

    public function attachment(){
        return $this->hasOne(Attachment::class, 'attachment_id')->where('attachment_type', 'banners')->orderBy('id', 'asc');
    }

}
