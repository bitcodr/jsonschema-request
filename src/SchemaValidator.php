<?php

namespace SchemaRequest;

use StdClass, RuntimeException;
use JsonSchema\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\MessageBag;

class SchemaValidator implements ValidatorContract
{
    protected $validator;

    protected $data;

    protected $rules;

    protected $messages;

    protected $customAttributes;

    protected $errors;

    public function __construct(Validator $validator, StdClass $data, StdClass $rules, array $messages = [], array $customAttributes = [])
    {
        $this->validator = $validator;
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
        $this->customAttributes = $customAttributes;

        $this->errors = new MessageBag;

        return $this;
    }

    public function passes()
    {
        if( $this->errors->isEmpty() ){
            $this->validator->check($this->data, $this->rules);

            foreach($this->validator->getErrors() as $error){
                $message = ucfirst($error['message']) . ".";
                $this->errors->add($error['property'], $message);
            }
        }

        return $this->errors->isEmpty();
    }

    public function errors()
    {
        return $this->getMessageBag();
    }

    /**
     * Determine if the data fails the validation rules.
     *
     * @return bool
     */
    public function fails()
    {
        return ! $this->passes();
    }

    /**
     * Get the failed validation rules.
     *
     * @return array
     */
    public function failed()
    {
        return $this->errors()->toArray();
    }

    /**
     * Add conditions to a given field based on a Closure.
     *
     * @param  string  $attribute
     * @param  string|array  $rules
     * @param  callable  $callback
     * @return void
     */
    public function sometimes($attribute, $rules, callable $callback)
    {
        throw new RuntimeException("Not supported.");
    }

    /**
     * After an after validation callback.
     *
     * @param  callable|string  $callback
     * @return $this
     */
    public function after($callback)
    {
        $this->after[] = function () use ($callback) {
            return call_user_func_array($callback, [$this]);
        };

        return $this;
    }

    /**
     * Get the messages for the instance.
     *
     * @return \Illuminate\Contracts\Support\MessageBag
     */
    public function getMessageBag()
    {
        return $this->errors;
    }
}
