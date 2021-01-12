<?php

namespace App\Presentation\Controller;

use App\Domain\Exception\EmptyFileException;
use App\Domain\Exception\OrderAlreadyExistsException;
use App\Domain\Exception\PersonAlreadyExistsException;
use App\Domain\Exception\PersonNotFoundException;
use App\Infrastructure\Handler\UpaloadHandler;
use App\Presentation\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var UpaloadHandler
     */
    private UpaloadHandler $handler;

    /**
     * HomeController constructor.
     *
     * @param UpaloadHandler $handler
     */
    public function __construct(UpaloadHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/", name="home_view", methods={"POST", "GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function home(Request $request): Response
    {
        try {
            $form = $this->createForm(UploadType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->handler->handle($form->getData());

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'File uploaded with success.'
                );
            }

        } catch (EmptyFileException
            | PersonNotFoundException
            | OrderAlreadyExistsException
            | PersonAlreadyExistsException $e
        ) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                $e->getMessage()
            );
        } catch (\Throwable $e) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                'An unexpected error has occurred'
            );
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
