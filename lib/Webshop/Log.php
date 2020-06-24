<?php

namespace Webshop;

use DateTime;

/**
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class Log extends Entity
{
    private $action;
    private $ipAddress;
    private $timeStamp;
    private $userName;

    /**
     * getter for the private parameter $name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __construct(int $id, string $action, string $ipAddress, DateTime $timeStamp, string $userName)
    {
        parent::__construct($id);
        $this->action = $action;
        $this->ipAddress = $ipAddress;
        $this->timeStamp = $timeStamp;
        $this->userName = $userName;
    }
}
