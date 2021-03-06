<?php

namespace TMSolution\LoggingBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogRecordRepository extends EntityRepository
{

    public function getLastUnseenAlerts()
    {
        return $this->createQueryBuilder('l')
                        ->where('l.viewed IS NULL OR l.viewed = 0')
                        ->andWhere('l.channel = :channel')
                        ->setMaxResults('5')
                        ->setParameter('channel', 'app')
                        ->orderBy('l.id', 'DESC')
                        ->getQuery()
                        ->getResult();
    }

}
