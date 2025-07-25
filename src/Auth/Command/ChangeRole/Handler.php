<?php

namespace App\Auth\Command\ChangeRole;

use App\Auth\Entity\Id;
use App\Auth\Entity\Role;
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
        $user = $this->users->get(new Id($command->id));

        $user->changeRole(
            new Role($command->role)
        );

        $this->flusher->flush();
    }

}
