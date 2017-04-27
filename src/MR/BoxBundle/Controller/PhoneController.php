<?php

namespace MR\BoxBundle\Controller;

use MR\BoxBundle\Entity\Phone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Phone controller.
 *
 * @Route("phone")
 */
class PhoneController extends Controller {

    /**
     * Lists all phone entities.
     *
     * @Route("/{id}", name="phone_index")
     * @Method("GET")
     */
    public function indexAction($id) {
        $em = $this->getDoctrine()->getManager();

        $phones = $em->getRepository('MRBoxBundle:Phone')->findByUser($id);

        return $this->render('MRBoxBundle:phone:index.html.twig', array(
                    'phones' => $phones,
                    'id' => $id,
        ));
    }

    /**
     * Creates a new phone entity.
     *
     * @Route("/new/{id}", name="phone_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id) {
        $phone = new Phone();
        $form = $this->createForm('MR\BoxBundle\Form\PhoneType', $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MRBoxBundle:User');
            $user = $repository->find($id);
            $phone->setUser($user);
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute('phone_index', array('id' => $id));
        }

        return $this->render('MRBoxBundle:phone:new.html.twig', array(
                    'phone' => $phone,
                    'form' => $form->createView(),
                    'id' => $id
        ));
    }

    /**
     * Displays a form to edit an existing phone entity.
     *
     * @Route("/{id}/edit", name="phone_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Phone $phone) {
        $editForm = $this->createForm('MR\BoxBundle\Form\PhoneType', $phone);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_index', ['id' => $phone->getUser()->getId()]);
        }

        return $this->render('MRBoxBundle:phone:edit.html.twig', array(
                    'phone' => $phone,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a phone entity.
     *
     * @Route("/{id}/delete", name="phone_delete")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:Phone');
        $phone = $repository->find($id);
        $id = $phone->getUser()->getId();
        $em->remove($phone);
        $em->flush();
        return $this->redirectToRoute('phone_index', ['id' => $id]);
    }

}
