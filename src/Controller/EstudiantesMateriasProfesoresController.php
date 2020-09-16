<?php

namespace App\Controller;

use App\Entity\EstudiantesMateriasProfesores;
use App\Form\EstudiantesMateriasProfesoresType;
use App\Repository\EstudiantesMateriasProfesoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estudiantes/materias/profesores")
 */
class EstudiantesMateriasProfesoresController extends AbstractController
{
    /**
     * @Route("/", name="estudiantes_materias_profesores_index", methods={"GET"})
     */
    public function index(EstudiantesMateriasProfesoresRepository $estudiantesMateriasProfesoresRepository): Response
    {
        return $this->render('estudiantes_materias_profesores/index.html.twig', [
            'estudiantes_materias_profesores' => $estudiantesMateriasProfesoresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estudiantes_materias_profesores_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estudiantesMateriasProfesore = new EstudiantesMateriasProfesores();
        $form = $this->createForm(EstudiantesMateriasProfesoresType::class, $estudiantesMateriasProfesore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estudiantesMateriasProfesore);
            $entityManager->flush();

            return $this->redirectToRoute('estudiantes_materias_profesores_index');
        }

        return $this->render('estudiantes_materias_profesores/new.html.twig', [
            'estudiantes_materias_profesore' => $estudiantesMateriasProfesore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estudiantes_materias_profesores_show", methods={"GET"})
     */
    public function show(EstudiantesMateriasProfesores $estudiantesMateriasProfesore): Response
    {
        return $this->render('estudiantes_materias_profesores/show.html.twig', [
            'estudiantes_materias_profesore' => $estudiantesMateriasProfesore,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estudiantes_materias_profesores_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EstudiantesMateriasProfesores $estudiantesMateriasProfesore): Response
    {
        $form = $this->createForm(EstudiantesMateriasProfesoresType::class, $estudiantesMateriasProfesore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estudiantes_materias_profesores_index');
        }

        return $this->render('estudiantes_materias_profesores/edit.html.twig', [
            'estudiantes_materias_profesore' => $estudiantesMateriasProfesore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estudiantes_materias_profesores_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EstudiantesMateriasProfesores $estudiantesMateriasProfesore): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudiantesMateriasProfesore->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estudiantesMateriasProfesore);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estudiantes_materias_profesores_index');
    }
}
