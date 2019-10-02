<?php

class Department {
    private $deptno;
    private $name;

    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getDeptno()
    {
        return $this->deptno;
    }

    /**
     * @param mixed $deptno
     */
    public function setDeptno($deptno): void
    {
        $this->deptno = $deptno;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
    public function getDepartments(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * from phpproject.departments");
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

?>