<?php

namespace BookwormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        return new JsonResponse(date('Y-m-d H:i:s'), 200);
    }

    /**
     * @Route("/api")
     * @Method("GET")
     */
    public function rootAction()
    {
        return new JsonResponse(date('Y-m-d H:i:s'), 200);
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        // Send the modified response object to the event
        $response = new JsonResponse([
            'error' => $exception->getMessage(),
        ], $exception->getStatusCode());

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
