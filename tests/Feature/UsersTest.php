<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use App\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Faker\faker;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->userRepository = new UserRepository;
    $this->user_data = [
        'name' => faker()->lastName(),
        'nick' => faker()->name(),
        'password' => faker()->password()
    ];

    Role::create([
        "name" => Roles::ADMIN
    ]);
});

it('Create a user (without repository)', function () {

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

it('Set role in one user (without repository)', function () {

    $paa = faker()->password(6, 12);

    $user = new User([
        'name' => faker()->lastName(),
        'nick' => faker()->name(),
        'password' => $paa
    ]);

    $user->encrypt_password();

    expect($user->save())->toBeTrue();

    $user->assignRole(Roles::ADMIN);

    expect($user->hasRole(Roles::ADMIN))->toBeTrue();
});

it('Create a user (with repository)', function () {

    $user = $this->userRepository->create($this->user_data);

    expect($user)->toBeInstanceOf(User::class);

    expect($user->password === $this->user_data['password'])->toBeFalse();

    expect($user->check_password($this->user_data['password']))->toBeTrue();

    expect($user->id)->toBeString();
});

it('Set role in one user (with repository)', function () {

    $user = $this->userRepository->create($this->user_data);

    $user->assignRole(Roles::ADMIN);

    expect($user->hasRole(Roles::ADMIN))->toBeTrue();
});
