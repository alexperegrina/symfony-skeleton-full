<?php
declare(strict_types=1);

namespace Auth\Infrastructure\Repository\Doctrine;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Auth\Domain\Entity\User;
use Auth\Domain\Exception\UserNotFoundByEmail;
use Auth\Domain\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Core\Domain\Exception\EntityNotFoundByIdException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
//        try {
            $this->_em->persist($user);
            $this->_em->flush();
//        } catch (UniqueConstraintViolationException $e) {
//            throw new EntityDuplicateException(User::class);
//        }
    }

    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): User
    {
        /** @var User $user */
        $user = $this->_em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (is_null($user)) {
            throw UserNotFoundByEmail::make($email);
        }

        return $user;
    }

    public function findByRole(string $role): array
    {
        $role = mb_strtoupper($role);

        return $this->createQueryBuilder('u')
            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
            ->setParameter('role', '"'.$role.'"')
            ->getQuery()
            ->getResult();
    }

    public function findByRoleAndEnabled(string $role): array
    {
        $role = mb_strtoupper($role);

        return $this->createQueryBuilder('u')
            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
            ->andWhere('u.enabled = 1')
            ->setParameter('role', '"'.$role.'"')
            ->getQuery()
            ->getResult();
    }

    public function findById(Uuid $id): User
    {
        /** @var User $user */
        $user = $this->_em->getRepository(User::class)->findOneBy(['id' => $id]);

        if (is_null($user)) {
            throw EntityNotFoundByIdException::make(User::class, $id->value());
        }

        return $user;
    }
}