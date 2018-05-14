<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;
use GuzzleHttp\Exception\RequestException;

class TexteControllerTest extends ApiTestCase
{
    public function testPostTexte()
    {
        $fiction = $this->createFiction();

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse',
            'fiction' => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
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

    public function testPostTexteWithoutFiction()
    {
        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse'
        );

        try {
            $this->client->post(ApiTestCase::TEST_PREFIX . '/textes', [
                'body' => json_encode($data)
            ]);
            $status = 200;

        } catch (RequestException $e ) {

            if ($e->getResponse()->getStatusCode() == '400') {
                $status = 400;
            }
        }

        $this->assertEquals(400, $status, "Créer un texte sans indiquer de fiction devrait produire une erreur 400.");
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

    public function testPutTexte()
    {
        $fiction = $this->createFiction();
        $texte = $this->createTexteFiction($fiction);

        $data = array(
            'titre' => 'Titre de texte modifié',
            'description' => 'Un contenu de texte',
            'type' => 'promesse'
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/textes/'.$texte->getId(), [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/textes/'.$texte->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteTexte()
    {
        $fiction = $this->createFiction();
        $texte = $this->createTexteFiction($fiction);

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/textes/'.$texte->getId());
        $this->assertEquals(202, $response->getStatusCode());
    }

    public function testPostTexteForPartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse',
            'fiction' => $fiction->getId(),
            'item' => $partie->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertArrayHasKey('itemId', $payload, "Il n'y a pas de champ item");
        $this->assertEquals( $data['item'], $payload['itemId'], "L'id item ne correspond pas");

        echo $response->getBody();
        echo "\n\n";
    }
}