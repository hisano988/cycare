<?php

use App\Infrastructure\Eloquents\EloquentUser;

test('home page is displayed', function () {
    $user = EloquentUser::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/home');

    $response->assertOk();
});

test('record can be created', function () {
    $user = EloquentUser::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/home/record', [
            'start_date' => '2021-01-01',
            'is_calc_target' => true,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/home');
});
