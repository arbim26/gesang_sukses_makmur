<?php

use Hashids\Hashids;

if (! function_exists('encode_id')) {
    function encode_id(string $id): string
    {
        return bin2hex($id);
    }
}

if (! function_exists('decode_id')) {
    function decode_id(string $hash): string
    {
        if (! ctype_xdigit($hash)) {
            abort(404);
        }

        $decoded = hex2bin($hash);

        abort_if($decoded === false || $decoded === '', 404);

        return $decoded;
    }
}