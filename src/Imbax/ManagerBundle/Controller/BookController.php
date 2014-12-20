<?php

namespace Imbax\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imbax\ManagerBundle\Entity\Book;
use Imbax\ManagerBundle\Form\BookType;

class BookController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('ImbaxManagerBundle:Book')->findAll();
        return $this->render('ImbaxManagerBundle:Book:index.html.twig', [
            'books' => $books
        ]);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('ImbaxManagerBundle:Book')->find($id);

        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete Book'])
            ->getForm();

        return $this->render('ImbaxManagerBundle:Book:show.html.twig', [
            'book' => $book,
            'delete_form' => $delete_form->createView()
        ]);
    }

    public function newAction()
    {
        $book = new Book();

        $form = $this->createForm(new BookType(), $book,
            [
                'action' => $this->generateUrl('book_create'),
                'method' => 'POST'
            ])
            ->add('submit', 'submit', ['label' => 'Create Book']);

        return $this->render('ImbaxManagerBundle:Book:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function createAction(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(new BookType(), $book,
            [
                'action' => $this->generateUrl('book_create'),
                'method' => 'POST'
            ])
            ->add('submit', 'submit', ['label' => 'Create Book'])
            ->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->get('session')->getFlashBag()->add('msg', 'Your book has been created!');

            return $this->redirect($this->generateUrl('book_show', ['id' => $book->getId()]));
        }

        $this->get('session')->getFlashBag()->add('msg', 'Something went wrong!');

        return $this->render('ImbaxManagerBundle:Book:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('ImbaxManagerBundle:Book')->find($id);

        $form = $this->createForm(new BookType(), $book,
            [
                'action' => $this->generateUrl('book_update', ['id' => $id]),
                'method' => 'POST'
            ])
            ->add('submit', 'submit', ['label' => 'Update Book']);

        return $this->render('ImbaxManagerBundle:Book:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('ImbaxManagerBundle:Book')->find($id);

        $form = $this->createForm(new BookType(), $book,
            [
                'action' => $this->generateUrl('book_create'),
                'method' => 'POST'
            ])
            ->add('submit', 'submit', ['label' => 'Update Book'])
            ->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('msg', 'Your book has been updated!');
            return $this->redirect($this->generateUrl('book_show', ['id' => $id]));
        }

        return $this->render('ImbaxManagerBundle:Book:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteAction(Request $request, $id)
    {
        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete Book'])
            ->getForm()->handleRequest($request);

        if($delete_form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $book = $em->getRepository('ImbaxManagerBundle:Book')->find($id);
            $em->remove($book);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('msg', 'Your book has been deleted!');

        return $this->redirect($this->generateUrl('book'));
    }
}
