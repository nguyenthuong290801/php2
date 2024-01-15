<?php

namespace Illuminate\framework\base;

class Validator
{
    /**
     * Check if the value is a number.
     *
     * @param mixed $value
     * @return bool
     */
    public static function numeric($value)
    {
        return is_numeric($value);
    }

        /**
     * Check if the value is a not number.
     *
     * @param mixed $value
     * @return bool
     */
    public static function notNumeric($value)
    {
        return !is_numeric($value);
    }

    /**
     * Check if the value is a natural number.
     *
     * @param mixed $value
     * @return bool
     */
    public static function naturalNumeric($value)
    {
        return is_numeric($value) && $value <= 0;
    }

    /**
     * Check if the value is empty.
     *
     * @param mixed $value
     * @return bool
     */
    public static function required($value)
    {
        return empty($value);
    }
}
