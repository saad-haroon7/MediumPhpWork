<?php

class Role {
    private $roleid;
    private $role;

    function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getRoleid()
    {
        return $this->roleid;
    }

    /**
     * @param mixed $roleid
     */
    public function setRoleid($roleid): void
    {
        $this->roleid = $roleid;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function getAllRoles()
    {
        try{
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "maxwell7044";
        $db_name = "phpproject";
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($_SESSION['role'] == 'BOSS'){
            $stmt = $conn->prepare("SELECT * from phpproject.roles WHERE role NOT LIKE 'BOSS'");
        }else{
            $stmt = $conn->prepare("SELECT * from phpproject.roles WHERE role NOT IN ('BOSS','HR Manager')");
        }
        $stmt->execute();
        $rows = $stmt->rowCount();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }catch (Exception $e){
        echo $e->getMessage();
    }

    }

}