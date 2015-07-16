<?php

namespace TMSolution\LoggingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityLogRecord.
 * 
 * Tylko do odczytu.
 * 
 * @ORM\Table("logging_entitylogrecord")
 * @ORM\Entity
 */
class EntityLogRecord {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options= {"comment":"[PODSTAWOWE ELEMENTY SYSTEMU]Tabela zawierająca zapisy przeszłych zdarzeń wykonywanych na encjach."})
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
     * @var string
     *
     * @ORM\Column(name="class_name", type="string",  nullable=false)
     */
    private $className;

    /**
     * @var integer
     *
     * @ORM\Column(name="instance_id", type="integer", nullable=false)
     */
    private $instanceId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string",  nullable=false)
     */
    private $operation;    

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

    
    /**
     * Get intanceId
     *
     * @return integer 
     */
    public function getInstanceId() {
        return $this->instanceId;
    }

    /**
     * Get className
     *
     * @return string 
     */
    public function getClassName() {
        return $this->className;
    }
    
   /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation() {
        return $this->operation;
    }    


    /**
     * Set channel
     *
     * @param string $channel
     * @return EntityLogRecord
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return EntityLogRecord
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Set levelName
     *
     * @param string $levelName
     * @return EntityLogRecord
     */
    public function setLevelName($levelName)
    {
        $this->levelName = $levelName;

        return $this;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return EntityLogRecord
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set extendedMessage
     *
     * @param string $extendedMessage
     * @return EntityLogRecord
     */
    public function setExtendedMessage($extendedMessage)
    {
        $this->extendedMessage = $extendedMessage;

        return $this;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     * @return EntityLogRecord
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Set className
     *
     * @param string $className
     * @return EntityLogRecord
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Set instanceId
     *
     * @param integer $instanceId
     * @return EntityLogRecord
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return EntityLogRecord
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Set userId
     *
     * @param \TMSolution\UserBundle\Entity\User $userId
     * @return EntityLogRecord
     */
    public function setUserId(\TMSolution\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }
}
