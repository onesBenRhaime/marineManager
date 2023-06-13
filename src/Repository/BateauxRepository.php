<?php

namespace App\Repository;

use App\Entity\Bateaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bateaux>
 *
 * @method Bateaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bateaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bateaux[]    findAll()
 * @method Bateaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BateauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bateaux::class);
    }

    public function save(Bateaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bateaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function search($searchTerm)
    {
        $qb = $this->createQueryBuilder('cd');

        if ($searchTerm) {
            $qb->where('cd.title LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%')
                ->orderBy('cd.id', 'DESC');
        }

        return $qb->getQuery()->getResult();
    }
    ////filtre AJAX
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                 FROM App\Entity\Bateaux e
                 WHERE e.Mat LIKE :str OR e.type LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }


////filtre ajax 


//    /**
//     * @return Bateaux[] Returns an array of Bateaux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bateaux
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
