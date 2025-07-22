<?php

namespace App\Auth\Service;

use App\Auth\Entity\Email;
use App\Auth\Entity\Token;

interface PasswordResetTokenSender
{
    public function send(Email $email, Token $token): void;
}
