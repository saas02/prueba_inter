<?php

namespace App\Repository;

use App\Entity\Profesores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profesores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profesores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profesores[]    findAll()
 * @method Profesores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profesores::class);
    }
    
    /**
     * @return Materias[]
     */
    public function findAllInfoMaterias($info)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e.id as id_estudiante,e.nombres as nombre_estudiante,e.apellidos as apellido_estudiante, 
                m.id as id_materia, m.nombre as nombre_materia, 
                p.id as id_profesor, p.nombres as nombre_profesor, p.apellidos as apellido_profesor
            FROM App\Entity\Profesores p            
            INNER JOIN App\Entity\EstudiantesMateriasProfesores e_m_p WITH p.id = e_m_p.id_profesor
            INNER JOIN App\Entity\Materias m WITH m.id = e_m_p.id_materia
            INNER JOIN App\Entity\Estudiantes e WITH e.id = e_m_p.id_estudiante
            WHERE e_m_p.is_active = :estado
            AND e.is_active = :estado
            AND e_m_p.id_profesor = :id_profesor
            ORDER BY e.id ASC'
        )->setParameter('id_profesor', $info['id'])
        ->setParameter('estado', 1);

        // returns an array of Product objects
        return $query->getArrayResult();
    }

    // /**
    //  * @return Profesores[] Returns an array of Profesores objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profesores
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
