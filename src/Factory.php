<?php

namespace SchemaRequest;

use InvalidArgumentException;
use JsonSchema\Validator;

class Factory
{
    public static function make($data, $rules, array $messages = [], array $customAttributes = [])
    {
        $data = static::makeStdClass($data);
        $rules = static::makeStdClass($rules);

        return new SchemaValidator(new Validator, $data, $rules, $messages, $customAttributes);
    }

    private static function makeStdClass($value)
    {
        if( is_string($value) ){
            return json_decode($value, FALSE);
        }

        if( is_array($value) ){
            return static::makeStdClass( json_encode($value) );
        }

        if( is_object($value) ){
            return $value;
        }

        throw new InvalidArgumentException;
    }
}
