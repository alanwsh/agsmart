<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class ValidImage implements Rule
{
    protected $allowed_content_type = array(
        'image/jpeg' , 'image/png' , 'image/svg+xml' , 'image/webp' , 'image/tiff'
    );
    protected $mime;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $contents = Http::get($value);
        $content_type = $contents->headers()['Content-Type'];
        $this->mime = $content_type;
        if(in_array(implode("",$content_type),$this->allowed_content_type)){
            return true;
        }
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid mime type';
    }
}
