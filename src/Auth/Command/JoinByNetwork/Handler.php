<?php

namespace App\Auth\Command\JoinByNetwork;

use App\Auth\Entity\Email;
use App\Auth\Entity\Id;
use App\Auth\Entity\NetworkIdentity;
use App\Auth\Entity\User;
use App\Auth\Entity\UserRepository;
use App\Flusher;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    public function __construct(UserRepository $users, Flusher $flusher){
        $this->users = $users;
    }
    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        $identity = new NetworkIdentity($command->network, $command->identity);
        if($user = $this->users->hasByNetwork($identity)){
            throw new \DomainException('User with this network already exists.');
        }
        if($user = $this->users->hasByEmail($email)){
            throw new \DomainException('User with this email already exists.');
        }
        $user = User::requestJoinByNetwork(
            Id::generate(),
            new \DateTimeImmutable(),
            $email,
            $identity
        );
        $this->users->add($user);

        $this->flusher->flush();
    }

}
