<?php
    include("control/config.php");
    $sql = mysqli_query($mysqli, "SELECT * FROM data_rfid ORDER BY id DESC");
    $result = array();
    
    while ($row = mysqli_fetch_assoc($sql)) {
        $data[] = $row;
    }

    echo json_encode(array("result" => $data));
?>