<?php

namespace BookwormBundle\Controller;

use BookwormBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

/**
 * Author controller.
 *
 * @Route("api/author")
 */
class AuthorController extends Controller
{
    /**
     * Lists all author entities.
     *
     * @Route("", name="api_author_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $serializer = $this->get('serializer');

        $em = $this->getDoctrine()->getManager();

        $authors = $em->getRepository('BookwormBundle:Author')->findAll();

        return new JsonResponse([
            'authors' => json_decode($serializer->serialize($authors, 'json'), true),
        ], 200);
    }

    /**
     * Creates a new author entity.
     *
     * @Route("", name="api_author_new")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function newAction(Request $request)
    {
        $author = new Author();
        $form   = $this->createForm('BookwormBundle\Form\AuthorType', $author);
        $request = json_decode($request->getContent(), true);
        $form->bind($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new JsonResponse([
            'author' => $request,
        ], 200);
    }

    /**
     * Finds and displays a author entity.
     *
     * @Route("/{id}", name="api_author_show")
     * @Method("GET")
     * @param Author $author
     *
     * @return JsonResponse
     */
    public function showAction(Author $author)
    {
        $serializer = $this->get('serializer');

        return new JsonResponse([
            'author' => json_decode($serializer->serialize($author, 'json'), true),
        ], 200);
    }

    /**
     * Displays a form to edit an existing author entity.
     *
     * @Route("/{id}", name="api_author_edit")
     * @Method({"PUT"})
     * @param Request $request
     * @param Author $author
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Author $author)
    {
        $editForm   = $this->createForm('BookwormBundle\Form\AuthorType', $author);
        $request = json_decode($request->getContent(), true);
        $editForm->bind($request);

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'author'      => $request,
        ], 200);
    }

    /**
     * Creates a form to delete a author entity.
     *
     * @param Author $author The author entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Author $author)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('api_author_delete', ['id' => $author->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Deletes a author entity.
     *
     * @Route("/{id}", name="api_author_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Author $author
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Author $author)
    {
        $deleteForm = $this->createDeleteForm($author);
        $request = json_decode($request->getContent(), true);
        $deleteForm->bind($request);

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return new JsonResponse(['deleted'], 200);
    }
}
