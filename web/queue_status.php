<?php
require_once 'phpgen_settings.php';
require_once 'database_engine/mysql_engine.php';
 
if (isset($_GET['id']) && isset($_GET['dwnstatus']))
{
    $connection = new MyConnection(GetGlobalConnectionOptions());
    $connection->Connect();
 
    $id = $_GET['id'];
    $dwnstatus = $_GET['dwnstatus'];
    $sql = "UPDATE queue SET dwnstatus='$dwnstatus' WHERE id='$id'";
    $connection->ExecSQL($sql);
    $connection->Disconnect();
    echo json_encode(array("id" => $id, "dwnstatus" => $dwnstatus));
}
?>