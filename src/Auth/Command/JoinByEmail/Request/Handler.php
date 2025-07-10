<?php

namespace App\Auth\Command\JoinByEmail\Request;



use App\Auth\Entity\Email;
use App\Auth\Entity\Id;
use App\Auth\Entity\User;
use App\Auth\Entity\UserRepository;
use App\Auth\Service\JoinConfirmationSender;
use App\Auth\Service\PasswordHasher;
use App\Auth\Service\Tokenizer;
use App\Flusher;
use DateTimeImmutable;

class Handler
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordHasher $hasher,
        private readonly Tokenizer $tokenizer,
        private readonly JoinConfirmationSender $sender,
        private readonly Flusher $flusher
    )
    {}
    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if($this->users->hasByEmail($email)) {
            throw new \DomainException('User already exists.');
        }

        $date = new DateTimeImmutable();

        $user = new User(
            Id::generate(),
            $date,
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->generate($date)
        );

        $this->users->add($user);

        $this->flusher->flush();

        $this->sender->send($email, $token);

    }
}
