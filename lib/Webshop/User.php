<?php

namespace Webshop;

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

  public function __construct(int $id, string $userName, string $passwordHash, UserType $type)
  {
    parent::__construct($id);
    $this->userName = $userName;
    $this->passwordHash = $passwordHash;
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

  public function getUserType(): UserType
  {
    return $this->type;
  }
}
