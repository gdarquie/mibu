<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class TexteControllerTest extends ApiTestCase
{
    public function testGetTexte()
    {
        $texteId = 1;

        $response = $this->client->get('/textes/'.$texteId);
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testPostTexte()
    {
        $data = array(
            'titre' => 'Titre de texte',
            'contenu' => 'Un contenu de texte',
        );

        $response = $this->client->post('/textes', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $fictionUrl = $response->getHeader('Location');
        $response = $this->client->get($fictionUrl[0]);

        $finishedData = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titres', $finishedData, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";

    }
}