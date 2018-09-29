<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;
use GuzzleHttp\Exception\RequestException;

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

        $payload = json_decode($response->getBody(true), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('token', $payload);
    }

    public function testPostCreateJetonInvalidCredentials()
    {
        $this->createInscrit();

        $data = array(
            "pseudo" => "Mauvais",
            "mdp" => "User"
        );

        try {
            $this->client->post(ApiTestCase::TEST_PREFIX . '/jetons', [
                'body' => json_encode($data)
            ]);

        } catch (RequestException $e ) {

            if ($e->getResponse()->getStatusCode() == '404') {
                $status = 404;
            }
        }

        $this->assertEquals(404, $status, "Aucun inscrit trouvé pour ce jeton.");
    }
}