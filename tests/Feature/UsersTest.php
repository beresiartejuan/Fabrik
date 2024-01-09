<?php

use App\Models\User;
use App\Repositories\UserRepository;
use App\Roles;
use function Pest\Faker\faker;
use function Pest\Laravel\post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->userRepository = new UserRepository;
    $this->user_data = [
        'name' => faker()->lastName(),
        'nick' => faker()->name(),
        'password' => faker()->password(),
    ];

    Role::create([
        "name" => Roles::ADMIN,
    ]);

    $this->user_custom_check = function ($user, $data) {
        expect($user)->toBeInstanceOf(User::class);
        expect($user->id)->toBeString();
        expect($user->password === $data['password'])->toBeFalse();
        expect($user->check_password($data['password']))->toBeTrue();
    };
});

it('Create a user (without repository)', function () {

    $original_password = faker()->password();

    $user = new User($this->user_data);

    $user->encrypt_password();

    expect($user->save())->toBeTrue();

    $custom = $this->user_custom_check;

    $custom($user, $this->user_data);
});

it('Set role in one user (without repository)', function () {

    $user = new User($this->user_data);

    $user->encrypt_password();

    expect($user->save())->toBeTrue();

    $user->assignRole(Roles::ADMIN);

    expect($user->hasRole(Roles::ADMIN))->toBeTrue();

    $custom = $this->user_custom_check;

    $custom($user, $this->user_data);
});

it('Create a user (with repository)', function () {

    $user = $this->userRepository->create($this->user_data);

    expect(count(User::all()))->toBe(1);

    $custom = $this->user_custom_check;

    $custom($user, $this->user_data);
});

it('Set role in one user (with repository)', function () {

    $user = $this->userRepository->create($this->user_data);

    $user->assignRole(Roles::ADMIN);

    expect($user->hasRole(Roles::ADMIN))->toBeTrue();

    $all_admins = $this->userRepository->admins();

    expect(count($all_admins))->toBe(1);

    $custom = $this->user_custom_check;

    $custom($user, $this->user_data);
});

it('Authentication user', function () {

    $user = $this->userRepository->create($this->user_data);

    $user->assignRole(Roles::ADMIN);

    $custom = $this->user_custom_check;

    $custom($user, $this->user_data);

    $res = post('/auth/login', [
        "nick" => $this->user_data["nick"],
        "password" => $this->user_data["password"],
    ]);

    $res->assertStatus(200);

});
