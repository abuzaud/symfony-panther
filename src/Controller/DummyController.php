<?php
/**
 * Created by Antoine Buzaud.
 * Date: 25/07/2018
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class DummyController
 * @package App\Controller
 */
class DummyController extends Controller
{

    /**
     * @Route("/dummy", name="dummy")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'constraints' => [new Email()]
            ])
            ->add('name', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Message envoyé');
        }

        return $this->render('dummy/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}