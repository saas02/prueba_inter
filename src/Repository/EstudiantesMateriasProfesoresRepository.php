<?php

namespace App\Repository;

use App\Entity\EstudiantesMateriasProfesores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstudiantesMateriasProfesores|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstudiantesMateriasProfesores|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstudiantesMateriasProfesores[]    findAll()
 * @method EstudiantesMateriasProfesores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstudiantesMateriasProfesoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstudiantesMateriasProfesores::class);
    }

    // /**
    //  * @return EstudiantesMateriasProfesores[] Returns an array of EstudiantesMateriasProfesores objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EstudiantesMateriasProfesores
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
