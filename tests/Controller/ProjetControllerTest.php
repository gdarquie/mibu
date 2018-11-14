<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class ProjetControllerTest extends ApiTestCase
{
    public function testPostProjet()
    {
        $fiction = $this->createFiction();

        $data = array(
            "titre" => "Titre de projet",
            "description" => "Description de projet",
            "fictionId" => $fiction->getId(),
            "public" => false
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/projets', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $projetUrl = $response->getHeader('Location');
        $response = $this->client->get($projetUrl[0], [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetProjet()
    {
        $fiction = $this->createFiction();
        $projet = $this->createProjetFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($projet->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetProjets()
    {
        $fiction = $this->createFiction();
        $element1 = $this->createProjetFiction($fiction);
        $element2 = $this->createProjetFiction($fiction);
        $element3 = $this->createProjetFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/projets/fiction/'.$fiction->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $payload = json_decode($response->getBody(true), true);
        $this->assertCount(3, $payload['items']);

        $this->assertArrayHasKey('titre', $payload['items'][0], "Il n'y a pas de champ titre");
        $this->assertEquals($element1->getId(), $payload['items'][0]['id']);
        $this->assertEquals($element2->getId(), $payload['items'][1]['id']);
        $this->assertEquals($element3->getId(), $payload['items'][2]['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPutProjet()
    {
        $fiction = $this->createFiction();
        $projet = $this->createProjetFiction($fiction);

        $data = array(
            "titre" => "Titre de projet modifié",
            "description" => "Description de projet",
            "fictionId" => $fiction->getId(),
            "public" => false
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteProjet()
    {
        $fiction = $this->createFiction();
        $projet = $this->createProjetFiction($fiction);
        $projet2 = $this->createProjetFiction($fiction); //use in test

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testProjetPublic()
    {
        //create non public project
        $fiction = $this->createFiction();
        $projet = $this->createProjetFiction($fiction);
        $this->assertFalse( $projet->isPublic());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        //update project for making it public
        $data = array(
            "titre" => "Titre de projet modifié",
            "description" => "Description de projet",
            "fictionId" => $fiction->getId(),
            "public" => true
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/projets/'.$projet->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

}