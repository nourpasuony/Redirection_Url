<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UrlHelper
{
    /**
     * Validate the URL input.
     *
     * @param array $data
     * @throws ValidationException
     */
    public static function validateUrl($data)
    {
        $validator = Validator::make($data, [
            'original_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}