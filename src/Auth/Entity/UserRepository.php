<?php

namespace App\Auth\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class UserRepository
{
    private EntityRepository $repo;
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(User::class);
        $this->repo = $repo;
        $this->em = $em;

    }
    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.email = :email')
            ->setParameter('email', $email)
            ->getQuery()->getSingleScalarResult() > 0;
    }
    public function findByConfirmToken(string $token): ?User
    {
        return $this->repo->findOneBy(['joinConfirmToken.value' => $token]);
    }
    /**
     * @param Email $email
     * @return User
     * @throws \DomainException
     */
    public function getByEmail(Email $email): User
    {
        if (!$user = $this->repo->findOneBy(['email' => $email->getValue()])) {
            throw new DomainException('User is not found.');
        }
        /** @var User $user */
        return $user;
    }

    public function findByPasswordResetToken(string $token): ?User
    {
        return $this->repo->findOneBy(['passwordResetToken.value' => $token]);
    }
    public function add(User $user): void
    {
        $this->em->persist($user);
    }
    public function hasByNetwork(Network $identity): bool
    {
        return $this->repo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->innerJoin('t.network', 'n')
            ->andWhere('n.network.name = :name and n.network.identity = :identity')
            ->setParameter('name', $identity->getName())
            ->setParameter('identity', $identity->getIdentity())
            ->getQuery()->getSingleScalarResult() > 0;
    }
    public function findByNewEmailToken(string $token): ?User
    {
        return $this->repo->findOneBy(['newEmailToken.value' => $token]);
    }
    public function get(Id $id): User
    {
        if(!$user =  $this->repo->find($id->getValue())){
            throw new DomainException('User not found.');
        }
        /** @var User $user */
        return $user;
    }
}
