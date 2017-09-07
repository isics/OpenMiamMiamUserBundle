<?php

namespace Isics\Bundle\OpenMiamMiamUserBundle\EventListener;

use Isics\Bundle\OpenMiamMiamUserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileCompletionListener implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param ValidatorInterface    $validator
     * @param Session               $session
     * @param TranslatorInterface   $translator
     * @param RouterInterface       $router
     */
    public function __construct(TokenStorageInterface $tokenStorage,
                                ValidatorInterface $validator,
                                Session $session,
                                TranslatorInterface $translator,
                                RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->validator    = $validator;
        $this->session      = $session;
        $this->translator   = $translator;
        $this->router       = $router;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onRequest'
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        // master request ?
        if (!$event->isMasterRequest()) {
            return;
        }

        // loggedIn user ?
        if (null === $this->tokenStorage->getToken() || !$this->tokenStorage->getToken()->getUser() instanceof User) {
            return;
        }

        // matched route ?
        try {
            $matchedRoute = $this->router->match($event->getRequest()->getPathInfo());
        } catch (\Exception $e) {
            return;
        }

        // white listed route ?
        $whiteList = array(
            'fos_user_profile_edit',
            'fos_user_security_logout'
        );

        if (in_array($matchedRoute['_route'], $whiteList)) {
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $violationsList = $this->validator->validate($user, null, array('Default', 'Registration'));

        if (count($violationsList) > 0) {
            $indexedViolationsList = array();

            foreach ($violationsList as $violation) {
                /** @var ConstraintViolationInterface $violation */
                $indexedViolationsList[$violation->getPropertyPath()] = $violation;
            }

            if (
                isset($indexedViolationsList['address1'])
                || isset($indexedViolationsList['zipCode'])
                || isset($indexedViolationsList['city'])
            ) {
                $this->session->getFlashBag()->add(
                    'warning',
                    $this->translator->trans('turlututu')
                );
            }

            $event->setResponse(new RedirectResponse($this->router->generate('fos_user_profile_edit')));
        }
    }
}
