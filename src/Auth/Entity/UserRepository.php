<?php

namespace App\Auth\Entity;

interface UserRepository
{
    public function hasByEmail(Email $email): bool;

    public function add(User $user): void;
}
