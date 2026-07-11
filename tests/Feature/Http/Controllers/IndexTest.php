<?php

test('it should render the index page', function () {
    $this->get('/')->assertOk();
});
