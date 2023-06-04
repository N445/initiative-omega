<?php

namespace App\Model;

class Contact
{
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var string
     */
    private $message;
    
    /**
     * @var \DateTime
     */
    private $sendAt;
    
    public function __construct()
    {
        $this->sendAt = new \DateTime('now');
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @param string $message
     * @return Contact
     */
    public function setMessage(string $message): Contact
    {
        $this->message = $message;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getSendAt(): \DateTime
    {
        return $this->sendAt;
    }
    
    /**
     * @param \DateTime $sendAt
     * @return Contact
     */
    public function setSendAt(\DateTime $sendAt): Contact
    {
        $this->sendAt = $sendAt;
        return $this;
    }
    
    
}