<?php

namespace BookwormBundle\Controller;

use BookwormBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

/**
 * Book controller.
 *
 * @Route("api/book")
 */
class BookController extends Controller
{
    /**
     * Lists all book entities.
     *
     * @Route("", name="api_book_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $serializer = $this->get('serializer');

        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('BookwormBundle:Book')->findAll();

        return new JsonResponse([
            'books' => json_decode($serializer->serialize($books, 'json'), true),
        ], 200);
    }

    /**
     * Creates a new book entity.
     *
     * @Route("", name="api_book_new")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function newAction(Request $request)
    {
        $request = json_decode($request->getContent(), true);
        $request['releaseDate'] = new \DateTime($request['releaseDate']);

        $em   = $this->getDoctrine()->getManager();
        $book = $em->getRepository('BookwormBundle:Book')->findOneByIsbn($request['isbn']);

        if (null !== $book) {
            return new JsonResponse([
                'error' => get_class($book) . ' with this isbn already exists',
            ], 409);
        }

        $book = new Book();
        $book->setReleaseDate($request['releaseDate']);
        $form = $this->createForm('BookwormBundle\Form\BookType', $book);
        $form->submit($request);

        $em->persist($book);
        $em->flush();

        return new JsonResponse([
            'book' => $request,
        ], 201);

    }

    /**
     * Finds and displays a book entity.
     *
     * @Route("/{id}", name="api_book_show")
     * @Method("GET")
     * @param Book $book
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Book $book)
    {
        $serializer = $this->get('serializer');

        return new JsonResponse([
            'author' => json_decode($serializer->serialize($book, 'json'), true),
        ], 200);
    }

    /**
     * Displays a form to edit an existing book entity.
     *
     * @Route("/{id}", name="api_book_edit")
     * @Method({"PUT"})
     * @param Request $request
     * @param Book $book
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Book $book)
    {
        $editForm = $this->createForm('BookwormBundle\Form\BookType', $book);
        $request  = json_decode($request->getContent(), true);
        $editForm->submit($request);

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'book' => $request,
        ], 200);
    }

    /**
     * Deletes a book entity.
     *
     * @Route("/{id}", name="api_book_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Book $book
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Book $book)
    {
        $deleteForm = $this->createDeleteForm($book);
        $request    = json_decode($request->getContent(), true);
        $deleteForm->submit($request);

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        return new JsonResponse([
            'deleted'
        ], 200);

    }

    /**
     * Creates a form to delete a book entity.
     *
     * @param Book $book The book entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Book $book)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('api_book_delete', ['id' => $book->getId()]))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
