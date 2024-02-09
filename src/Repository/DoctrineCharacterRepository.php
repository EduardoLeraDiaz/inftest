<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
#[ORM\Entity(repositoryClass: Character::class)]
class DoctrineCharacterRepository extends ServiceEntityRepository implements CharacterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    function getCharacters(): array
    {
        return $this->findAll();
    }

    function getCharactersByName(string $name): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :startsWith')
            ->setParameter('startsWith', $name . '%') // we need a full text index if we want to do that operation and ensure it can be too slow.
            ->getQuery()
            ->getResult();
    }
}