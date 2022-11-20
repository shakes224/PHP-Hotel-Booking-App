<?php
//getters and setters within a class
//the first 'getId', gets the value of ID,
//then the second function 'setID', sets the value of ID and returns self
//and this carries on through name, lastname and email. 

class User { //this will take in the information that the user fills in on the first page
    private $name;
    private $lastname;
    private $email;

    public function __construct($name, $lastname, $email) 
    {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
    }

    public function getName(){
        return $this->name;
    } 

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getLastName(){
        return $this->lastname;
    }

    public function setLastName($lastname){
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    
}
?>