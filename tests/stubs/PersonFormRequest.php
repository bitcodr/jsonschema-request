<?php 


use SchemaRequest\SchemaFormRequest as Request;


class PersonFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return '{
            "type": "object",
            "properties": {
                "fname": {"type": "string", "maximum": 5},
                "lname": {"type": "string", "minimum": 5},
                "mname": {"type": "string", "minimum": 5},
                "age": {"type": "integer", "minimum": 21},
                "email": {"type": "string", "format": "email"}
            }
        }';
    }
}