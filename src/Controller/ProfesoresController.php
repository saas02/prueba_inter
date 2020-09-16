<?php

namespace App\Controller;

use App\Entity\Profesores;
use App\Form\ProfesoresType;
use App\Repository\ProfesoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profesores")
 */
class ProfesoresController extends AbstractController
{
    /**
     * @Route("/", name="profesores_index", methods={"GET"})
     */
    public function index(ProfesoresRepository $profesoresRepository): Response
    {
        return $this->render('profesores/index.html.twig', [
            'profesores' => $profesoresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="profesores_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profesore = new Profesores();
        $form = $this->createForm(ProfesoresType::class, $profesore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profesore);
            $entityManager->flush();

            return $this->redirectToRoute('profesores_index');
        }

        return $this->render('profesores/new.html.twig', [
            'profesore' => $profesore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profesores_show", methods={"GET"})
     */
    public function show(Profesores $profesore): Response
    {
        return $this->render('profesores/show.html.twig', [
            'profesore' => $profesore,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profesores_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profesores $profesore): Response
    {
        $form = $this->createForm(ProfesoresType::class, $profesore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profesores_index');
        }

        return $this->render('profesores/edit.html.twig', [
            'profesore' => $profesore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profesores_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Profesores $profesore): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profesore->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profesore);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profesores_index');
    }
}
