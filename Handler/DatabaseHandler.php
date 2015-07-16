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
use Monolog\Handler\AbstractProcessingHandler;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use RuntimeException;

/**
 * Publikuje rekord dziennika do tabeli 'logging_logrecord' w bazie
 * danych aplikacji 'Owca'.
 * 
 * @todo Test jednostkowy TMSolution\LoggingBundle\Handler\DatabaseHandler
 * @author Krzysztof Piasecki <krzysiekpiasecki@gmail.com>
 */    
class DatabaseHandler extends AbstractProcessingHandler {

    /**
     * Nazwa tabeli, w której umieszczane będą wpisy do dziennika.
     * 
     * @var string
     */
    const TABLE_NAME = "logging_logrecord";

    /**
     * Połączenie z bazą danych aplikacji.
     * 
     * @var Doctrine\DBAL\Connection
     */
    protected $connection = null;

    /**
     * Nowy wydawca dziennika.
     * 
     * Publikuje rekordy do bazy danych aplikacji OWCA.
     * 
     * @param Container Kontener zależności
     * @param int $level Minimalny poziom logowania
     * @param boolean $bubble true, jeżeli dopuszcza bąbelkowanie logowania;
     * inaczej false
     * @throws ServiceNotFoundException Brak usługi 'doctrine'
     */
    public function __construct(Container $container,
            $logLevel = Logger::DEBUG, $bubble = true) {

        parent::__construct($logLevel, $bubble);
        $doctrine = $container->get('doctrine');
        $this->connection = $doctrine->getManager()->getConnection();

    }

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
        $record['user_id'] = $logRecord['extra']['userid'];
        $record['channel'] = $logRecord['channel'];            
        $record['level'] = $logRecord['level'];
        $record['level_name'] = $logRecord['level_name'];
        $record['message'] = $logRecord['formatted'];
        $record['viewed'] = 1;
        $record['extended_message'] = $logRecord['extra']['extended'];
        $record['created'] = $logRecord['datetime']->format('Y-m-d H:i:s');
        $insertResult = $this->connection->insert(self::TABLE_NAME, $record);
        if ($insertResult != 1) {
            throw new RuntimeException('Handling log record failed');
        }

    }

}
