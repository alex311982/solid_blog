<?php

namespace Solid\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Solid\BlogBundle\Entity\Post;
use Solid\BlogBundle\Form\PostType;
use Solid\BlogBundle\DBAL\EnumCategoryType;

class DefaultController extends Controller
{
    /**
     * @Method({"GET"})
     * @Template()
     *
     * @param Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function indexAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getManager()
            ->getRepository('SolidBlogBundle:Post')->getQueryForGet();
        $page = $request->query->getInt('page', 1);

        try {
            $pagination = $paginator->paginate(
                $query,
                $page,
                10
            );
        } catch (QueryException $e) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('SolidBlogBundle:Default:index.html.twig',
            array('page' => $page, 'pagination' => $pagination)
        );
    }

    /**
     * @Method({"GET"})
     *
     * @param int $articleId
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return RedirectResponse
     */
    public function removeAction($articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $articleId = (int)$articleId;
        $article = $em->getRepository('SolidBlogBundle:Post')->find($articleId);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$articleId
            );
        }

        $article->setDeletedAt(new \DateTime("now"));
        $em->flush();

        return $this->redirectToRoute('solid_blog_homepage');
    }

    /**
     * @Method({"GET"})
     *
     * @param string $slug
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return array
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getManager()
            ->getRepository('SolidBlogBundle:Post')->getArticleBySlug($slug);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$slug
            );
        }

        return $this->render('SolidBlogBundle:Default:show.html.twig',
            array('article' => $article)
        );
    }

    /**
     * @Method({"GET"})
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createAction(Request $request)
    {
        $data = $request->get('new_article');
        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $post = new Post();
            $form = $this->createForm(new PostType(), $post);

            $em = $this->getDoctrine()->getManager();

            if ($request->getMethod() == 'POST' && $request->get('new_article')) {
                $form->bind($request);
                $createdPost = $em->getRepository('SolidBlogBundle:Post')
                    ->findOneByName($data['name']);
                if ($form->isValid() && empty($createdPost)) {
                    $author = $em->getRepository('SolidBlogBundle:Author')
                        ->find($this->getUser()->getId());
                    $post->setAuthor($author);
                    $categories = EnumCategoryType::$staticValues;
                    $post->setCategory($categories[$data['category']]);
                    $em->persist($post);
                    $em->flush();

                    return $this->render('SolidBlogBundle:Default:newarticle.html.twig', array(
                            'form' => $form->createView(),
                            'message' => 'Article is saved'
                        )
                    );
                } else {
                    return $this->render('SolidBlogBundle:Default:newarticle.html.twig', array(
                            'form' => $form->createView(),
                            'message' => 'Such article is exist'
                        )
                    );
                }
            }
        } else {
            return $this->redirectToRoute('solid_blog_homepage');
        }

        return $this->render('SolidBlogBundle:Default:newarticle.html.twig', array(
                'form' => $form->createView()
            )
        );
    }
}
