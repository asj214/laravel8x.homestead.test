<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Attachment;


class AttachmentController extends Controller
{
    //
    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'attachment_type' => ['required', 'string', 'max:255'],
            'attachment_id' => ['required', 'integer'],
            'attachment' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg']
        ]);

        if ($validate->fails()) return respond_invalid($validate->errors());

        if($request->hasFile('attachment')){

            $path = $request->file('attachment')->store('public/upfiles/attachments');

            $attachment = new Attachment();
            $attachment->user_id = auth()->user()->id;
            $attachment->attachment_id = $request->input('attachment_id');
            $attachment->attachment_type = $request->input('attachment_type');
            $attachment->filename = $request->file('attachment')->getClientOriginalName();
            $attachment->url = str_replace("public", "storage", $path);
            $attachment->save();

            return respond_success();

        }

        return respond_internal_error();

    }

}
