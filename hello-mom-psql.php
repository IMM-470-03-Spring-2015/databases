<?php
    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    $name = "fella";
 
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
        // query the phonebook to see if the caller's number is in there
        $dbh=pg_connect("host=database.tcnj.edu dbname=thompsom user=thompsom password=0D1NRULEs");
        $sql="SELECT * FROM phonebook WHERE phone='".$_REQUEST['From']."';";
        $result=pg_exec($sql);
        
        $rowcount=pg_numrows($result);

        if($rowcount){
            $row = pg_fetch_array($result);
            $name = $row['name'];
        }
        
        pg_close($dbh);
    }

 

?>
<Response>
    <Message>Hey <?php echo $name ?>, thanks for the message!</Message>
</Response>