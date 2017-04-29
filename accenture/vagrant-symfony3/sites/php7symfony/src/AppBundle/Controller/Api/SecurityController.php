<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as REST;

class SecurityController extends FOSRestController
{
    /**
     * @REST\Post()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \RuntimeException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getTokenAction(Request $request): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        /** @var \AppBundle\Entity\User $user */
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneBy(['username' => $username]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $isValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        if (!$isValid) {
            throw $this->createNotFoundException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        return new JsonResponse(['token' => $token]);
    }
}
