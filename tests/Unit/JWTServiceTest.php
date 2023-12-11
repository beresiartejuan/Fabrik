<?php

use App\Services\JWTService;

test('jwtservice write-read', function () {

    $oringinal_message = "Hello!";

    $original_data = [
        "message" => $oringinal_message
    ];

    $encode = JWTService::write($original_data);

    $decode = JWTService::read($encode);

    expect($decode)->toBeArray();

    expect($decode)->toEqual($original_data);
});
