<?php

namespace App\Auth\Command\AttachNetwork;

use App\Auth\Entity\Id;
use App\Auth\Entity\NetworkIdentity;
use App\Auth\Entity\UserRepository;
use App\Flusher;

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
        $identity = new NetworkIdentity($command->network, $command->identity);

        if($users->hasByNetwork($identity)) {
            throw new \DomainException('User with this network already exists.');
        }

        $user = $this->users->get(new Id($command->id));

        $user->attachNetwork($identity);

        $this->flusher->flush();
    }
}
