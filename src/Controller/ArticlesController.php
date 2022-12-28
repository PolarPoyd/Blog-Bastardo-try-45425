<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * This controller display all articles
     *
     * @param ArticlesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/articles', name: 'articles.index', methods:['GET'])]
    public function index(ArticlesRepository $repository,
     PaginatorInterface $paginator, 
     Request $request): Response
    {
        $articles = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * This controller allow us to create new article
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/articles/creation', 'article.new', methods:['POST', 'GET'])]
    public function new (Request $request,
    EntityManagerInterface $manager) : Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a été crée avec succès'
            );

            return $this->redirectToRoute('articles.index');
        }

        return $this->render('pages/articles/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller show a form wich display edit an article
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/articles/edition/{id}', 'article.edit', methods:['GET', 'POST'])]
    public function edit(Articles $article,
    Request $request,
    EntityManagerInterface $manager) : Response 

    {
        $form = $this->CreateForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre article a été modifié avec succès!'
            );

           return $this->redirectToRoute('articles.index');
        }


        return $this->render('pages/articles/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    
    /**
     * This controller show how to delete a article
     *
     * @param EntityManagerInterface $manager
     * @param Articles $article
     * @return Response
     */
    #[Route('/articles/suppression/{id}', 'article.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager,
     Articles $article) : Response
    {
        if (!$article) {

        $this->addFlash(
            'danger',
            'L\'article en question n\'a pas été trouvé!'
        );    
        return $this->redirectToRoute('articles.index');
            
        }

        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre article a été supprimé avec succès!'
        );

        return $this->redirectToRoute('articles.index');
        
    }
}
