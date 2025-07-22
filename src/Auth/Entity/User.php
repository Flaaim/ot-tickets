<?php

namespace App\Auth\Entity;

use ArrayObject;
use DateTimeImmutable;
use DomainException;

class User
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private Status $status;
    private ?string $passwordHash = null;
    private ?Token $joinConfirmToken = null;
    private ArrayObject $networks;
    private ?Token $passwordResetToken = null;
    public function __construct(Id $id, DateTimeImmutable $date, Email $email, Status $status)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->status = $status;
        $this->networks = new ArrayObject();
    }
    public static function requestJoinByEmail(
        Id $id,
        DateTimeImmutable $date,
        Email $email,
        string $passwordHash,
        Token $token
    ): self
    {
        $user = new self($id, $date, $email, Status::wait());
        $user->passwordHash = $passwordHash;
        $user->joinConfirmToken = $token;
        return $user;
    }

    public static function requestJoinByNetwork(
        Id $id,
        DateTimeImmutable $date,
        Email $email,
        NetworkIdentity $identity,
    ): self
    {
        $user = new self($id, $date, $email, Status::active());
        $user->networks->append($identity);
        return $user;
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
    public function getResetPasswordToken(): ?Token
    {
        return $this->passwordResetToken ;
    }
    public function confirmJoin(string $token, DateTimeImmutable $date): void
    {
        if ($this->joinConfirmToken === null) {
            throw new DomainException('Confirmation is not required.');
        }
        $this->joinConfirmToken->validate($token, $date);
        $this->status = Status::active();
        $this->joinConfirmToken = null;
    }
    public function attachNetwork(NetworkIdentity $identity): void
    {
        /** @var NetworkIdentity $existing */
        foreach ($this->networks as $existing) {
            if ($existing->isEqualTo($identity)) {
                throw new DomainException('Network is already attached.');
            }
        }
        $this->networks->append($identity);
    }
    public function isWait(): bool
    {
        return $this->status->isWait();
    }
    public function isActive(): bool
    {
        return $this->status->isActive();
    }
    public function requestPasswordReset(Token $token , DateTimeImmutable $date): void
    {
        if(!$this->isActive()) {
            throw new DomainException('User is not active.');
        }
        if ($this->passwordResetToken !== null && !$this->passwordResetToken->isExpiredTo($date)) {
            throw new DomainException('Resetting is already requested.');
        }
        $this->passwordResetToken = $token;

    }
    public function getNetworks(): array
    {
        /** @var NetworkIdentity[] */
        return $this->networks->getArrayCopy();
    }
}
