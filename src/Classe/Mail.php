<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    //je mets les cles privates 
 private $api_key='0de0ac007af548f8ff4e195cb74c5e53';
 private $api_key_secret = '806f675d20d6d98acfa62ef40a21de27';

    // parametre avec 4 variables
    public function send($to_email,$to_name,$subject,$content ) 
    {
    //reinstencier vairaible
    $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
    
     //je mets le model de mailjet dans doc templates je remplis et j utilise des variables
        $body = [
            'Messages' => 
            [
                [
                    'From' => [
                        'Email' => "lavoiedudragonidf@gmail.com",
                        'Name' => "La voie du dragon"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 4029008,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    "Variables"=> [
                    "content"=> $content,
                                ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && dd($response->getData());
    }
}