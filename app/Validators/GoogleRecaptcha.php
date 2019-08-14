<?php

namespace Rules;

use GuzzleHttp\Client;

class GoogleRecaptcha
{
    public function validate(
        $attribute,
        $value,
        $parameters,
        $validator
    ){

        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['body'=>
                 [
                     'secret'=>'6Lekj4EUAAAAADPzh8U7VBj8yttkVsW_4cPtyjPc',
                     'response'=>$value
                 ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

}