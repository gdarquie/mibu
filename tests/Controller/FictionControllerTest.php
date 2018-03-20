<?php

namespace App\tests\Controller;

use PHPUnit\Framework\TestCase;

class FictionControllerTest extends TestCase
{

    public function testPostFiction()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $data = array(
            'titre' => 'Nouvel exemple de titre de fiction',
            'description' => 'Une description de fiction comme exemple',
            'promesse' => 'Un contenu de promesse'
        );

        $response = $client->post('/fictions', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $fictionUrl = $response->getHeader('Location');
        $response = $client->get($fictionUrl[0]);

        echo $response->getBody();
        echo "\n\n";

    }
}
