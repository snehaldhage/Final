<?php
class Mylib
{
    private static $obj;
    private $conn;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db_name = 'db_school';
    protected static $dbdriver = 'mysqli';
    //private constructor prevent object formation outside the class using new keyword
    //The db connection is established in the private constructor
    protected function __construct($dbdriver)
    {
        switch ($dbdriver) {
            case 'pdo':
                $this->conn = new PDO("mysql:host={$this->host};
                        dbname={$this->db_name}", $this->user, $this->pass,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                break;
            case 'mysqli':
                $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);
                break;
            case 'mongodb':
                /*$db = new Mongo('mongodb://localhost', array(
                'username' => 'abc',
                'password' => 'abc@123',
                'db'       => 'abc'
                ));*/
                break;
            default:
                $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);
        }
    }
    /**
     * A method to return singleton instance of current class
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$obj)) {
            self::$obj = new Mylib(self::$dbdriver);
        }
        return self::$obj;
    }

    /**
     * A method to return db connection
     * @return dbconnection resource
     */
    public function getConnection()
    {
        return $this->conn;
    }

    public function executeQuery($query)
    {
        return mysqli_query($this->conn, $query);
    }

    public function insert_data($table, $insert_data, $insert_id = false, $array_new_data = array())
    {
        $value = '';
        $field = '';
        foreach ($insert_data as $column => $val) {
            $value = $value . "'" . $val . "',";
            $field = $field . '`' . $column . "`,";
        }
        foreach ($array_new_data as $column => $v) {
            $value = $value . $v . ",";
            $field = $field . '`' . $column . "`,";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $value = substr($value, 0, strlen($value) - 1);
        $query = "INSERT INTO $table($field) VALUES ($value)";
        $result = self::executeQuery($query);
        if ($insert_id) {
            $result = mysqli_insert_id($this->conn);
        }
        return $result;
    }
    public function update_data($table, $update_data, $where, $update_new_data = array())
    {
        $data = '';
        foreach ($update_data as $k => $v) {
            $data = $data . "`" . $k . "`='" . $v . "',";
        }
        foreach ($update_new_data as $k => $v) {
            $data = $data . "`" . $k . "`=" . $v . ",";
        }
        $data = substr($data, 0, strlen($data) - 1);
        $query = "UPDATE $table SET $data WHERE $where";
        //echo $query;
        return self::executeQuery($query);
    }
    public function delete_data($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        return self::executeQuery($query);
    }

    public function read_data($config)
    {
        $fields = isset($config['fields']) ? $config['fields'] : '*'; //$config['fields'];
        $table = isset($config['table']) ? $config['table'] : $config['table_name'];
        $where = isset($config['where']) ? $config['where'] : null;
        $joins = isset($config['joins']) ? $config['joins'] : null;
        $order = isset($config['order']) ? $config['order'] : null;
        $start = isset($config['start']) ? $config['start'] : '0';
        $limit = isset($config['limit']) ? $config['limit'] : null;
        $group_by = isset($config['group_by']) ? $config['group_by'] : null;
        $distinct = isset($config['distinct']) ? $config['distinct'] : '0';
        $sql = "SELECT $fields FROM $table ";
        if ($joins != null) {
            $sql .= " $joins ";
        }
        if ($where != null) {
            $sql .= " $where";
        }
        return self::executeQuery($sql);
    }

    public function send_mail($email, $message, $subject)
    {
        /* require_once 'mailer/class.phpmailer.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    // $mail->SMTPSecure = "ssl";
    $mail->Host = "mail.mypetroapp.me";
    $mail->Port = 587; //465;
    $mail->AddAddress($email);
    $mail->Username = "contact@mypetroapp.me";
    $mail->Password = 'qJ7q9~n8Z4$8';
    $mail->SetFrom('contact@mypetroapp.me', 'My Petro App');
    $mail->AddReplyTo("contact@mypetroapp.me", "My Petro App");
    $mail->AddBCC('contact@mypetroapp.me', 'My Petro App');
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    //$mail->AddAttachment( $file, 'file.zip' );   //to send attachment with email.
    $mail->Send(); */
    }

}
