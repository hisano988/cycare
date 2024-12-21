<?php

use App\Infrastructure\Eloquents\User;

test('home page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/home');

                    $response->assertOk();
});

test('record can be created', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/record', [
            'start_date' => '2021-01-01',
            'is_calc_target' => true,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/home');
});
