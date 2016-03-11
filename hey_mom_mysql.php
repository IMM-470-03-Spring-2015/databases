<?php

    // now greet the sender
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    // set the default value for $name
$name = "fella";

    // database credentials
$db_user = 'mhloreco_me';
$db_password = '********';
$db_host = 'localhost';
$db_name = 'mhloreco_dw';

// connect to database
$db = mysqli_connect ($db_host, $db_user, $db_password, $db_name) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());


    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
if(isset($_REQUEST['From'])) {

        // query the phonebook to see if the caller's number is in there
        // 1. get a connection to the database server
        // 2. build our query
    $sql="SELECT * FROM phonebook WHERE phone='".$_REQUEST['From']."';";
        // 3. execute it
    $result=mysqli_query($db, $sql);

        // check if we got a result back
    $rowcount=mysqli_num_rows($result);

        // if there's a result, grab the name value & assign it to our $name variable
    if($rowcount){
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    }

        // close the db connection
    mysqli_close($db);
}
?>
<Response>
    <Message>Hey <?php echo $name ?>, thanks for the message!</Message>
</Response>
