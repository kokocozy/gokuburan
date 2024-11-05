<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Client = 'client';
    case User = 'user';

    public static function labels(): array
    {
        return [
            self::Admin->value => 'Admin',
            self::Client->value => 'Client',
            self::User->value => 'User',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }

    public static function labelFromValue(string $value): string
    {
        return self::labels()[$value] ?? $value;
    }

    public static function instance(string $value): self
    {
        return match ($value) {
            self::Admin->value => self::Admin,
            self::Client->value => self::Client,
            self::User->value => self::User,
            default => throw new \InvalidArgumentException("Invalid value for Role: {$value}"),
        };
    }

    public function is(self $role): bool
    {
        return $this->value === $role->value;
    }
}
