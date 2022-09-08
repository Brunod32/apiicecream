<?php

namespace App\Controller;

use App\Entity\IceCream;
use App\Form\IceCreamType;
use App\Repository\IceCreamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/icecream')]
class IceCreamController extends AbstractController
{
    #[Route('/', name: 'app_ice_cream_index', methods: ['GET'])]
    public function index(IceCreamRepository $iceCreamRepository): Response
    {
        return $this->render('ice_cream/index.html.twig', [
            'ice_creams' => $iceCreamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ice_cream_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IceCreamRepository $iceCreamRepository): Response
    {
        $iceCream = new IceCream();
        $form = $this->createForm(IceCreamType::class, $iceCream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $iceCreamRepository->add($iceCream, true);

            return $this->redirectToRoute('app_ice_cream_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ice_cream/new.html.twig', [
            'ice_cream' => $iceCream,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ice_cream_show', methods: ['GET'])]
    public function show(IceCream $iceCream): Response
    {
        return $this->render('ice_cream/show.html.twig', [
            'ice_cream' => $iceCream,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ice_cream_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IceCream $iceCream, IceCreamRepository $iceCreamRepository): Response
    {
        $form = $this->createForm(IceCreamType::class, $iceCream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $iceCreamRepository->add($iceCream, true);

            return $this->redirectToRoute('app_ice_cream_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ice_cream/edit.html.twig', [
            'ice_cream' => $iceCream,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ice_cream_delete', methods: ['POST'])]
    public function delete(Request $request, IceCream $iceCream, IceCreamRepository $iceCreamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$iceCream->getId(), $request->request->get('_token'))) {
            $iceCreamRepository->remove($iceCream, true);
        }

        return $this->redirectToRoute('app_ice_cream_index', [], Response::HTTP_SEE_OTHER);
    }
}
