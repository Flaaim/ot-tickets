<?php

namespace App\Auth\Command\ChangeEmail\Confirm;

use App\Auth\Entity\UserRepository;
use App\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if(!$user = $this->users->findByNewEmailToken($command->token)) {
            throw new DomainException('Incorrect token.');
        }

        $user->changeEmail(
            $command->token,
            new DateTimeImmutable(),
        );

        $this->flusher->flush();
    }
}
