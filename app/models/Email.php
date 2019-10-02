<?php

class Email {
    const EMAIL_STATUS = [1=>'Pending',2=>'Sent'];
    private $empno;
    private $subject;
    private $content;
    private $toPerson;
    private $status;

    /**
     * Email constructor.
     */
    public function __construct()
    {
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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getToPerson()
    {
        return $this->toPerson;
    }

    /**
     * @param mixed $toPerson
     */
    public function setToPerson($toPerson): void
    {
        $this->toPerson = $toPerson;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function notifyEmployee($empNo,$email,$empName){
        try{
            $file = file_get_contents('../app/templates/LateAttendanceNotification.php');
            $file = str_replace('{{$person}}',$empName, $file);
            $file = str_replace('{{$todayDate}}',date('Y-m-d'), $file);

            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Insert into phpproject.emails (employee_id,subject,content,to_person,status)
                                               VALUES ($empNo,'Late Attendance Notification','$file','$email',1)");
            $result = $stmt->execute();
            if($result > 0){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function notifyManager($empNo){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select m.email, e.employee_name from employees e, employees m where e.manager = m.id and e.id = $empNo;");
            $stmt->execute();
            $result = $stmt->fetch();
            $email = $result['email'];
            $file = file_get_contents('../app/templates/LeaveAttendanceNotification.php');
            $file = str_replace('{{$person}}',$result['employee_name'], $file);
            $file = str_replace('{{$todayDate}}',date('Y-m-d'), $file);
            $stmt = $conn->prepare("Insert into phpproject.emails (employee_id,subject,content,to_person,status)
                                               VALUES ($empNo,'Leave Attendance Notification','$file','$email',1)");
            $result = $stmt->execute();
            if($result > 0){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}