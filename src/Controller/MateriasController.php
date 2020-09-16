<?php

namespace App\Controller;

use App\Entity\Materias;
use App\Form\MateriasType;
use App\Repository\MateriasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/materias")
 */
class MateriasController extends AbstractController
{
    /**
     * @Route("/", name="materias_index", methods={"GET"})
     */
    public function index(MateriasRepository $materiasRepository): Response
    {
        return $this->render('materias/index.html.twig', [
            'materias' => $materiasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="materias_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $materia = new Materias();
        $form = $this->createForm(MateriasType::class, $materia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materia);
            $entityManager->flush();

            return $this->redirectToRoute('materias_index');
        }

        return $this->render('materias/new.html.twig', [
            'materia' => $materia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="materias_show", methods={"GET"})
     */
    public function show(Materias $materia): Response
    {
        return $this->render('materias/show.html.twig', [
            'materia' => $materia,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="materias_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Materias $materia): Response
    {
        $form = $this->createForm(MateriasType::class, $materia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materias_index');
        }

        return $this->render('materias/edit.html.twig', [
            'materia' => $materia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="materias_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Materias $materia): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materia->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($materia);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materias_index');
    }
}
