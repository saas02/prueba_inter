<?php

namespace App\Controller;

use App\Entity\Estudiantes;
use App\Form\EstudiantesType;
use App\Repository\EstudiantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estudiantes")
 */
class EstudiantesController extends AbstractController
{
    /**
     * @Route("/", name="estudiantes_index", methods={"GET"})
     */
    public function index(EstudiantesRepository $estudiantesRepository): Response
    {
        return $this->render('estudiantes/index.html.twig', [
            'estudiantes' => $estudiantesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estudiantes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estudiante = new Estudiantes();
        $form = $this->createForm(EstudiantesType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estudiante);
            $entityManager->flush();

            return $this->redirectToRoute('estudiantes_index');
        }

        return $this->render('estudiantes/new.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estudiantes_show", methods={"GET"})
     */
    public function show(Estudiantes $estudiante): Response
    {
        return $this->render('estudiantes/show.html.twig', [
            'estudiante' => $estudiante,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estudiantes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estudiantes $estudiante): Response
    {
        $form = $this->createForm(EstudiantesType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estudiantes_index');
        }

        return $this->render('estudiantes/edit.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estudiantes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Estudiantes $estudiante): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudiante->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estudiante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estudiantes_index');
    }
}
