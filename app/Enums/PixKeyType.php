<?php

namespace App\Enums;

enum PixKeyType: string
{
    case Cpf = 'cpf';
    case Cnpj = 'cnpj';
    case Email = 'email';
    case Phone = 'phone';
    case Random = 'random';

    public function label(): string
    {
        return match ($this) {
            self::Cpf => 'CPF',
            self::Cnpj => 'CNPJ',
            self::Email => 'E-mail',
            self::Phone => 'Telefone',
            self::Random => 'Chave aleatória',
        };
    }
}
