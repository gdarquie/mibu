<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class InscritControllerTest extends ApiTestCase
{
    public function testPostInscrit()
    {
        $data = array(
            "titre" => "Ajout de titre d'inscrit",
            "description" => "Une description d'inscrit comme exemple",
            "prenom" => "admin",
            "nom" => "Istrateur",
            "genre" => "femme",
            "email" => "okita@gmail.com",
            "dateNaissance"=> "1982-09-06"
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/inscrits', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $fictionUrl = $response->getHeader('Location');
        $response = $this->client->get($fictionUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";

    }

//    public function testGetFictions()
//    {
//       for ($i = 0; $i<25; $i++) {
//           $this->createFiction('Fiction '.$i);
//       }
//
//       //page 1
//        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/fictions');
//        $this->assertEquals(200, $response->getStatusCode());
//        $payload = json_decode($response->getBody(true), true);
//
//        $this->assertEquals('Fiction 5', $payload['items'][5]['titre']);
//        $this->assertEquals(10, $payload['count'], "Il n'y a pas le bon compte de fictions");
//        $this->assertEquals(25, $payload['total'], "Il n'y a pas le bon total de fictions");
//        $this->assertArrayHasKey('links', $payload, "Il n'y a pas de champ links");
//        $this->assertArrayHasKey('next', $payload['links'], "Il n'y a pas de champ links.next");
//
//        //page 2
//        $nextLink = $payload['links']['next'];
//        $response = $this->client->get($nextLink);
//        $payloadNext = json_decode($response->getBody(true), true);
//
//        $this->assertEquals('Fiction 15', $payloadNext['items'][5]['titre']);
//        $this->assertEquals(10, count($payloadNext['items']), "Il n'y a pas le bon compte de fictions");
//        $this->assertArrayHasKey('links', $payloadNext, "Il n'y a pas de champ links");
//        $this->assertArrayHasKey('next', $payloadNext['links'], "Il n'y a pas de champ links.next");
//
//        //last
//        $lastLink = $payload['links']['last'];
//        $response = $this->client->get($lastLink);
//        $payloadLast = json_decode($response->getBody(true), true);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals('Fiction 24', $payloadLast['items'][4]['titre']);
//
//    }
//
//    public function testGetFiction()
//    {
//        $fiction = $this->createFiction();
//
//        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/fictions/'.$fiction->getId());
//
//        $payload = json_decode($response->getBody(true), true);
//        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
//        $this->assertEquals($fiction->getId(), $payload['id']);
//        $this->assertEquals(200, $response->getStatusCode());
//
//        echo $response->getBody();
//        echo "\n\n";
//    }
//
    public function testPutInscrit()
    {
        $inscrit = $this->createInscrit();

        $data = array(
            "titre" => "Titre d'inscrit maj",
            "description" => "Description 1",
            "prenom" => "Misa",
            "nom" => "Jour",
            "genre" => "femme",
            "email" => "okita@gmail.com",
            "dateNaissance"=> "1982-09-06"
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId(), [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals( $data['prenom'], $payload['prenom']);
        $this->assertEquals( $data['genre'], $payload['genre']);
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testDeleteInscrit()
    {
        $inscrit = $this->createInscrit();

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
