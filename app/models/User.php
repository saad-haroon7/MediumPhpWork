<?php

class User {
    private $username;
    private $password;
    private $empno;
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmpno()
    {
        return $this->empno;
    }

    /**
     * @param mixed $empno
     */
    public function setEmpno($empno): void
    {
        $this->empno = $empno;
    }

    public function validateUser($username = 'admin'){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select * from phpproject.users where username='$username' AND password='$this->password'");
            $stmt->execute();
            $result = $stmt->rowCount();
            if($result > 0){
                return $stmt->fetch();
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function createAdminAccount(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Insert into phpproject.users (username,password,employee_id) 
                        values ('admin','coeus123',$this->empno)");
            $stmt->execute();
            $result = $stmt->rowCount();
            if($result > 0){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function getRole($empno){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("select r.role from employees e, roles r where e.role_id = r.id and e.id = '$empno'");
            $stmt->execute();
            $result = $stmt->rowCount();
            if($result > 0){
                return $stmt->fetch();
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }
}

?>