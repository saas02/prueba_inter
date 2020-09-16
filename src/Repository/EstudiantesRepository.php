<?php

namespace App\Repository;

use App\Entity\Estudiantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estudiantes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estudiantes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estudiantes[]    findAll()
 * @method Estudiantes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstudiantesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estudiantes::class);
    }
    
    /**
     * @return Estudiante[]
     */
    public function findAllInfoMaterias($info)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e.id as id_estudiante,e.nombres as nombre_estudiante,e.apellidos as apellido_estudiante, 
                m.id as id_materia, m.nombre as nombre_materia, 
                p.id as id_profesor, p.nombres as nombre_profesor, p.apellidos as apellido_profesor
            FROM App\Entity\Estudiantes e            
            INNER JOIN App\Entity\EstudiantesMateriasProfesores e_m_p WITH e.id = e_m_p.id_estudiante
            INNER JOIN App\Entity\Materias m WITH m.id = e_m_p.id_materia
            INNER JOIN App\Entity\Profesores p WITH p.id = e_m_p.id_profesor
            WHERE e_m_p.is_active = :estado
            AND e.is_active = :estado
            AND e_m_p.id_estudiante = :id_estudiante
            ORDER BY e.id ASC'
        )->setParameter('id_estudiante', $info['id'])
        ->setParameter('estado', 1);

        // returns an array of Product objects
        return $query->getArrayResult();
    }
    
    
    /**
     * @return Estudiantes[]
     */
    public function findAllStudentsMaterias($info)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e.id as id_estudiante,e.nombres as nombre_estudiante,e.apellidos as apellido_estudiante, e_m_p.id_materia, e_m_p.id_profesor
            FROM App\Entity\Estudiantes e            
            INNER JOIN App\Entity\EstudiantesMateriasProfesores e_m_p WITH e.id = e_m_p.id_estudiante            
            WHERE e_m_p.is_active = :estado
            AND e.is_active = :estado
            AND e_m_p.id_estudiante <> :id_estudiante
            ORDER BY e.id ASC'
        )->setParameter('id_estudiante', $info['id'])
        ->setParameter('estado', 1);

        // returns an array of Product objects
        return $query->getArrayResult();
    }
    
    /**
     * @return Estudiante[]
     */
    public function findAllRegisterMaterias($info)
    {
        $entityManager = $this->getEntityManager();
        
        $queryMaterias = $entityManager->createQuery(
            'SELECT m.id, m.nombre
            FROM App\Entity\Materias m                        
            WHERE m.is_active = :estado
            AND m.id IN (
                SELECT e_m_p_1.id_materia
                FROM App\Entity\EstudiantesMateriasProfesores e_m_p_1
                WHERE e_m_p_1.id_estudiante = :id_estudiante
                AND e_m_p_1.is_active = :estado
            )            
            ORDER BY m.id ASC'
        )->setParameter('id_estudiante', $info['id'])
        ->setParameter('estado', 1)
        ->getArrayResult();
        
        if(count($queryMaterias) >= 3){
            return ['error' => 'No puede registrar mas materias'];
        }else{
            $query = $entityManager->createQuery(
                'SELECT m.id, m.nombre
                FROM App\Entity\Materias m                        
                WHERE m.is_active = :estado
                AND m.id NOT IN (
                    SELECT e_m_p_1.id_materia
                    FROM App\Entity\EstudiantesMateriasProfesores e_m_p_1
                    WHERE e_m_p_1.id_estudiante = :id_estudiante
                    AND e_m_p_1.is_active = :estado
                )            
                ORDER BY m.id ASC'
            )->setParameter('id_estudiante', $info['id'])
            ->setParameter('estado', 1);

            // returns an array of Product objects
            return $query->getArrayResult();
        }        
        
    }
    
    /**
     * @return Estudiante[]
     */
    public function findAllRegisterProfesores($info)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.id, p.nombres, p.apellidos
            FROM App\Entity\Profesores p                        
            WHERE p.is_active = :estado
            AND p.id NOT IN (
                SELECT e_m_p.id_profesor
                FROM App\Entity\EstudiantesMateriasProfesores e_m_p
                WHERE e_m_p.id_estudiante = :id_estudiante
                AND e_m_p.is_active = :estado
            )
            ORDER BY p.id ASC'
        )->setParameter('id_estudiante', $info['id'])
        ->setParameter('estado', 1);
        
//        var_dump($query->getParameters());
//var_dump($query->getSQL());die;
        // returns an array of Product objects
        return $query->getArrayResult();
    }

    // /**
    //  * @return Estudiantes[] Returns an array of Estudiantes objects
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
    public function findOneBySomeField($value): ?Estudiantes
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
