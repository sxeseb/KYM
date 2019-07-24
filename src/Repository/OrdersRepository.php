<?php

namespace App\Repository;

use App\Entity\Orders;
use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function findAllConsignesPlayer(Player $player)
    {
        return $this->createQueryBuilder('o')
            ->join('Product', 'p')
            ->andWhere('p.name = consigne')
            ->andWhere('o.player = :player')
            ->setParameter('playerId', $player)
            ->getQuery()
            ->getResult();
    }

    public function findCountConsignesPlayer(Player $player)
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.quantity) as nbConsigne')
            ->join('product', 'p')
            ->andWhere('p.name = :consigne')
            ->andWhere('o.player = :player')
            ->setParameter('player', $player)
            ->setParameter('consigne', 'consigne')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllOrdersPlayer(Player $player)
    {
        return $this->createQueryBuilder('o')
            ->join('Product', 'p')
            ->andWhere('p.name != consigne')
            ->andWhere('o.player = :player')
            ->setParameter('playerId', $player)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Orders[] Returns an array of Orders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orders
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
