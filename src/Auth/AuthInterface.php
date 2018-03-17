<?php
declare(strict_types = 1);

namespace SONFin\Auth;

use SONFin\Models\UserInterface;

interface AuthInterface
{
    public function login(array $credentials): bool;

    public function check(): bool;

    public function user(): ?UserInterface;

    public function logout(): void;

    public function hashPassword(string $password): string;

}