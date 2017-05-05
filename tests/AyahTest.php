<?php

use AlQuranCloud\ApiClient\Client;

class AyahTest extends PHPUnit_Framework_TestCase
{
    public $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function testAyah()
    {
        $r = $this->client->ayah(2);
        $this->assertEquals(200, $r->code);
        $this->assertEquals(1, $r->data->surah->number);
        $r2 = $this->client->ayah('2:2');
        $this->assertEquals(200, $r2->code);
        $this->assertEquals(2, $r2->data->surah->number);
        $this->assertEquals(9, $r2->data->number);
    }
}
