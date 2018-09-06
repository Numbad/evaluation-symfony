<?php
/**
 * Created by PhpStorm.
 * User: qaltamore
 * Date: 03/09/18
 * Time: 17:09
 */

namespace App\model;

class User
{

        private $firstname;

        private $lastname;

        private $email;

        public function  __construct($firstname){
            $this->firstname = $firstname;
        }

        public function getFirstname()
        {
            return $this->firstname;
        }

        public function getLastname()
        {
            return $this->lastname;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setFirstname($firstname){
            $this->firstname = $firstname;
        }

        public function setLastname($lastname){
            $this->lastname = $lastname;
        }

        public function setEmail($email){
            $this->email = $email;
        }


}