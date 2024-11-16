<?php

test('can render login page', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});
