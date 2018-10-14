<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class InscritControllerTest extends ApiTestCase
{
    public function testPostInscrit()
    {
        $data = array(
            "pseudo" => "Okita",
            "password" => "motdepasse",
            "titre" => "Ajout de titre d'inscrit",
            "description" => "Une description d'inscrit comme exemple",
            "prenom" => "admin",
            "nom" => "Istrateur",
            "genre" => "femme",
            "email" => "okita@gmail.com",
            "dateNaissance"=> "1982-09-06"
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/inscrits', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $fictionUrl = $response->getHeader('Location');
        $response = $this->client->get($fictionUrl[0], [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";

    }

    public function testGetInscrits()
    {
       for ($i = 0; $i<25; $i++) {
           $this->createInscrit('Inscrit '.$i, 'Okita'.$i, 'mon'.$i.'@email.fr');
       }

       //page 1
        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/inscrits', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $payload = json_decode($response->getBody(true), true);

        $this->assertEquals('Inscrit 4', $payload['items'][5]['titre']);
        $this->assertEquals(10, $payload['count'], "Il n'y a pas le bon compte d'inscrits");
        $this->assertEquals(26, $payload['total'], "Il n'y a pas le bon total d'inscrits");
        $this->assertArrayHasKey('links', $payload, "Il n'y a pas de champ links");
        $this->assertArrayHasKey('next', $payload['links'], "Il n'y a pas de champ links.next");

        //page 2
        $nextLink = $payload['links']['next'];
        $response = $this->client->get($nextLink, [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $payloadNext = json_decode($response->getBody(true), true);

        $this->assertEquals('Inscrit 14', $payloadNext['items'][5]['titre']);
        $this->assertEquals(10, count($payloadNext['items']), "Il n'y a pas le bon compte d'inscrits");
        $this->assertArrayHasKey('links', $payloadNext, "Il n'y a pas de champ links");
        $this->assertArrayHasKey('next', $payloadNext['links'], "Il n'y a pas de champ links.next");

        //last
        $lastLink = $payload['links']['last'];
        $response = $this->client->get($lastLink, [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $payloadLast = json_decode($response->getBody(true), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Inscrit 23', $payloadLast['items'][4]['titre']);

    }

    public function testGetInscrit()
    {
        $inscrit = $this->createInscrit();

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($inscrit->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPutInscrit()
    {
        $inscrit = $this->createInscrit();

        $data = array(
            "pseudo" => "Okita",
            "password" => "motdepasse",
            "titre" => "Titre d'inscrit maj",
            "description" => "Description 1",
            "prenom" => "Misa",
            "nom" => "Jour",
            "genre" => "femme",
            "email" => "okita@gmail.com",
            "dateNaissance"=> "1982-09-06"
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);

        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

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

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/inscrits/'.$inscrit->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
