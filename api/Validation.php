<?php

require_once 'Error.php';

class Validation
{
    private $error = [];

    public function getConfirmCheck($password, $repeatPassword)
        {
            $comparePassword = $this->checkComparePassword($password, $repeatPassword);
            $lengthPassword = $this->checkLengthPassword($password);
            $pattern = $this->validationPassword($password);

            if(is_array($comparePassword) || is_array($lengthPassword) || is_array($pattern)) {
                $this->error[] = $comparePassword;
                $this->error[] = $lengthPassword;
                $this->error[] = $pattern;

                return false;
            }

            return true;
        }

    public function getError()
    {
        return $this->error;
    }

    private function validationPassword($password)
    {
        $patterns = [
            'numeric' => '/[0-9]/',
            'special' => '/[!@#$%^&*]/',
            'latin_lower' => '/[a-z]/',
            'latin_upper' => '/[A-Z]/'
        ];

        if (count($this->checkByPattern($patterns, $password)) == 0) {
            return true;
        }

        return ERROR['05'];
    }

    private function checkByPattern($patterns, $password)
    {
        $rules = [];
        foreach ($patterns as $pattern) {
            $found = preg_match($pattern, $password);

            if($found == 0) {
                array_push($rules, $found);
            }
        }
        return $rules;
    }

    private function checkComparePassword($password, $repeatPassword)
    {
        if($password == $repeatPassword) {
            return true;
        } else {
            return ERROR['03'];
        }
    }

    private function checkLengthPassword($password)
    {
        if(strlen($password) > 8) {
            return true;
        } else {
            return ERROR['04'];
        }
    }
}