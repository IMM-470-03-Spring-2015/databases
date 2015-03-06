<?php
    // we can get the number of the sender using the 'Fromn' request value
    $from = $_REQUEST['From'];
    $msg = $_REQUEST['Body'];

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    
    // break up the message into an array for cleaning
    $msg_arr = explode(",",$msg);
    // remove any extra spaces
    for($i=0; $i<count($msg_arr); $i++){
        $msg_arr[$i] = trim($msg_arr[$i]);
        // and force it to floating point
        if($i>0 & !strstr($msg_arr[$i],'.')){
            $msg_arr[$i] = $msg_arr[$i].".0";
        }  
    }
    
    // insert the incident into the db
    // 1. get a connection to the database server
    $dbh=pg_connect("host=database.tcnj.edu dbname=thompsom user=thompsom password=0D1NRULEs");
    // 2. build our query
    $sql="INSERT INTO incidents (name,latitude,longitude) VALUES('". $msg_arr[0] ."',". $msg_arr[1] .",". $msg_arr[2] .");";
    // 3. execute it
    $result=pg_exec($sql);
?>
<Response>
    <Message>Incident <?php echo $msg_arr[0] . " reported at ". $msg_arr[1] . ", " . $msg_arr[2]. "."; ?></Message>
</Response>
