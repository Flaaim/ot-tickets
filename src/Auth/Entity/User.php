<?php

namespace App\Auth\Entity;

use ArrayObject;
use DateTimeImmutable;
use DomainException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'auth_users')]
class User
{
    private Id $id;
    #[ORM\Column(type: 'datetime_immutable' )]
    private DateTimeImmutable $date;
    private Email $email;
    private Status $status;
    #[ORM\Column(type: 'string', nullable: true )]
    private ?string $passwordHash = null;
    private ?Token $joinConfirmToken = null;
    private ?Token $passwordResetToken = null;
    private ?Email $newEmail = null;
    private ?Token $newEmailToken = null;
    private Role $role;
    private ArrayObject $networks;
    public function __construct(Id $id, DateTimeImmutable $date, Email $email, Status $status)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->status = $status;
        $this->role = Role::user();
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
        Id                $id,
        DateTimeImmutable $date,
        Email             $email,
        Network           $identity,
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
    public function attachNetwork(Network $identity): void
    {
        /** @var Network $existing */
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
    public function resetPassword(string $token, DateTimeImmutable $date, string $hash): void
    {
        if ($this->passwordResetToken === null) {
            throw new DomainException('Resetting is not requested.');
        }
        $this->passwordResetToken->validate($token, $date);
        $this->passwordResetToken = null;
        $this->passwordHash = $hash;
    }
    public function requestEmailChanging(Token $token, DateTimeImmutable $date, Email $email): void
    {
        if(!$this->isActive()) {
            throw new DomainException('User is not active.');
        }
        if($this->email->isEqualTo($email)) {
            throw new DomainException('Email is already same.');
        }

        if ($this->newEmailToken !== null && !$this->newEmailToken->isExpiredTo($date)) {
            throw new DomainException('Changing is already requested.');
        }

        $this->newEmail = $email;
        $this->newEmailToken = $token;
    }
    public function changeEmail(string $token, DateTimeImmutable $date): void
    {
        if ($this->newEmail === null || $this->newEmailToken === null) {
            throw new DomainException('Changing is not requested.');
        }
        $this->newEmailToken->validate($token, $date);
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->newEmailToken = null;
    }
    public function getNetworks(): array
    {
        /** @var Network[] */
        return $this->networks->getArrayCopy();
    }

    public function getNewEmail(): ?Email
    {
        return $this->newEmail;
    }

    public function getNewEmailToken(): ?Token
    {
        return $this->newEmailToken;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function changeRole(Role $role): void
    {
        $this->role = $role;
    }
}
