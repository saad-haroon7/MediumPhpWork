<?php

class Admin extends Controller {
    public function addAdmin($token = ''){
        if ($token == ''){
            echo "Kindly Pass the token";
        }
        elseif($token == 'xp1234567xp'){
            /*Admin is present or not?
             *username check if present in table
             */
            $employee = $this->model('Employee');
            $admin = $this->model('User');
            $isPresent = $admin->validateUser();
            if($isPresent != false){
                echo "Sorry! Admin has already Made";
            }else{
                $empno = $employee->createAdmin();
                if($empno){
                    $admin->setEmpno($empno);
                    $result = $admin->createAdminAccount();
                    if($result){
                        echo "Admin has been created. Kindly go to Login Form";
                    }
                    else{
                        echo "NOT CREATED";
                    }
                }
            }
        }else{
            echo "Invalid Token!";
        }
    }
}
?>