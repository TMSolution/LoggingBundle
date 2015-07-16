<?php

namespace TMSolution\LoggingBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;

class LogEvents implements EventSubscriberInterface {
    
    public function __construct($container) {
        $this->container = $container;
    }
    
    public static function getSubscribedEvents() {
        return array(
            SecurityEvents::SWITCH_USER => 'onSecuritySwitchUser',
        );
    }

    public function onSecuritySwitchUser(SwitchUserEvent $event) {
        $request = $event->getRequest();
        $requestSwitch = $request->query->get('_switch_user');
        $currentUser = $this->container->get('security.context')->getToken()->getUser();
        $logManager = $this->container->get('TMSolution.Logging.LogManager');
        $logger = $logManager->getLogger('app');
        $logger->info("Przelogowanie : {$currentUser->getUsername()} na {$requestSwitch}",
            [
                "extended" => "{$currentUser->getUsername()} o id {$currentUser->getId()} zalogował się na {$requestSwitch}",
            ]);
    }

}
