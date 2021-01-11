<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthentication()
    {
        // Teste para saber se o usuário consegue se autenticar (verificar se status 200 com usuário e senha corretos)
        $response = $this->call('POST','/authentication/login',['email'=>'thiagoaaugustols@gmail.com','senha'=>'123456']);
        $this->assertEquals(200, $response->status());
    }
}
