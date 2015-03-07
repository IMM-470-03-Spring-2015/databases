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

$forecast_json = file_get_contents('https://api.forecast.io/forecast/25c2db6aec83c0a6ccf85f5dbc086830/'.$msg_arr[1].",".$msg_arr[2]);
$forecast = json_decode($forecast_json);
    
?>

<Response>
    <Message>
        <?php 
            echo "Current conditions at " . $msg_arr[0] . ": " . 
                $forecast->currently->summary . ", " . 
                $forecast->currently->temperature . " degrees, humidity " . 
                ($forecast->currently->humidity*100) . "%, wind speed " . 
                $forecast->currently->windSpeed . " m/h, visibility " . 
                $forecast->currently->visibility . " m";
        ?>
    </Message>
</Response>
