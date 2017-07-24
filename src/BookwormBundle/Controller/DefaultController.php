<?php

namespace BookwormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
