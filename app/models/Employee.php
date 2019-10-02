<?php

class Employee {
    private $empno;
    private $name;
    private $salary;
    private $dept;
    private $pic;
    private $manager;
    private $role;
    private $email;
    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary): void
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * @param mixed $deptno
     */
    public function setDept($dept): void
    {
        $this->dept = $dept;
    }

    /**
     * @return mixed
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * @param mixed $pic
     */
    public function setPic($pic): void
    {
        $this->pic = $pic;
    }

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $manager
     */
    public function setManager($manager): void
    {
        $this->manager = $manager;
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
    public function getEmployeeDetails($empNo){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select e.id , e.employee_name, e.salary, s.role, s.id as 'roleid', d.department_name, d.id as 'deptno',
                                            e.picture, e.email, m.employee_name as 'manager',m.id as 'managerId'
                                            from employees e, roles s, departments d, employees m 
                                            where s.id = e.role_id and e.department_id = d.id and e.manager = m.id
                                            and e.id='$empNo';");
            $stmt->execute();
            $employee = $stmt->fetch();
            $result = $stmt->rowCount();
            if($result > 0){
                return $employee;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function getEmployeeName($empNo){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select employee_name from employees e where e.id='$empNo';");
            $stmt->execute();
            $employee = $stmt->fetch();
            if($employee){
                return $employee['employee_name'];
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function createAdmin(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Insert into phpproject.employees (employee_name,salary,department_id,picture,manager,role_id, email) 
                        values ('Admin', null, 60, null , null, 0, 'alpha@gmail.com')");
            $stmt->execute();
            $result = $stmt->rowCount();
            if($result > 0){
                return $conn->lastInsertId();
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function addEmployee(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            if($this->manager == null){
                $this->manager = 0;
            }
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Insert into phpproject.employees (employee_name,salary,department_id,picture,manager,role_id,email) 
                        values ('$this->name', '$this->salary', '$this->dept', '$this->pic' , '$this->manager', $this->role, '$this->email')");
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
    public function updateEmployee(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($this->pic == ''){
                $stmt = $conn->prepare("SELECT picture from employees where id = $this->empno");
                $stmt->execute();
                $result = $stmt->fetch();
                $this->pic = $result['picture'];
            }
            $stmt = $conn->prepare("UPDATE phpproject.employees
            set employee_name = '$this->name', salary = $this->salary, department_id = '$this->dept', 
            picture = '$this->pic' , manager = '$this->manager', role_id = '$this->role', email = '$this->email' where id = '$this->empno'");
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

    public function addNewUserAccount($empname){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT id from phpproject.employees where employee_name='$empname';");
            $stmt->execute();
            $empno = $stmt->fetch();
            $empno = $empno['id'];

            $stmt = $conn->prepare("Insert into phpproject.users (username,password,employee_id) 
                                                values ('$empname', 'coeus123', $empno)");

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
    public function showEmployees(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("Select e.id, e.employee_name, e.salary, s.role, d.department_name, e.picture, m.employee_name as 'manager' 
                                            from employees e, roles s, departments d, employees m 
                                            where s.id = e.role_id and e.department_id = d.id and e.manager = m.id");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if($result){
                return $result;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function deleteEmployee(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("Delete from phpproject.employees where id = '$this->empno'");
            $result = $stmt->execute();
            if($result){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function deleteUserAccount(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("Delete from phpproject.users where employee_id = '$this->empno'");
            $result = $stmt->execute();
            if($result){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function getLateEmployeeToday() {
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("select id, email, employee_name from employees where id NOT IN ( select employee_id from attendance)");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if($result){
                return $result;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function getAllManagers(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * from phpproject.employees where role_id=4");
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