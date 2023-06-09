<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Form\ModulesType;
use App\Repository\ModulesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/modules')]
class ModulesController extends AbstractController
{
    #[Route('/', name: 'modules_index', methods: ['GET'])]
    public function index(ModulesRepository $modulesRepository): Response
    {
        return $this->render('modules/index.html.twig', [
            'modules' => $modulesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'modules_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModulesRepository $modulesRepository): Response
    {
        $module = new Modules();
        $form = $this->createForm(ModulesType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modulesRepository->save($module, true);

            return $this->redirectToRoute('modules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('modules/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'modules_show', methods: ['GET'])]
    public function show(Modules $module): Response
    {
        return $this->render('modules/show.html.twig', [
            'module' => $module,
        ]);
    }

    #[Route('/{id}/edit', name: 'modules_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Modules $module, ModulesRepository $modulesRepository): Response
    {
        $form = $this->createForm(ModulesType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modulesRepository->save($module, true);

            return $this->redirectToRoute('modules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('modules/edit.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'modules_delete', methods: ['POST'])]
    public function delete(Request $request, Modules $module, ModulesRepository $modulesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $modulesRepository->remove($module, true);
        }

        return $this->redirectToRoute('modules_index', [], Response::HTTP_SEE_OTHER);
    }
}
