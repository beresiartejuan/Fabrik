<?php

use App\Contracts\UserCredentials;

test('User Credentials Test', function () {

    $invalid_credentials = new UserCredentials();

    expect($invalid_credentials->isAuthenticable())->toBeFalse();

    $valid_credentials = new UserCredentials("Juancito", "123456");

    expect($valid_credentials->isAuthenticable())->toBeTrue();

});
