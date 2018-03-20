<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 20/03/2018
 * Time: 22:45
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTestCase extends TestCase
{
    private static $staticClient;

    /**
     * @var Client
     */
    protected $client;

    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

    }

    public function setup()
    {
        $this->client = self::$staticClient;
    }
}