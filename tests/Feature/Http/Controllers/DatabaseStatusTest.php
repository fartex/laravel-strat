<?php

test('it should report the default connection status', function () {
    $this->get('/database-status')
        ->assertOk()
        ->assertJson([
            [
                'online' => true,
                'name' => config('database.default'),
            ],
        ]);
});
