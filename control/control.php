<?php

class operator
{

    private $connection;
    public $query_string;

    function __construct()
    {
        $this->cors();
        $this->connection = $this->open_connection();
    }


    /**
     * Coders Class CRUD Section
     * This section for CRUD Operation
     * Create - Read - Update - Delete
     */
    // function find_data($nama)

    // {
    //     $sql_query = "SELECT * FROM data_rfid WHERE nama LIKE '".$nama."' ";
    //     $this->execute_query($sql_query, [], true);
    // }
    // function read_data()
    // {
    //     $sql_query = "SELECT * FROM data_rfid";
    //     echo $this->execute_query($sql_query, [], true);
    // }

    function create_data($uid)
    {
        $sql_query = "INSERT INTO data_rfid (data_uid) VALUES ('".$uid."')";
        echo $this->execute_query($sql_query);
    }

    // function update_data($id, $update_data = [])
    // {
    //     $sql_query = "UPDATE data_rfid SET ".$update_data['column']." = ".$update_data['value']." WHERE id = ".$id."";
    //     $this->execute_query($sql_query);
    // }

    // function delete_data($id)
    // {
    //     $sql_query = "DELETE FROM data_rfid WHERE id = ".$id."";
    //     echo $this->execute_query($sql_query);
    // }

    /**
     * Coders Class Connection Section
     * This section for RDBMS Operation Only
     * 
     */

    function error_handler($params = [])
    {
        $data = [];
        foreach($params as $param => $rules) {
            $data[$param] = $rules;
        }
        $data['status'] = false;
        $data['message'] = 'error on operation';
        return json_encode($data);
    }

    function is_url_query($string_value)
    {
        $query = array();
        parse_str($this->query_string, $query);
        if (array_key_exists($string_value, $query)) {
            return true;
        }
        return false;
    }

    function get_url_query_value($string_value)
    {
        $query = array();
        parse_str($this->query_string, $query);
        return $query[$string_value];
    }

    /**
     * Coders Class Connection Section
     * This section for RDBMS Operation Only
     * 
     */

    private function open_connection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "data_id";
        $conn = new mysqli($servername, $username, $password, $dbname) or die("Failed connect: %s\n" . $conn->error);
        return $conn;
    }

    private function close_connection()
    {
        $this->connection->close();
    }

    private function execute_query($sql, $data = [], $is_read = null)
    {
        $executed = $this->connection->query($sql);
        if ($executed == TRUE)
        {
            $data['status'] = true;
            $data['message'] = 'data operation success';

            if (!is_null($is_read) && $is_read)
            {
                $data['data'] = [];
                if($executed->num_rows != 0)
                {
                    while($row = $executed->fetch_assoc())
                    {
                        $data['data'][] = $row;
                    }
                }
            }

            return json_encode($data);
        }

        $data['status'] = false;
        $data['message'] = 'data operation failed';
        return json_encode($data);
    }

    private function cors() {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
    }

}
?>
