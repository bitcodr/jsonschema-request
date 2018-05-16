# laravel-jsonschema-request
Laravel Server side form validation using JSON Schema

## Install
    composer require amiralii/jsonschema-request

## How to use
1. Create a form request class as you would with artisan: php artisan make:request PersonRequest
2. Change the extended class in PersonRequest to use SchemaRequest/SchemaFormRequest
3. Implement the rules() method to return a JSON Schema string

Example
```
<?php

namespace App\Http\Requests;

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

```

## old version 
    https://github.com/aaronbullard/laravel-schemarequest
