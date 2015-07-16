<?php

/**
 * Copyright (c) 2014, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Processor;

use LogicException;    
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * Dodaje do rekordu dziennika bieżący identyfikator użytkownika.
 * 
 * Jeżeli użytkownik anonimowy jego id === null.
 * 
 * Przykład:
 * <code>
 * $logRecord = [
 *      "level" =>,
 *      "$message" => "Hello World",
 *      "chanel" => "TMSolution\\HelloWorldBundle\\HelloWorld"
 * ];
 * $proccessor = new TMSolution\LoggingBundle\Processor\UserProcessor()
 * $newLogRecord = $processor($logRecord);
 * echo $newLogRecord['extra']['userid']; // outputs user id or null
 * </code>
 * 
 * @todo Test jednostkowy TMSolution\LoggingBundle\Processor\UserProcessor
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */
class UserProcessor {

    /**
     * Udostępnia token autoryzacji użytkownika.
     * 
     * @var SecurityInterface 
     */
    private $securityContext;

    /**
     * Nowy procesor, który dodaje id użytkownika.
     * 
     * @param SecurityContextInterface $securityContext Udostępnia token
     * autoryzacji użytkownika
     */
    public function __construct(SecurityContextInterface $securityContext) {

        $this->securityContext = $securityContext;

    }

    /**
     * Dodaje do rekordu dziennika id bieżącego użytkownika.
     * 
     * Jeżeli użytkownik anonimowy id użytkownika === null.
     * 
     * @param array $logRecord Rekord dziennika
     * @return array Przetworzony rekord dziennika
     * @throws LogicException Nie można nadpisać userid
     */
    public function __invoke(array $logRecord) {

        if (isset($logRecord['extra']['userid']) == true) {
            throw new LogicException("Attempt to overwrite 'userid'");
        }
        $logRecord['extra']['userid'] = $this->userId();            
        return $logRecord;

    }

    /**
     * Zwraca identyfikator użytkownika.
     * 
     * @return int Identyfikator użytkownika lub null, jeżeli użytkownik
     * anonimowy
     */
    protected function userId() {

        $token = $this->securityContext->getToken();
        if ($token === null || $token instanceof AnonymousToken) {
            return null;
        }
        return $token->getUser()->getId();

    }

}
