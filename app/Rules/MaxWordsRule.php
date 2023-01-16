<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWordsRule implements Rule
{
    private $max_words;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max_words = 1000)
    {
        $this->max_words = $max_words;
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
        $content = strip_tags($value);
        $pattern = "#[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-|:|\&|@)]+#";
        $content = trim(preg_replace($pattern, " ", $content));
        $words = count(explode(" ", $content));
        return $words <= $this->max_words;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Content cannot be longer than '.$this->max_words.' words.';
    }
}
