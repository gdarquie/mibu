<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;

class JetonControllerTest extends ApiTestCase
{
    public function testPostCreateJeton()
    {
        $this->createInscrit();

        $data = array(
            "pseudo" => "Okita",
            "mdp" => "password"
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/jetons', [
            'body' => json_encode($data)
        ]);

//        $credentials = base64_encode('Okita:password');
//        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/jetons', [
//            'Authorization' => ['Basic '.$credentials]
//        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}