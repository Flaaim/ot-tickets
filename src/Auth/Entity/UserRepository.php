<?php

namespace App\Auth\Entity;

interface UserRepository
{
    public function hasByEmail(Email $email): bool;
    public function findByConfirmToken(string $token): ?User;
    public function add(User $user): void;
    public function hasByNetwork(NetworkIdentity $identity): bool;

    public function get(Id $id): User;
}
