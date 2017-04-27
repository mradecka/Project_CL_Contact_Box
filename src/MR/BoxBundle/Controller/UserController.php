<?php

namespace MR\BoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use MR\BoxBundle\Entity\User;
use MR\BoxBundle\Repository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller {

    public function createUserForm($user = false) {
        if (!$user) {

            $user = new User();
        }
        $form = $this->createFormBuilder($user)
                ->add('name', 'text', ['label' => 'Imię:'])
                ->add('surname', 'text', ['label' => 'Nazwisko:'])
                ->add('description', 'text', ['label' => 'Opis:'])
                ->add('new', 'submit', ['label' => 'Zapisz'])
                ->getForm();
        return $form;
    }

    /**
     * @Route("/new", name="newUser")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $req) {
        if ($this->getRequest()->isMethod('GET')) {
            $form = $this->createUserForm();
            return $this->render('MRBoxBundle:User:new.html.twig', [
                        'form' => $form->createView(),
                        'info' => '']);
        }

        if ($this->getRequest()->isMethod('POST')) {
            $form = $this->createUserForm();
            $form->handleRequest($req);
            if ($form->isSubmitted()) {

                $user = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->render('MRBoxBundle:User:new.html.twig', [
                            'form' => '',
                            'info' => 'Nowy kontakt został dodany.']);
            }
        }
    }

    /**
     * @Route("/{id}/modify", name="modifyUser")
     * @Method({"GET", "POST"})
     * @Template("MRBoxBundle:User:new.html.twig")
     */
    public function modifyAction(Request $req, $id) {

        if ($this->getRequest()->isMethod('GET')) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MRBoxBundle:User');
            $user = $repository->find($id);
            if (!$user) {
                return $this->render('MRBoxBundle:User:modify.html.twig', [
                            'form' => '',
                            'info' => 'Kontakt o id: ' . $id . ' nie istnieje w bazie.']);
            }
            $form = $this->createUserForm();
            return $this->render('MRBoxBundle:User:modify.html.twig', [
                        'form' => $form->createView(),
                        'info' => '']);
        }

        if ($this->getRequest()->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('MRBoxBundle:User');
            $user = $repository->find($id);
            $form = $this->createUserForm($user);
            $form->handleRequest($req);
            if ($form->isSubmitted()) {
                $user = $form->getData();
                $em->persist($user);
                $em->flush();
                return $this->render('MRBoxBundle:User:modify.html.twig', [
                            'form' => '',
                            'info' => 'Kontakt został zaktualizowany']);
            }
        }
    }

    /**
     * @Route("/{id}/delete", name="deleteUser")
     * @Template("MRBoxBundle:User:delete.html.twig")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:User');
        $user = $repository->find($id);
        if ($user) {
            $em->remove($user);
            $em->flush();
            return ['info' => 'Kontakt został usunięty'];
        } else {
            return ['info' => 'Kontakt o id: ' . $id . ' nie istnieje w bazie'];
        }
    }

    /**
     * @Route("/{id}", name="showOneUser")
     * @Template("MRBoxBundle:User:show.html.twig")
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:User');
        $user = $repository->find($id);
        if ($user) {
            return [
                'user' => $user,
                'info' => ''
            ];
        } else {
            return
                    [
                        'user' => '',
                        'info' => 'Kontakt o id: ' . $id . ' nie istnieje w bazie'
            ];
        }
    }

    /**
     * @Route("/", name="showAll")
     * @Template("MRBoxBundle:User:show_all.html.twig")
     */
    public function showAllAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MRBoxBundle:User');
        $users = $repository->orderByName($em);
        if ($users) {
            return [
                'users' => $users,
                'info' => ''
            ];
        } else {
            return
                    [
                        'users' => '',
                        'info' => 'Baza nie zawiera kontaktów'
            ];
        }
    }

}
