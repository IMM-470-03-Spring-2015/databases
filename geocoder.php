<?php
// get the number of the sender using the 'From' request value
$from = $_REQUEST['From'];
// get the content of the text using the 'Body' request value
$body = $_REQUEST['Body'];

// tell the browser to expect an XML response
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

// initialize the return message
$msg = '';

// geocode using Google's geocoder: https://developers.google.com/maps/documentation/geocoding/
$addr_json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key="xxxxxxxxxx"&address='.urlencode($body));
// transform the json into a PHP array
$addr = json_decode($addr_json);

// make sure we were successful with the geocode
if($addr->status == 'OK'){
    // we've got our geocode, do other stuff with it
    $msg = "Location Details:\n\n";
    $msg.= $addr->results[0]->formatted_address."\n";
    $msg.= $addr->results[0]->geometry->location->lat.", ";
    $msg.= $addr->results[0]->geometry->location->lng;
} else {
    // there was an error, parse it and respond appropriately
    // possible values: https://developers.google.com/maps/documentation/geocoding/index#StatusCodes
    $msg = $addr->status;
}
    
?>
<Response>
    <Message>
        <?php echo $msg; ?>
    </Message>
</Response>
