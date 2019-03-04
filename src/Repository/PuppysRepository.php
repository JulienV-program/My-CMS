<?php

namespace App\Repository;

use App\Entity\Puppys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Puppys|null find($id, $lockMode = null, $lockVersion = null)
 * @method Puppys|null findOneBy(array $criteria, array $orderBy = null)
 * @method Puppys[]    findAll()
 * @method Puppys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PuppysRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Puppys::class);
    }

    // /**
    //  * @return Puppys[] Returns an array of Puppys objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Puppys
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
