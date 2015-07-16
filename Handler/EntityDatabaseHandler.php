<?php
/**
 * Copyright (c) 2014, TMSolution
 * All rights reserved.
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace TMSolution\LoggingBundle\Handler;
    
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use RuntimeException;

/**
 * Publikuje rekord dziennika do tabeli 'logging_entitylogrecord' w bazie
 * danych aplikacji 'Owca'.
 * 
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */    
class EntityDatabaseHandler extends DatabaseHandler {

    /**
     * Nazwa tabeli, w której umieszczane będą wpisy do dziennika.
     * 
     * @var string
     */
    const TABLE_NAME = "logging_entitylogrecord";

    /**
     * Połączenie z bazą danych aplikacji.
     * 
     * @var Doctrine\DBAL\Connection
     */
    protected $connection = null;


    /**
     * Zapisuje rekord do dziennika.
     * 
     * @todo Użyj QueryBuilder
     * @todo Lokalizacja daty $logRecord['datetime']->format('Y-m-d H:i:s');
     * @param array $logRecord Rekord dziennika
     * @throws RuntimeException Rekord nie został zapisany
     * @throws \Doctrine\DBAL\DBALException Problem z zapisem rekordu
     */
    protected function write(array $logRecord) {

        $record = [];
        $record['id'] = null;
        $record['viewed'] = 0;
        $record['user_id'] = $logRecord['extra']['userid'];
        $record['channel'] = $logRecord['channel'];            
        $record['level'] = $logRecord['level'];
        $record['level_name'] = $logRecord['level_name'];
        $record['message'] = $logRecord['formatted'];   
        $record['extended_message'] = $logRecord['extra']['extended'];
        $record['created'] = $logRecord['datetime']->format('Y-m-d H:i:s');
        $record['class_name'] = $logRecord['extra']['entity_class_name'];   
        $record['instance_id'] = $logRecord['extra']['entity_instance_id'];
        $record['operation'] = $logRecord['extra']['entity_operation_name'];              
        $insertResult = $this->connection->insert(self::TABLE_NAME, $record);
        if ($insertResult != 1) {
            throw new RuntimeException('Handling entity log record failed');
        }

    }

}
