<?php
/**
 * Copyright (c) 2013, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle;

use Monolog\Registry as MonologRegistry;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use LogicException;

/**
 * Menadżer dzienników.
 * 
 * @todo Test jednostkowy TMSolution\LoggingBundle\LogManager
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */    
class LogManager {

    /**
     * Rejestruje nowy dziennik.
     * 
     * @param \Psr\Log\LoggerInterface $logger Dziennik
     * @throws InvalidArgumentException Nie można ponownie zapisać tego
     * samego dziennika
     */
    public function addLogger(LoggerInterface $logger) {

        MonologRegistry::addLogger($logger);

    }

    /**
     * Zwraca zarejestrowany dziennik.
     * 
     * @param string $name Nazwa wybranego dziennika
     * @return LoggerInterface Dziennik
     * @throws InvalidArgumentException func_num_args() == 0
     * @throws InvalidArgumentException Dziennik nie zarejestrowany
     * @throws LogicException Niepoprawna nazwa dziennika
     */
    public function getLogger($name) {

        if (func_num_args() == 0) {
            throw new InvalidArgumentException("No arguments");
        }
        if (is_string($name) == false || $name == "") {
            throw new LogicException("Invalid or empty logger name");
        }
        return MonologRegistry::getInstance($name);

    }

}
