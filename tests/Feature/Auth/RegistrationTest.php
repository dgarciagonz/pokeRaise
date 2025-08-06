<?php


test('new users can register', function () {
    
    $response = $this->post('/register', [
        'username' => 'TestUser', 
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    
    $response->assertSessionHasNoErrors();
    $this->assertAuthenticated();

    $response->assertRedirect(route('dashboard'));
});