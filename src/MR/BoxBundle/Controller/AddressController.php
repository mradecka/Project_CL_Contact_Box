<?php

namespace MR\BoxBundle\Controller;

use MR\BoxBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Address controller.
 *
 * @Route("address")
 */
class AddressController extends Controller {

    /**
     * Lists all address entities.
     *
     * @Route("/{id}", name="address_index")
     * @Method("GET")
     */
    public function indexAction($id) {

        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('MRBoxBundle:Address')->findByUser($id);

        return $this->render('MRBoxBundle:address:index.html.twig', array(
                    'addresses' => $addresses,
                    'id' => $id,
        ));
    }

    /**
     * Creates a new address entity.
     *
     * @Route("/new/{id}", name="address_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id) {
        $address = new Address();
        $form = $this->createForm('MR\BoxBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MRBoxBundle:User');
            $user = $repository->find($id);
            $address->setUser($user);
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('address_index', array('id' => $id));
        }

        return $this->render('MRBoxBundle:address:new.html.twig', array(
                    'address' => $address,
                    'form' => $form->createView(),
                    'id' => $id,
        ));
    }

    /**
     * Displays a form to edit an existing address entity.
     *
     * @Route("/{id}/edit", name="address_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Address $address) {
        $editForm = $this->createForm('MR\BoxBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_index', ['id' => $address->getUser()->getId()]);
        }

        return $this->render('MRBoxBundle:address:edit.html.twig', array(
                    'address' => $address,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a address entity.
     *
     * @Route("/delete/{id}", name="address_delete")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:Address');
        $address = $repository->find($id);
        $id = $address->getUser()->getId();
        $em->remove($address);
        $em->flush();
        return $this->redirectToRoute('address_index', ['id' => $id]);
    }

}
