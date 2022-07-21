<?php

namespace App\Repository;

use App\Entity\QuizPartPerform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizPartPerform>
 *
 * @method QuizPartPerform|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizPartPerform|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizPartPerform[]    findAll()
 * @method QuizPartPerform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizPartPerformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizPartPerform::class);
    }

    public function add(QuizPartPerform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(QuizPartPerform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return QuizPartPerform[] Returns an array of QuizPartPerform objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuizPartPerform
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
