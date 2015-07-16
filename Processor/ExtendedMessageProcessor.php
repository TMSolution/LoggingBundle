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

/**
 * Dodaje do rekordu dziennika rozszerzoną wiadomość.
 *  
 * @todo Opis TMSolution\LoggingBundle\Processor\ExtendedMessageProcessor
 * @todo Test jednostkowy TMSolution\LoggingBundle\Processor\ExtendedMessageProcessor
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */
class ExtendedMessageProcessor {

    /**
     * Dodaje do rekordu dziennika krótką wiadomość.
     * 
     * Dodaje do rekordu pole: ['extra']['extended'].
     * 
     * @param array $logRecord
     */
    public function __invoke(array $logRecord) {

        if (isset($logRecord['extra']['extended']) == true) {
            throw new LogicException("Attempt to overwrite 'extended'");
        }            
        $extendedMessage = "";
        if (isset($logRecord['context']['extended']) == true) {
            $extendedMessage = $logRecord['context']['extended'];
            unset($logRecord['context']['extended']);
        }
        $logRecord['extra']['extended'] = $extendedMessage;         
        return $logRecord;

    }

}
