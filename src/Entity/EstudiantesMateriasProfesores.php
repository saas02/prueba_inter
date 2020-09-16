<?php

namespace App\Entity;

use App\Repository\EstudiantesMateriasProfesoresRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstudiantesMateriasProfesoresRepository::class)
 */
class EstudiantesMateriasProfesores
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_estudiante;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_materia;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_profesor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEstudiante(): ?int
    {
        return $this->id_estudiante;
    }

    public function setIdEstudiante(int $id_estudiante): self
    {
        $this->id_estudiante = $id_estudiante;

        return $this;
    }

    public function getIdMateria(): ?int
    {
        return $this->id_materia;
    }

    public function setIdMateria(int $id_materia): self
    {
        $this->id_materia = $id_materia;

        return $this;
    }

    public function getIdProfesor(): ?int
    {
        return $this->id_profesor;
    }

    public function setIdProfesor(int $id_profesor): self
    {
        $this->id_profesor = $id_profesor;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
