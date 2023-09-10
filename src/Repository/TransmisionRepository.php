<?php

namespace App\Repository;

use App\Entity\Transmision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transmision>
 *
 * @method Transmision|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transmision|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transmision[]    findAll()
 * @method Transmision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransmisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transmision::class);
    }

//    /**
//     * @return Transmision[] Returns an array of Transmision objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Transmision
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
