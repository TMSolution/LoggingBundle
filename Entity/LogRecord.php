<?php

namespace TMSolution\LoggingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogRecord.
 * 
 * Tylko do odczytu.
 * 
 * @ORM\Table("logging_logrecord")
 * @ORM\Entity(repositoryClass="TMSolution\LoggingBundle\Repository\LogRecordRepository")
 */
class LogRecord {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options= {"comment":"[PODSTAWOWE ELEMENTY SYSTEMU]Tabela zawierająca zapisy historycznych zdarzeń w systemie B2B."})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="TMSolution\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="channel", type="string")
     */
    private $channel;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="level_name", type="string")
     */
    private $levelName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="extended_message", type="text")
     */
    private $extendedMessage;
    
    /**
     * @var string
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $dateTime;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="viewed", type="boolean")
     */
    private $viewed = 0;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime 
     */
    public function getDateTime() {
        return $this->dateTime;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Get chanel
     *
     * @return string 
     */
    public function getChannel() {
        return $this->channel;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Get levelName
     *
     * @return string 
     */
    public function getLevelName() {
        return $this->levelName;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage() {
        return $this->message;
    }
    
    /**
     * Get extended message
     *
     * @return string
     */
    public function getExtendedMessage() {
        return $this->extendedMessage;
    }
    
    /**
     * Get viewed
     *
     * @return bool|null 
     */
    public function getViewed() {
        return $this->viewed;
    } 
    
    /**
     * Set viewed  
     * 
     * @param boolean $viewed
     * @return \TMSolution\LoggingBundle\Entity\LogRecord
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;
        return  $this;
    }

}
