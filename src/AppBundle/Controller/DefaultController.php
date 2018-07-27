<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Classifields;
use AppBundle\Form\ClassifieldsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/sprzedam", name="sell")
     *
     * @param Request $request
     * @return Response
     */
    public function sellAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findBy(['indicator' => Classifields::CATEGORY_SELL, "status" => Classifields::STATUS_ACTIVE]);

        return $this->render("default/sell.html.twig", ["classifields" => $classifields]);
    }

    /**
     * @Route("/kupie", name="buy")
     *
     * @param Request $request
     * @return Response
     */
    public function buyAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findBy(['indicator' => Classifields::CATEGORY_BUY, "status" => Classifields::STATUS_ACTIVE]);

        return $this->render("default/buy.html.twig", ["classifields" => $classifields]);
    }

    /**
     * @Route("/zamienie", name="change")
     *
     * @param Request $request
     * @return Response
     */
    public function changeAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findBy(['indicator' => Classifields::CATEGORY_CHANGE, "status" => Classifields::STATUS_ACTIVE]);


        return $this->render("default/change.html.twig", ["classifields" => $classifields]);
    }

    /**
     * @Route("/szczegoly_ogloszenia/{id}", name="details")
     *
     * @param $id
     * @return Response
     */
    public function detailsAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $classifields = $entityManager
            ->getRepository(Classifields::class)
            ->findOneBy(['id' => $id]);

        return $this->render("default/details.html.twig", ["classifields" => $classifields]);
    }

    /**
     * @Route("/dodaj_ogloszenie", name="addClassifield")
     * @param Request $request
     * @return Response
     */
    public function addClassifieldAction(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $classifields = new Classifields();

        $form = $this->createForm(ClassifieldsType::class, $classifields);

        if($request->isMethod("post")) {
            $form->handleRequest($request);


            if($form->isValid())
            {
                $classifields
                    ->setStatus(Classifields::STATUS_ACTIVE)
                    ->setOwner($this->getUser());

                if($classifields->getImage() !== null) {
                    /**
                     * @var UploadedFile $file
                     */
                    $file = $classifields->getImage();
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('image_directory'), $fileName
                    );

                    $classifields->setImage($fileName);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($classifields);
                $entityManager->flush();

                return $this->redirectToRoute("homepage");
            }
        }

        return $this->render("default/addClassifield.twig", ["form" => $form->createView()]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
