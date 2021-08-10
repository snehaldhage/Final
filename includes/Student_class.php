<?php
class Student_class extends Mylib
{
    public function __construct()
    {
        parent::__construct(parent::$dbdriver);
    }
    public function create_student()
    {
        $conn = parent::getConnection();
        echo '<pre>'; 
        var_dump($conn);
    }

}
