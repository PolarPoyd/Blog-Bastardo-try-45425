<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use LDAP\Result;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{

    /**
     * This controller display all categories
     * 
     * @param CategoriesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */ 

    #[Route('/categories', name: 'categories.index', methods: ['GET'])]
    public function index(CategoriesRepository $repository, PaginatorInterface $paginator,
    Request $request): Response

    
    {
        $categories = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );


        return $this->render('pages/categories/index.html.twig', [
            'category' => $categories
        ]);
    }


    /**
     * This controller dislpay show a form wich display new category
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/categories/nouveau', 'categories.new', methods:['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $manager
    ) : Response {

        $categories = new Categories();
        $form = $this->CreateForm(CategoriesType::class, $categories);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categories = $form->getData();

            $manager->persist($categories);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre catégorie a été créée avec succès!'
            );

           return $this->redirectToRoute('categories.index');
        }

        return $this->render('pages/categories/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller show a form wich display edit a category
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/categories/edition/{id}', 'categories.edit', methods:['GET', 'POST'])]
    public function edit(Categories $categories,
    Request $request,
    EntityManagerInterface $manager) : Response 

    {
        $form = $this->CreateForm(CategoriesType::class, $categories);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categories = $form->getData();

            $manager->persist($categories);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre catégorie a été modifiée avec succès!'
            );

           return $this->redirectToRoute('categories.index');
        }


        return $this->render('pages/categories/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/categories/suppression/{id}', 'categories.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Categories $categories) : Response
    {
        if (!$categories) {

        $this->addFlash(
            'danger',
            'La catégorie en question n\'a pas été trouvée!'
        );    
        return $this->redirectToRoute('categories.index');
            
        }

        $manager->remove($categories);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre catégorie a été supprimée avec succès!'
        );

        return $this->redirectToRoute('categories.index');
        
    }
}
