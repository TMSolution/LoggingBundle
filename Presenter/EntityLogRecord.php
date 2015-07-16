<?php

namespace TMSolution\LoggingBundle\Presenter;

/**
 * Presents single EntityLogRecord.
 */
class EntityLogRecord
{

    protected $entity;
    private static $displayMap = [
        'TMSolution\OwcaBundle\Entity\Calculation' => [
            'CREATE' => 'Kalkulacja oferty ubezpieczeniowej',
            'SEND' => 'Wysłanie kalkulacji oferty ubezpieczeniowej',
            'UPDATE' => 'Aktualizacja kalkulacji ubezpieczeniowej',
            'PRINT' => 'Wydruk kalkulacji ubezpieczeniowej',
            'DELETE' => 'Usunięcie kalkulacji ubezpieczeniowej',
        ],
        'TMSolution\OwcaBundle\Entity\Policy' => [
            'CREATE' => 'Zawarcie polisy ubezpieczeniowej',
            'SEND' => 'Wysłanie polisy ubezpieczeniowej',
            'UPDATE' => 'Aktualizacja polisy ubezpieczeniowej',
            'PRINT' => 'Wydruk polisy ubezpieczeniowej',
        ],
        'TMSolution\OwcaBundle\Entity\PrivateClient' => [
            'CREATE' => 'Dodanie nowego klienta',
            'UPDATE' => 'Aktualizacja danych klienta',
            'PRINT' => 'Wydruk danych klienta',
        ],
        'TMSolution\DocumentBundle\Entity\Item' => [
            'CREATE' => 'Dodanie nowego dokumentu',
            'UPDATE' => 'Aktualizacja dokumentu',
            'PRINT' => 'Wydruk dokumentu',
        ]
    ];

    public function __construct(\TMSolution\LoggingBundle\Entity\EntityLogRecord $entity)
    {
        $this->entity = $entity;
    }

    public function getOperationDate()
    {
        $dateTime = $this->entity->getDateTime();
        if (is_object($dateTime)) {
            return $dateTime->format('d.m.Y H:i:s');
        }

        return NULL;
    }

    public function __toString()
    {
        $className = $this->entity->getClassName();
        $operationName = $this->entity->getOperation();
        $displayValue = '';
        if (isset(self::$displayMap[$className][$operationName]) == true) {
            $displayValue = self::$displayMap[$className][$operationName];
        }
        return ($displayValue == '') ? 'Wykonano operację w systemie' : $displayValue;
    }

}
