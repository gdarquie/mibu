<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class LieuControllerTest extends ApiTestCase
{
    public function testPostLieu()
    {
        $fiction = $this->createFiction();

        $data = array(
            "titre" => "Titre d'évènement via post évènement",
            "description" => "Description d'évènement",
            "lat" => 10.786,
            "long" => 12.897,
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/lieux', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $evenementUrl = $response->getHeader('Location');
        $response = $this->client->get($evenementUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetLieu()
    {
        $fiction = $this->createFiction();
        $lieu = $this->createLieuFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/lieux/'.$lieu->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($lieu->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetLieux()
    {
        $fiction = $this->createFiction();
        $element1 = $this->createLieuFiction($fiction);
        $element2 = $this->createLieuFiction($fiction);
        $element3 = $this->createLieuFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/lieux/fiction/'.$fiction->getId());
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

    public function testPutLieu()
    {
        $fiction = $this->createFiction();
        $lieu = $this->createLieuFiction($fiction);

        $data = array(
            "titre" => "Titre de lieu modifié",
            "description" => "Description de lieu modifié",
            "lat" => 10.786,
            "long" => 12.897,
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/lieux/'.$lieu->getId(), [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/lieux/'.$lieu->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals( $data['lat'], $payload['lat']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteLieu()
    {
        $fiction = $this->createFiction();
        $lieu = $this->createLieuFiction($fiction);
        $lieu2 = $this->createLieuFiction($fiction); //use in test

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/lieux/'.$lieu->getId());
        $this->assertEquals(200, $response->getStatusCode());
    }

}