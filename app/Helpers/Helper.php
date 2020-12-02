<?php
if (!function_exists('respond')) {
    function respond($data, $status = 200, $headers = []) {
        return response()->json($data, $status, $headers);
    }
}

function respond_success() {
    return respond(null);
}

function respond_created($data) {
    return respond($data, 201);
}

function respond_no_content() {
    return respond(null, 204);
}

function respond_error($message, $status) {
    return respond([
        'errors' => [
            'message' => $message,
            'status_code' => $status
        ]
    ], $status);
}

function respond_unauthorized($message = 'Unauthorized') {
    return respond_error($message, 401);
}

function respond_forbidden($message = 'Forbidden') {
    return respond_error($message, 404);
}

function respond_internal_error($message = 'Internal Error') {
    return respond_error($message, 500);
}

function respond_invalid($message, $status = 400) {
    return respond_error($message, $status);
}