<?php

namespace Webshop;

use Exception;

/**
 * User
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class User extends Entity
{
  private $userName;
  private $passwordHash;
  private $type;

  public function __construct(int $id, string $userName, string $passwordHash, string $type)
  {
    parent::__construct($id);
    $this->userName = $userName;
    $this->passwordHash = $passwordHash;

    if (UserType::isValidName($type) == false){
      throw new Exception("UserType not existing " + $type);
    }

    $this->type = $type;
  }

  public function getUserName(): string
  {
    return $this->userName;
  }

  public function getPasswordHash(): string
  {
    return $this->passwordHash;
  }

  public function getTypeString(): string
  {
    return $this->type;
  }

  public function isTypeOf(string $type) : bool {
    if ($this->type == $type){
      return true;
    }
    
    return false;
  }


}
