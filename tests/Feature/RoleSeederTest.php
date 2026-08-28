<?php

use App\Enums\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('it creates every finobeat role on the web guard', function () {
    $this->seed(RoleSeeder::class);

    $expected = array_map(fn (UserRole $role) => $role->value, UserRole::cases());

    expect(Role::pluck('name')->sort()->values()->all())
        ->toEqualCanonicalizing($expected)
        ->and(Role::pluck('guard_name')->unique()->all())->toBe(['web']);
});

test('it can run twice without creating duplicates', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoleSeeder::class);

    expect(Role::count())->toBe(count(UserRole::cases()));
});
