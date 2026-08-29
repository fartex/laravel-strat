<?php

test('it should report the default connection status', function () {
    $this->get($this->stratUrl('/database-status'))
        ->assertOk()
        ->assertJson([
            [
                'online' => true,
                'name' => config('database.default'),
            ],
        ]);
});
