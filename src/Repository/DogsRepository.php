<?php

namespace App\Repository;

use App\Entity\Dogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dogs[]    findAll()
 * @method Dogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dogs::class);
    }

    // /**
    //  * @return Dogs[] Returns an array of Dogs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dogs
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
