<?php

namespace App\Repository;

use App\Entity\Announces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Announces>
 *
 * @method Announces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announces[]    findAll()
 * @method Announces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announces::class);
    }

    // Add custom query methods here if needed
}
