<?php

namespace App\Auth\Command\ResetPassword\RequestReset;

use App\Auth\Entity\Email;
use App\Auth\Entity\Token;
use App\Auth\Entity\UserRepository;
use App\Auth\Service\PasswordResetTokenSender;
use App\Auth\Service\Tokenizer;
use App\Flusher;
use DateTimeImmutable;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private PasswordResetTokenSender $sender;
    public function __construct(UserRepository $users, Tokenizer $tokenizer, Flusher $flusher, PasswordResetTokenSender $sender)
    {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }
    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        $user = $this->users->getByEmail($email);

        $date = new DateTimeImmutable();

        $user->requestPasswordReset(
            $token = $this->tokenizer->generate($date),
            $date
        );

        $this->flusher->flush();

        $this->sender->send($email, $token);
    }
}
