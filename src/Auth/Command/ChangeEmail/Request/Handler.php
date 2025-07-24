<?php

namespace App\Auth\Command\ChangeEmail;

use App\Auth\Command\ChangeEmail\Request\Command;
use App\Auth\Entity\Email;
use App\Auth\Entity\Id;
use App\Auth\Entity\UserRepository;
use App\Auth\Service\NewEmailConfirmTokenSender;
use App\Auth\Service\Tokenizer;
use App\Flusher;
use DateTimeImmutable;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private NewEmailConfirmTokenSender $sender;
    public function __construct(UserRepository $users, Tokenizer $tokenizer, Flusher $flusher, NewEmailConfirmTokenSender $sender)
    {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }
    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $email = new Email($command->email);

        if($this->users->hasByEmail($email)) {
            throw new \DomainException('Email is already in use.');
        }

        $date = new DateTimeImmutable();

        $user->requestEmailChanging(
            $token = $this->tokenizer->generate($date),
            $date,
            $email
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
