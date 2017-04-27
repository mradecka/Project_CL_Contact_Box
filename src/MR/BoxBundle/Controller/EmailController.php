<?php

namespace MR\BoxBundle\Controller;

use MR\BoxBundle\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Email controller.
 *
 * @Route("email")
 */
class EmailController extends Controller {

    /**
     * Lists all email entities.
     *
     * @Route("/{id}", name="email_index")
     * @Method("GET")
     */
    public function indexAction($id) {
        $em = $this->getDoctrine()->getManager();

        $emails = $em->getRepository('MRBoxBundle:Email')->findByUser($id);
        return $this->render('MRBoxBundle:email:index.html.twig', array(
                    'emails' => $emails,
                    'id' => $id,
        ));
    }

    /**
     * Creates a new email entity.
     *
     * @Route("/new/{id}", name="email_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id) {
        $email = new Email();
        $form = $this->createForm('MR\BoxBundle\Form\EmailType', $email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MRBoxBundle:User');
            $user = $repository->find($id);
            $email->setUser($user);
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute('email_index', array('id' => $id));
        }

        return $this->render('MRBoxBundle:email:new.html.twig', array(
                    'email' => $email,
                    'form' => $form->createView(),
                    'id' => $id
        ));
    }

    /**
     * Displays a form to edit an existing email entity.
     *
     * @Route("/{id}/edit", name="email_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Email $email) {
        $editForm = $this->createForm('MR\BoxBundle\Form\EmailType', $email);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_index', ['id' => $email->getUser()->getId()]);
        }

        return $this->render('MRBoxBundle:email:edit.html.twig', array(
                    'email' => $email,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a email entity.
     *
     * @Route("/{id}/delete", name="email_delete")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:Email');
        $email = $repository->find($id);
        $id = $email->getUser()->getId();
        $em->remove($email);
        $em->flush();

        return $this->redirectToRoute('email_index', ['id' => $id]);
    }

    /**
     * Creates a form to delete a email entity.
     *
     * @param Email $email The email entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Email $email) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('email_delete', array('id' => $email->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
