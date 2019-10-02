<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: /public/login/index');
}
include '../app/models/Department.php';
include '../app/models/Role.php';
include '/app/models/Employee.php';
?>
<!DOCTYPE html>
<head>
    <title>Edit Employee</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/views/style.css">
</head>
<body>
<div class="center">
    <h1>Edit Employee</h1>
    <form action="/public/manager/editEmployee/<?php echo $data['employee']['id'] ?>" method="post" class="addEmployeeForm" enctype="multipart/form-data">
        <img src="/app/views/logo.png" width="200" height="200"><br>
        <input type="text" name="empname" placeholder="Employee Name" value="<?php echo $data['employee']['employee_name']?>"><br>
        <input type="tel" name="salary" placeholder="Salary" value="<?php echo $data['employee']['salary']?>"><br>
        <input type="email" name="email" placeholder="Email" value="<?php echo $data['employee']['email']?>"><br>
        <select name="department">
            <option selected hidden value="<?php echo $data['employee']['deptno']?>"><?php echo $data['employee']['department_name']?></option>
            <?php
            $dept = new Department();
            $result = $dept->getDepartments();
            foreach ($result as $element){
                echo "<option value=".$element["id"].">".$element['department_name']."</option>";
            }
            ?>
        </select>
        <select name="manager">
            <option selected hidden value="<?php echo $data['employee']['managerId']?>"><?php echo $data['employee']['manager']?></option>
            <?php
            $man = new Employee();
            $result = $man->getAllManagers();
            foreach ($result as $element){
                echo "<option value=".$element["id"].">".$element['employee_name']."</option>";
            }
            ?>
        </select>
        <select name="role">
            <option selected hidden value="<?php echo $data['employee']['roleid']?>"><?php echo $data['employee']['role']?></option>
            <?php
            $roles = new Role();
            $result = $roles->getAllRoles();
            foreach ($result as $element){
                echo "<option value=".$element["id"].">".$element['role']."</option>";
            }
            ?>
        </select>
        <input type="file" name="prPic" id="prPic" accept="image/*" onchange="readURL(this)"><br>
        <img src="<?php echo '/app/images/'.$data['employee']['picture']?>" id="profilePic" width="50"/><br>
        <input type="submit" value="Edit Employee" name="editEmployee">
    </form>
</div>
<script src="/app/js/jquery-3.4.1.min.js"></script>
<script src="/app/js/main.js"></script>
</body>