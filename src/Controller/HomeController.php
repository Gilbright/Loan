<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param PinRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PinRepository $repository)
    {
        $loan = $repository->findBy([],array('id' => 'DESC'));

        return $this->render('home/index.html.twig',compact('loan'));
    }

    /**
     * @Route ("/create_pin",name="create_pin", methods={"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request )
    {
        $pin = new Pin();

        $form = $this->createForm(PinType::class,$pin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($pin);

            $em->flush();

            $this->addFlash('success', 'Pin Successfully created!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("pin/{id<[0-9]+>}" ,name="app_show")
     * @param Pin $pin
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws EntityNotFoundException
     */
    public function show(Pin $pin)
    {
        if ($pin === null)
        {
            throw new EntityNotFoundException();
        }

        return $this->render('home/show.html.twig',compact('pin'));
    }

    /**
     * @Route ("/delete/pin/{id<[0-9]+>}" ,name="app_delete", methods={"DELETE"})
     * @param Pin $pin
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Pin $pin,Request $request)
    {
       $submittedToken = $request->request->get('token');

       if ($this->isCsrfTokenValid('pin_deletion_'.$pin->getId(),$submittedToken))
       {
           $em = $this->getDoctrine()->getManager();
           $em->remove($pin);
           $em->flush();
           $this->addFlash('info', 'Pin Successfully deleted!');
       }

       return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/pin/{id<[0-9]+>}/edit", name="app_edit",methods={"GET" , "PUT"})
     * @param Pin $pin
     */
    public function edit(Pin $pin,Request $request)
    {
        $form = $this->createForm(PinType::class, $pin,[
            'method'=> 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!strpos($pin->getDescription(), '(edited)'))
            {
                $pin->setDescription($pin->getDescription() . " (edited)");
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }

            $this->addFlash('success', 'Pin Successfully updated!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/edit.html.twig', [
            'pin' => $pin,
            'form' => $form->createView(),
        ]);
    }
}

