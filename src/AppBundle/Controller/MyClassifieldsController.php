<?php
/**
 * Created by PhpStorm.
 * User: kamilbereda
 * Date: 11.07.2018
 * Time: 13:13
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Classifields;
use AppBundle\Form\ClassifieldsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MyClassifieldsController extends Controller
{
    /**
     * @Route("/moje_aktywne_ogloszenia/", name="myClassifieldsActive")
     *
     * @param Request $request
     * @return Response
     */
    public function myClassifieldsActiveAction(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findBy(['owner' => $this->getUser(), 'status' => Classifields::STATUS_ACTIVE]);

        return $this->render("MyClassifields/myActiveClassifields.html.twig",
            ["classifields" => $classifields]);
    }

    /**
     * @Route("/moje/zakonczone_ogloszenia", name="myClassifieldsFinished")
     *
     * @param Request $request
     * @return Response
     */
    public function myClassifieldsFinishedAction(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findBy(['owner' => $this->getUser(), 'status' => Classifields::STATUS_FINISHED]);

        return $this->render("MyClassifields/myFinishedClassifields.html.twig", ["classifields" => $classifields]);
    }


    /**
     * @Route("/moje/szczegoly_ogloszenia/{id}", name="myClassifieldsDetails")
     *
     * @param Classifields $classifields
     * @return Response
     */
    public function myClassifieldsDetailsAction(Classifields $classifields)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("myClassifieldsDelete", ["id" => $classifields->getId()]))
            ->setMethod(Request::METHOD_DELETE)
            ->add("submit", SubmitType::class, ["label" => "Usuń"])
            ->getForm();

        $finishForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("myClassifieldsFinish", ["id" => $classifields->getId()]))
            ->add("submit", SubmitType::class, ["label" => "Zakończ ogłoszenie"])
            ->getForm();

        return $this->render("MyClassifields/myDetails.html.twig", [
            "classifields" => $classifields,
            "deleteForm" => $deleteForm->createView(),
            "finishForm" => $finishForm->createView()
        ]);
    }

    /**
     * @Route("/moje/edycja/{id}", name="myClassifieldsEdit")
     *
     * @param Request $request
     * @param Classifields $classifields
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function myClassifieldsEditAction(Request $request, Classifields $classifields)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $classifields->getOwner()){
            throw new AccessDeniedException();
        }

        $form = $this->createForm(ClassifieldsType::class, $classifields);

        if($request->isMethod("post")) {
            $form->handleRequest($request);

            $classifields->setStatus(Classifields::STATUS_ACTIVE);
            /*$classifields->setImage(
                new File($this->getParameter("image_directory")."/".$classifields->getImage())
            );*/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classifields);
            $entityManager->flush();

            return $this->redirectToRoute("myClassifieldsActive", ["id" => $classifields->getId()]);
        }
        return $this->render("MyClassifields/myEdit.html.twig", ["form" => $form->createView()]);
    }


    /**
     * @Route("/moje/zakoncz_ogloszenie/{id}", name="myClassifieldsFinish", methods={"POST"})
     *
     * @param Classifields $classifields
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function myClassifieldsFinishAction(Classifields $classifields)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $classifields->getOwner()){
            throw new AccessDeniedException();
        }

        $classifields
            ->setExpiresAt(new \DateTime())
            ->setStatus(Classifields::STATUS_FINISHED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($classifields);
        $entityManager->flush();

        $this->addFlash("success", "Ogłoszenie {$classifields->getTitle()} została zakończona.");

        return $this->redirectToRoute("myClassifieldsActive", ["id" => $classifields->getId()]);
    }

    /**
     * @Route("/moje/usun_ogloszenie/{id}", name="myClassifieldsDelete", methods={"DELETE"})
     *
     * @param Classifields $classifields
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function myClassifieldsDeleteAction(Classifields $classifields)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        if($this->getUser() !== $classifields->getOwner()){
            throw new AccessDeniedException();
        }
        $classifields->setStatus(Classifields::STATUS_CANCELLED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($classifields);
        $entityManager->flush();

        return $this->redirectToRoute("myClassifieldsActive");
    }
}