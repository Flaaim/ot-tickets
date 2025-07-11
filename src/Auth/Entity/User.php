<?php

namespace App\Auth\Entity;

use DateTimeImmutable;

class User
{
    public function __construct(
        private readonly Id $id,
        private readonly DateTimeImmutable $date,
        private readonly Email $email,
        private readonly string $passwordHash,
        private readonly ?Token $joinConfirmToken,
        private Status $status,
    )
    {
        $this->status = Status::wait();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }
    public function isWait(): bool
    {
        return $this->status->isWait();
    }
    public function isActive(): bool
    {
        return $this->status->isActive();
    }
}
