<?php

/**
 * Copyright (c) 2014, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Logger;

use InvalidArgumentException;
use Monolog\Logger as MonologLogger;

/**
 * Dziennik operacji na encjach.
 * 
 * Dziennik jest wykorzystywany przez listenery ORM. Nie sprawdzamy
 * więc typu obiektu; obiekt jest encją i ma metodę 'getId'.
 * 
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */
class EntityLogger extends MonologLogger
{

    const CREATE_OPERATION_NAME = "CREATE";
    const READ_OPERATION_NAME = "READ";
    const UPDATE_OPERATION_NAME = "UPDATE";
    const DELETE_OPERATION_NAME = "DELETE";
    const PRINT_OPERATION_NAME = "PRINT";
    const SEND_OPERATION_NAME = "SEND";

    public function addCreateOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {
        $context = array_merge($context, ["entity_operation_name" => self::CREATE_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addReadOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {

        $context = array_merge($context, ["entity_operation_name" => self::READ_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addUpdateOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {

        $context = array_merge($context, ["entity_operation_name" => self::UPDATE_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addPrintOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {

        $context = array_merge($context, ["entity_operation_name" => self::PRINT_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addSendOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {

        $context = array_merge($context, ["entity_operation_name" => self::SEND_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addDeleteOperation($entityObject, $message = "", array $context = [], $level = self::INFO)
    {

        $context = array_merge($context, ["entity_operation_name" => self::DELETE_OPERATION_NAME]);
        return $this->addOperation(
                        $entityObject, $message, $context, $level);
    }

    public function addUpdateAllOperation(array $entities, $message = "", array $context = [], $level = self::INFO)
    {

        foreach ($entities as $entity) {
            $this->addUpdateOperation($entity, $message, $context, $level = self::INFO);
        }
    }

    public function addCustomInfoOperation($entity, $message)
    {
        $context = ["entity_operation_name" => self::READ_OPERATION_NAME];
        return $this->addOperation(
                        $entity, $message, $context, self::INFO);
    }

    public function addCustomErrorOperation($entity, $message)
    {
        $context = ["entity_operation_name" => self::READ_OPERATION_NAME];
        return $this->addOperation(
                        $entity, $message, $context, self::ERROR);
    }

    protected function addOperation($entityObject, $message = "", array $context = [], $level)
    {

        if (is_string($message) == false) {
            throw new InvalidArgumentException("Not a string");
        }
        $newContext = [
            "entity_class_name" => get_class($entityObject),
            "entity_instance_id" => $entityObject->getId(),
            "entity_operation_name" => $context['entity_operation_name'],
        ];
        $context = array_merge($context, $newContext);
        return $this->addRecord($level, $message, $context);
    }

}
