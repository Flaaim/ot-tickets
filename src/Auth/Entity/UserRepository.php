<?php

namespace App\Auth\Entity;

interface UserRepository
{
    public function hasByEmail(Email $email): bool;
    public function findByConfirmToken(string $token): ?User;
    /**
     * @param Email $email
     * @return User
     * @throws \DomainException
     */
    public function getByEmail(Email $email): User;

    public function findByPasswordResetToken(string $token): ?User;
    public function add(User $user): void;
    public function hasByNetwork(Network $identity): bool;
    public function findByNewEmailToken(string $token): ?User;
    public function get(Id $id): User;
}
