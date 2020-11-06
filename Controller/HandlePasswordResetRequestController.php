<?php

namespace inem0o\UserPasswordLostBundle\Controller;

use inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest;
use inem0o\UserPasswordLostBundle\Entity\PasswordResetRequestIdentity;
use inem0o\UserPasswordLostBundle\Event\PasswordResetRequestSuccessfulEvent;
use inem0o\UserPasswordLostBundle\Form\NewPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class HandlePasswordResetRequestController extends AbstractController
{

    public function indexAction(Request $request, UserPasswordEncoderInterface $encoder, EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator, $token)
    {
        $user_repo_name            = $this->getParameter("user_password_lost.user_repo_name");
        $user_email_column_name    = $this->getParameter("user_password_lost.user_email_column_name");
        $route_to_redirect_fail    = $this->getParameter("user_password_lost.route_to_redirect_on_failure");
        $route_to_redirect_success = $this->getParameter("user_password_lost.route_to_redirect_on_success");

        $doctrine = $this->getDoctrine();
        $manager  = $doctrine->getManager();

        // check reset request
        $reset_request_repo = $doctrine->getRepository("UserPasswordLostBundle:PasswordResetRequest");
        $reset_request      = $reset_request_repo->findOneBy(
            [
                'token'  => $token,
                'status' => PasswordResetRequest::STATUS_PENDING,
            ]
        );
        if (null == $reset_request) {
            return $this->redirectToRoute($route_to_redirect_fail);
        }

        // check user from reset request
        $user_repo = $doctrine->getRepository($user_repo_name);
        $user      = $user_repo->findOneBy([$user_email_column_name => $reset_request->getUserEmail()]);
        if (null == $user) {
            return $this->redirectToRoute($route_to_redirect_fail);
        }

        // handle update password form
        $form_new_password = $this->createForm(NewPasswordType::class);
        $form_new_password->handleRequest($request);
        if ($form_new_password->isSubmitted() && $form_new_password->isValid()) {
            $new_password = $form_new_password->getData()['plainPassword'];

            $user->setPassword($encoder->encodePassword($user, $new_password));

            $reset_request->setStatus(PasswordResetRequest::STATUS_USED);
            $reset_request->setDateEnd(new \DateTime("now"));

            $identity = PasswordResetRequestIdentity::factoryFromRequest($request);

            $identity->setRequestStatus($reset_request->getStatus());
            $identity->setPasswordResetRequest($reset_request);

            $manager->persist($identity);

            $manager->persist($reset_request);
            $manager->persist($user);
            $manager->flush();

            $eventDispatcher->dispatch(new PasswordResetRequestSuccessfulEvent($user));

            if ($this->getParameter('user_password_lost.display_success_flashbag')) {
                $request->getSession()->getFlashBag()->add('success', $translator->trans('user_password_lost_bundle.flashbag.success', [], 'userPasswordLostBundle'));
            }

            return $this->redirectToRoute($route_to_redirect_success);
        }

        return $this->render(
            '@UserPasswordLost/handle_password_reset_request/index.html.twig',
            [
                'reset_request'     => $reset_request,
                'form_new_password' => $form_new_password->createView(),
            ]
        );
    }
}
