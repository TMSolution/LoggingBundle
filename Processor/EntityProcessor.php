<?php

/**
 * Copyright (c) 2013, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Processor;

use LogicException;

/**
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */
class EntityProcessor {

    public function __invoke(array $logRecord) {

        if (isset($logRecord['extra']['entity_class_name']) == true) {
            throw new LogicException(
                    "Attempt to overwrite extra parameters");
        }
        $name = $logRecord['context']['entity_class_name'];
        $id = $logRecord['context']['entity_instance_id'];
        $operation = $logRecord['context']['entity_operation_name'];
        $logRecord['extra']['entity_class_name'] = $name;
        $logRecord['extra']['entity_instance_id'] = $id;
        $logRecord['extra']['entity_operation_name'] = $operation;            
        unset(
            $logRecord['context']['entity_class_name'],
            $logRecord['context']['entity_instance_id'],     
            $logRecord['context']['entity_operation_name']
        );            
        return $logRecord;

    }

}
