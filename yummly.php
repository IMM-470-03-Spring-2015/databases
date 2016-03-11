<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

// Get what's being sent to us
$from = $_REQUEST['From'];
$body = $_REQUEST['Body'];

if ($_GET['q']) $question=$_GET['q'];
$rpictures=true;

////////////////////////////////
// API credentials /////////////

// TODO: please obtain API credentials form developer.yummly.com
$appid = "efd4775e";
$appkey = "10a3056337159815406e345bc78ff884";

// Number of itens in response
$returnitems = 1; 

// Building string for GET request
$requeststr = "http://api.yummly.com/v1/api/recipes?";

$requeststr=$requeststr."_app_id=".$appid;
$requeststr=$requeststr."&_app_key=".$appkey;

$requeststr=$requeststr."&q=".$body; // should probably parse this for unwanted stuff, but hey, it's a demo
if ($rpictures) $requeststr=$requeststr."&requirePictures=".$rpictures;

// Debug
//echo $requeststr

// CURL for communicating with web service

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$requeststr);
curl_setopt($ch, CURLOPT_VERBOSE, 1);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

$response = curl_exec($ch);

// We can do some heavy lifting on the server side
// and send back already prepared html from only the elements
// we need.
$response_decoded = json_decode($response, true);

$bodystring = "";
$mediastring = "";

for ($i=0; $i<$returnitems; $i++) {
    $bodystring.= "Recipe Name: ".
                $response_decoded['matches'][$i]['recipeName'].", it has ".
                count($response_decoded['matches'][$i]['ingredients'])." ingredients.\n";
    
    $mediastring = $mediatring . "<Media>".
                $response_decoded['matches'][$i]['smallImageUrls']['0']."</Media>";
}

echo '<Response><Message>'.$bodystring."\n\n".$mediastring.'</Message></Response>';

?>
