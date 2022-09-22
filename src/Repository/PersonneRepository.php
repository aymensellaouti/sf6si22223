<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function add(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Personne[] Returns an array of Personne objects
//     */
    public function findPersonneByAge(QueryBuilder $qb,int $min, int $max)
    {
        if ($max)
         $qb->andWhere('p.age <= :ageMax')
            ->setParameter('ageMax', $max);
        if ($min)
         $qb->andWhere('p.age >= :ageMin')
            ->setParameter('ageMin', $min);
        return $qb;
    }
    public function findPersonnesInAgeInterval(int $min, int $max)
    {
        $qb = $this->createQueryBuilder('p');
        $qb = $this->findPersonneByAge($qb, $min, $max);
        $qb->orderBy('p.age', 'ASC');
       return $qb->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
