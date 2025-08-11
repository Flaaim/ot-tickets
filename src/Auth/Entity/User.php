<?php

namespace App\Auth\Entity;

use App\Cart\Entity\Cart;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DomainException;
use Doctrine\ORM\Mapping as ORM;
use App\Shared\Domain\ValueObject\Id as ValueID;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'auth_users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'auth_user_id', unique: true)]
    private Id $id;
    #[ORM\Column(type: 'datetime_immutable' )]
    private DateTimeImmutable $date;
    #[ORM\Column(type: 'auth_user_email', unique: true)]
    private Email $email;
    #[ORM\Column(type: 'auth_user_status', length: 16)]
    private Status $status;
    #[ORM\Column(type: 'string', nullable: true )]
    private ?string $passwordHash = null;
    #[ORM\Embedded(class: Token::class)]
    private ?Token $joinConfirmToken = null;
    #[ORM\Embedded(class: Token::class)]
    private ?Token $passwordResetToken = null;
    #[ORM\Column(type: 'auth_user_email', unique: true)]
    private ?Email $newEmail = null;
    #[ORM\Embedded(class: Token::class)]
    private ?Token $newEmailToken = null;
    #[ORM\Column(type: 'auth_user_role', length: 16)]
    private Role $role;
    #[ORM\OneToMany(targetEntity: UserNetwork::class, mappedBy: 'user', cascade: ['all'], orphanRemoval: true)]
    private Collection $networks;
    #[ORM\OneToOne(targetEntity: Cart::class, mappedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Cart $cart;
    public function __construct(Id $id, DateTimeImmutable $date, Email $email, Status $status)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->status = $status;
        $this->role = Role::user();
        $this->networks = new ArrayCollection();
        $this->cart = new Cart(ValueID::generate(), $this);
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
        $user->networks->add($identity);
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
        $this->networks->add($identity);
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
        return $this->networks->toArray();
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
    public function getCart(): ?Cart
    {
        return $this->cart;
    }
    #[ORM\Postload]
    public function checkEmbeds(): void
    {
        if ($this->joinConfirmToken && $this->joinConfirmToken->isEmpty()) {
            $this->joinConfirmToken = null;
        }
        if ($this->passwordResetToken && $this->passwordResetToken->isEmpty()) {
            $this->passwordResetToken = null;
        }
        if ($this->newEmailToken && $this->newEmailToken->isEmpty()) {
            $this->newEmailToken = null;
        }
    }
}
