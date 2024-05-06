<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsBetweenDates(?\DateTimeImmutable $start = null, ?\DateTimeImmutable $end = null): array
    {
        if (null === $start && null === $end) {
            throw new \InvalidArgumentException('At least one date is required to operate this method.');
        }

        $qb = $this->createQueryBuilder('e');

        if ($start instanceof \DateTimeImmutable) {
            $qb->andWhere('e.startAt >= :start')
                ->setParameter('start', $start);
        }

        if ($end instanceof \DateTimeImmutable) {
            $qb->andWhere('e.endAt <= :end')
                ->setParameter('end', $end);
        }

        return $qb->getQuery()->getResult();
    }

    public function findLikeName(string $name): array
    {
        $qb = $this->createQueryBuilder('e');

        return $qb->andWhere($qb->expr()->like('e.name', ':name'))
            ->setParameter('name', sprintf("%%%s%%", $name))
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
