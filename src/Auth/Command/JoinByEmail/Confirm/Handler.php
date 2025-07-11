<?php

namespace App\Auth\Command\JoinByEmail\Confirm;

use App\Auth\Entity\UserRepository;
use App\Flusher;
use DateTime;
use DateTimeImmutable;
use DomainException;

class Handler
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UserRepository $users,
    ){}

    public function handle(Command $command): void
    {
        if(!$user = $this->users->findByConfirmToken($command->token)) {
            throw new DomainException('Token does not exist.');
        }
        $user->confirmJoin($command->token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}
