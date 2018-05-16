<?php

namespace SchemaRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;

abstract class SchemaFormRequest extends FormRequest implements ValidatesWhenResolved
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return StdClass
     */
    abstract public function rules();


    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = Factory::make($this->all(), $this->rules(), $this->messages(), $this->attributes());

        return $validator;
    }

}
