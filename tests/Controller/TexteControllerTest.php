<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class TexteControllerTest extends ApiTestCase
{
    public function testPostTexte()
    {
        $fiction = $this->createFiction();

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse'
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes/fiction='.$fiction->getId(), [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";

    }

    public function testGetTexte()
    {
        $fiction = $this->createFiction();
        $texte = $this->createTexteFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/textes/'.$texte->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($texte->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }
}