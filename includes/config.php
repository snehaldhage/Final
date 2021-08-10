<?php
@session_start(); //mandatory if session is used in project.
@ob_start(); //optional
date_default_timezone_set("Asia/Kolkata");
require_once 'constant.php';
spl_autoload_register('myautoloader');
function myautoloader($class_name)
{
    include $class_name . '.php';
}

/*  class MainLib{
 public $con;
  public function __construct(){
     $this->con=mysqli_connect(__db_host,__db_user,__db_password,__db_name) 
     or die(mysqli_connect_error());
 }
 public function getConnection(){
  return $this->con; 
 }
} 
 */
// echo '<pre>';
// $obj1 = new MainLib();
// $db_conn = $obj1->getConnection();
// var_dump($db_conn);

$obj = Mylib::getInstance();
//$db_conn = $obj->getConnection();
$insert_data = array('school_name'=>'CMCS College,Nashik','is_active'=>'Active');
echo $school_id = $obj->insert_data('tbl_school',$insert_data,true);

//echo '<pre>';
//var_dump($db_conn);
//$stud_obj = new Student_class();
//$stud_obj->create_student();

// echo '<pre>';
// $instance = Mylib::getInstance();
// $conn = $instance->getConnection();
// var_dump($conn);

// echo '<pre>';
// $instance = Mylib::getInstance();
// $conn = $instance->getConnection();
// var_dump($conn);
// echo '<pre>'; 
// $instance = Mylib::getInstance();
// $conn = $instance->getConnection();
// var_dump($conn);

//$obj1 = Mylib::getInstance();
// if ($obj == $obj1) {
//     echo 'Same';
// }
