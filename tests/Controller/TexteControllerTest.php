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
            'fictionId' => $fiction->getId()
        );

        $token = $this->getService('lexik_jwt_authentication.encoder')
            ->encode(['pseduo' => 'Okita']);

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
            'body' => json_encode($data),
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(), true);
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

        $status = 200;

        try {
            $this->client->post(ApiTestCase::TEST_PREFIX . '/textes', [
                'body' => json_encode($data)
            ]);

        } catch (RequestException $e ) {

            if ($e->getResponse()->getStatusCode() == '401') {
                $status = 401;
            }
        }

        $this->assertEquals(401, $status, "Créer un texte sans indiquer de fiction devrait produire une erreur 401.");
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

    public function testGetTextes()
    {
        $fiction = $this->createFiction();
        $texte1 = $this->createTexteFiction($fiction);
        $texte2 = $this->createTexteFiction($fiction);
        $texte3 = $this->createTexteFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/textes/fiction/'.$fiction->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertCount(3, $payload['items']);

        $this->assertArrayHasKey('titre', $payload['items'][0], "Il n'y a pas de champ titre");
        $this->assertEquals($texte1->getId(), $payload['items'][0]['id']);
        $this->assertEquals($texte2->getId(), $payload['items'][1]['id']);
        $this->assertEquals($texte3->getId(), $payload['items'][2]['id']);
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
            'type' => 'promesse',
            'fictionId' => $fiction->getId()
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
        $texte2 = $this->createTexteFiction($fiction);

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/textes/'.$texte->getId());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostTexteForPartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse',
            'fictionId' => $fiction->getId(),
            'itemId' => $partie->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertArrayHasKey('itemId', $payload, "Il n'y a pas de champ item");

        $this->assertEquals( $data['itemId'], $payload['itemId'], "L'id item ne correspond pas");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPostTexteForPersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse',
            'fictionId' => $fiction->getId(),
            'itemId' => $personnage->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertArrayHasKey('itemId', $payload, "Il n'y a pas de champ item");
        $this->assertEquals( $data['itemId'], $payload['itemId'], "L'id item ne correspond pas");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPostTexteForEvenement()
    {
        $fiction = $this->createFiction();
        $partie = $this->createEvenementFiction($fiction);

        $data = array(
            'titre' => 'Titre de texte',
            'description' => 'Un contenu de texte',
            'type' => 'promesse',
            'fictionId' => $fiction->getId(),
            'itemId' => $partie->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/textes', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $texteUrl = $response->getHeader('Location');
        $response = $this->client->get($texteUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertArrayHasKey('itemId', $payload, "Il n'y a pas de champ item");
        $this->assertEquals( $data['itemId'], $payload['itemId'], "L'id item ne correspond pas");

        echo $response->getBody();
        echo "\n\n";
    }

}