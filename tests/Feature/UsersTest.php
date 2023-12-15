<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Roles;
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

    $user->save();

    expect($user->id)->toBeString();
});

it('Set role in one user', function () {

    $paa = faker()->password(6, 12);

    $user = new User([
        'name' => faker()->lastName(),
        'nick' => faker()->name(),
        'password' => $paa
    ]);

    $user->encrypt_password();

    $admin_role = new Role([
        "name" => Roles::ADMIN
    ]);

    expect($user->save())->toBeTrue();

    expect($admin_role->save())->toBeTrue();

    $user->assignRole(Roles::ADMIN);

    expect($user->hasRole(Roles::ADMIN))->toBeTrue();
});
