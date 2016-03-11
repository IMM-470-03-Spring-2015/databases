<?php
// we can get the number of the sender using the 'Fromn' request value
$from = $_REQUEST['From'];
$body = $_REQUEST['Body'];

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

// initialize the return message
$msg = '';

// geocode using Google's geocoder: https://developers.google.com/maps/documentation/geocoding/
$addr_json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=xxxxxxxxx&address='.urlencode($body));
// transform the json into a PHP array
$addr = json_decode($addr_json);

// make sure we were successful with the geocode
if($addr->status == 'OK'){
    // we've got our geocode, do other stuff with it
    $faddr = $addr->results[0]->formatted_address;
    $lat = $addr->results[0]->geometry->location->lat;
    $lon = $addr->results[0]->geometry->location->lng;
    
    // call the Forecast.io API
    $forecast_json = file_get_contents('https://api.forecast.io/forecast/25c2db6aec83c0a6ccf85f5dbc086830/'.$lat.",".$lon);
    $forecast = json_decode($forecast_json);
    
    // build the response message
    $msg = "Current conditions at " . $faddr . ":\n\n";
    $msg.= 'Skies: '.$forecast->currently->summary . "\n";
    $msg.= 'Temp: '.$forecast->currently->temperature . " degrees\n";
    $msg.= 'Humidity: '.($forecast->currently->humidity*100) . "%\n";
    $msg.= 'Wind: '.$forecast->currently->windSpeed . " m/h\n";
    $msg.= 'Visiblity: '.$forecast->currently->visibility . " m";
    
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
