<?php
    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    
    // set the default value for $name
    $name = "fella";
 
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
        
        // query the phonebook to see if the caller's number is in there
        // 1. get a connection to the database server
        $dbh=pg_connect("host=database.tcnj.edu dbname=thompsom user=thompsom password=0D1NRULEs");
        // 2. build our query
        $sql="SELECT * FROM phonebook.address WHERE phone='".$_REQUEST['From']."';";
        // 3. execute it
        $result=pg_exec($sql);
        
        // check if we got a result back
        $rowcount=pg_numrows($result);
        
        // if there's a result, grab the name value & assign it to our $name variable
        if($rowcount){
            $row = pg_fetch_array($result);
            $name = $row['name'];
        }
        
        // close the db connection
        pg_close($dbh);
    }

?>
<Response>
    <Message>Hey <?php echo $name ?>, thanks for the message!</Message>
</Response>