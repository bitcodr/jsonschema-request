<?php

namespace SchemaRequest;

use StdClass;
use PersonFormRequest;


class SchemaValidatorUnitTest extends \TestCase {
    
    
    protected $request;


    public function setUp()
    {
        $this->request = new PersonFormRequest;
    }
    
    
    protected function getValidator($data)
    {
        return Factory::make($data, $this->request->rules());
    }
    
    
    public function test_it_passes_validation()
    {
        $data = [
            'fname' => 'James',
            'mname' => 'Aaron',
            'lname' => 'Bullard',
            'age' => 39,
            'email' => 'JABullard@aol.com'
        ];
        
        $validator = $this->getValidator($data);
        
        $this->assertTrue( $validator->passes() );
        $this->assertFalse( $validator->fails() );
        $this->assertEquals([], $validator->errors()->all());
    }
    
    
    public function test_it_fails_validation_on_age()
    {
        $data = [
            'fname' => 'James',
            'mname' => 'Aaron',
            'lname' => 'Bullard',
            'age' => 20,
            'email' => 'JABullard@aol.com'
        ];
        
        $validator = $this->getValidator($data);
        
        $this->assertFalse( $validator->passes() );
        $this->assertTrue( $validator->fails() );
        $this->assertEquals(
            ['Must have a minimum value of 21.'], 
            $validator->errors()->all()
        );
        $this->assertEquals(
            ['Must have a minimum value of 21.'], 
            $validator->errors()->get('age')
        );
    }
    
    
    public function test_it_fails_validation_on_age_and_email()
    {
        $data = [
            'fname' => 'James',
            'mname' => 'Aaron',
            'lname' => 'Bullard',
            'age' => 20,
            'email' => 'JABullard'
        ];
        
        $validator = $this->getValidator($data);
        
        $this->assertFalse( $validator->passes() );
        $this->assertTrue( $validator->fails() );
        $this->assertEquals(
            ['Must have a minimum value of 21.', 'Invalid email.'], 
            $validator->errors()->all()
        );
        $this->assertEquals(
            ['Must have a minimum value of 21.'], 
            $validator->errors()->get('age')
        );
        $this->assertEquals(
            ['Invalid email.'], 
            $validator->errors()->get('email')
        );
    }
}