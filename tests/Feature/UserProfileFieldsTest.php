<?php

use App\Enums\PixKeyType;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('new user gets the finobeat default attributes', function () {
    $user = new User;

    expect($user->status)->toBe(UserStatus::Active)
        ->and($user->locale)->toBe('pt_BR')
        ->and($user->timezone)->toBe('America/Sao_Paulo');
});

test('status and pix key type are cast to enums', function () {
    $user = User::factory()->create([
        'status' => UserStatus::Inactive,
        'pix_key_type' => PixKeyType::Email,
    ]);

    $fresh = $user->fresh();

    expect($fresh->status)->toBe(UserStatus::Inactive)
        ->and($fresh->pix_key_type)->toBe(PixKeyType::Email);
});

test('birth date is cast to a date instance', function () {
    $user = User::factory()->create(['birth_date' => '1995-06-15']);

    expect($user->fresh()->birth_date)->toBeInstanceOf(DateTimeInterface::class)
        ->and($user->fresh()->birth_date->format('Y-m-d'))->toBe('1995-06-15');
});

test('document and pix key are encrypted at rest and decrypted on access', function () {
    $user = User::factory()->create([
        'document' => '12345678909',
        'pix_key' => 'artist@finobeat.test',
    ]);

    $raw = DB::table('users')->where('id', $user->id)->first();

    expect($raw->document)->not->toBe('12345678909')
        ->and($raw->pix_key)->not->toBe('artist@finobeat.test')
        ->and($user->fresh()->document)->toBe('12345678909')
        ->and($user->fresh()->pix_key)->toBe('artist@finobeat.test');
});

test('document and pix key are hidden from array output', function () {
    $user = User::factory()->create([
        'document' => '12345678909',
        'pix_key' => 'artist@finobeat.test',
    ]);

    expect($user->toArray())
        ->not->toHaveKey('document')
        ->not->toHaveKey('pix_key');
});

test('a user can be linked to whoever invited them', function () {
    $inviter = User::factory()->create();
    $invitee = User::factory()->invited()->create(['invited_by_id' => $inviter->id]);

    expect($invitee->invitedBy->is($inviter))->toBeTrue();
});

test('the invited factory state leaves the account without a password', function () {
    $user = User::factory()->invited()->create();

    expect($user->status)->toBe(UserStatus::Invited)
        ->and($user->password)->toBeNull()
        ->and($user->invited_at)->not->toBeNull();
});
