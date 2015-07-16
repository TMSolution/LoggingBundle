<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\LoggingBundle\Model;

use Core\BaseBundle\Model\Model;

/**
 * Description of EntityLogRecord
 *
 * @author Łukasz Wawrzyniak <lukasz.wawrzyniak@tmsolution.pl>
 */
class EntityLogRecord extends Model {

    public function getEntityHistoryData($entityName, $instanceId, $logLevel = 200) {
        $data = $this->getRepository()->findBy(
                array("className" => $entityName, 'instanceId' => $instanceId, 'level' => $logLevel), array('id' => 'desc')
        );
        return $data;
    }
    
    
    public function getHistoryData(array $entities, $logLevel = 200){
        $this->getQueryBuilder('c');
    }

}
