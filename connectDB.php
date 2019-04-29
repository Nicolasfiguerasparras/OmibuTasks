<?php
    function connectDB() {
        $db = mysqli_connect("127.0.0.1", "root", "", "Omibu");
        if (!$db) {
            echo "Error: No se pudo conectar a MySQL.". PHP_EOL;
            echo "Error de depuración: ". mysqli_connect_errno() . PHP_EOL;
            echo "Error de depuración: ". mysqli_connect_error() . PHP_EOL;
            exit;
        }
        mysqli_set_charset($db,'utf8');
        return $db;
    }

    function collectID($db, $table){
        $query = "SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '$table'";
        $result = mysqli_query($db, $query);
        return $result->fetch_object()->auto_increment;
    }
?>