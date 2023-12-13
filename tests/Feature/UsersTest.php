<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Faker\faker;

uses(RefreshDatabase::class);

it('Create a user', function () {

    $original_password = faker()->password();

    $user = new User([
        'name' => faker()->lastName(),
        'nick' => faker()->name(),
        'password' => $original_password
    ]);

    $user->encrypt_password();

    expect($user)->toBeInstanceOf(User::class);

    expect($user->password === $original_password)->toBeFalse();

    expect($user->check_password($original_password))->toBeTrue();
});
