<?php
namespace App\Classes\Base;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class Model 
{

    // Validation and Runtime Errors
    public static $errors = []; 
    
    public function AddRuntimeError(string $key, string $message):bool
    {
        self::$errors[$key] = $message;
        return false;
    }

    public function Validate($request)
    {
        $validate = 
            Validator::Make(
                is_array($request) ? $request : $request->all(),
                $this->Rules(),
                require(app_path().'/../lang/fa/validation.php'), 
                $this->AttributesLabel()
            )
        ;

        if(!$validate->errors()->isEmpty())
        {    //$validator->fails()
            self::$errors = $validate->errors();
            return false;
        }

        foreach(is_array($request) ? $request : $request->all() as $key => $value)
            $this->{$key} = $value;
        
        return true;
    }

    public function Success(array $values = [])
    {
        return json_encode(
            array_merge(
                [
                    'status' => true,
                ],
                $values
            )
        );
    }
    
    public function UnSuccess()
    {
        return json_encode(
            array_merge(
                [
                    'status' => false,
                    'errors' => self::$errors,
                ],
            )
        );
    }

    public function Expire()
    {
        return json_encode(
            [
                'status' => false,
                'errors' => textLabel(17,'errors'),
            ],  
        );
    }

    public function Inaccessibility()
    {
        return json_encode(
            [
                'status' => false,
                'errors' => textLabel(4,'errors'),
            ],  
        );
    }

    public function unSold()
    {
        return json_encode(
            [
                'status' => false,
                'errors' => textLabel(82,'errors'),
            ],  
        );
    }

    public function Unauthorized()
    {
        return new Response([
            'status' => false,
            'errors' => textLabel(3,'errors')
        ], 401);
    }

    public function Undefined()
    {
        return json_encode(
            [
                'status' => false,
                'errors' => textLabel(44,'errors'),
            ],  
        );
    }
}