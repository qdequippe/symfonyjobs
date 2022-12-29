<?php

namespace App\Repository\CommunityEvent;

use App\Entity\CommunityEvent\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Clock\ClockInterface;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly ClockInterface $clock)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Event[]
     */
    public function findUpcomingEvents(?int $limit = null): array
    {
        return $this->createQueryBuilder('event')
            ->where('event.startDate >= :today')
            ->setParameter('today', $this->clock->now())
            ->orderBy('event.startDate', Criteria::ASC)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Event[]
     */
    public function findPastEvents(): array
    {
        return $this->createQueryBuilder('event')
            ->where('event.startDate < :today')
            ->setParameter('today', $this->clock->now())
            ->orderBy('event.startDate', Criteria::DESC)
            ->getQuery()
            ->getResult();
    }
}
