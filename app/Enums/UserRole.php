<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Financeiro = 'financeiro';
    case ArtistManager = 'artist_manager';
    case Artist = 'artist';
    case Producao = 'producao';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Financeiro => 'Financeiro',
            self::ArtistManager => 'Artist Manager',
            self::Artist => 'Artista',
            self::Producao => 'Produção',
        };
    }
}
