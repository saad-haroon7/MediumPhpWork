<?php

class Attendance {
    const STATUS_INFO = [0 =>'Late',1 => "OnTime", 2 => "Leave"];
    private $timein;
    private $timeout;
    private $date;
    private $statusid;
    private $empno;

    function __construct(){

    }

    public function getStatusName($id){
        return self::STATUS_INFO[$id];
    }
    /**
     * @return mixed
     */
    public function getTimein()
    {
        return $this->timein;
    }

    /**
     * @param mixed $timein
     */
    public function setTimein($timein): void
    {
        $this->timein = $timein;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getStatusid()
    {
        return $this->statusid;
    }

    /**
     * @param mixed $statusid
     */
    public function setStatusid($statusid): void
    {
        $this->statusid = $statusid;
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

    public function markAttendance(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $date = date('Y-m-d');
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * from $db_name.attendance where employee_id = '$this->empno' and date='$date'");
            $result = $stmt->execute();
            if ($stmt->rowCount() > 0){
                $stmt = $conn->prepare("UPDATE $db_name.attendance SET time_in = '$this->timein',time_out = '$this->timeout',
                                                            date = '$this->date', status = $this->statusid, employee_id = $this->empno where employee_id = $this->empno");
            }else {
                $stmt = $conn->prepare("Insert into $db_name.attendance (time_in, time_out, date, status, employee_id) 
                                values ('$this->timein','$this->timeout','$this->date',$this->statusid,$this->empno)");
            }
            $result = $stmt->execute();
            if($result > 0){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function getTodayAttendanceDetails(){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $date = date('Y-m-d');
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select * from $db_name.attendance where employee_id = '$this->empno' AND date='$date'");
            $result = $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if($result){
                return $result[0];
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function getEmployeesTodayAttendance() {
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $date = date('Y-m-d');
            $stmt = $conn->prepare("Select * from $db_name.attendance where date='$date'");
            $result = $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if($result){
                return $result;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function getMonthlyReport($month){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select distinct employee_id, status 
                                        from $db_name.attendance 
                                        where date like '%-$month-%' and status IN (0,2) order by employee_id");
            $result = $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            foreach ($result as $ele){
                $dp[$ele['employee_id']][]=$ele['status'];
            }
//            $result['data'] = $dp;
            if($result){
                return $result;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function markLeave($empno){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $todayDate = date('Y-m-d');
            $stmt = $conn->prepare("INSERT INTO phpproject.attendance (time_in, time_out, date, status, employee_id) 
                                                VALUES ('00:00:00','00:00:00','$todayDate',2,$empno)");
            $result = $stmt->execute();
            if($result){
                return true;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    public function getEmployeeAttendanceDetails($statusid,$month){
        try{
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "maxwell7044";
            $db_name = "phpproject";
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("Select * 
                                        from $db_name.attendance 
                                        where date like '%-$month-%' and status = $statusid and employee_id = '$this->empno'");
            $result = $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if($result){
                return $result;
            }else
                return false;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

?>