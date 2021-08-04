<?php
error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';
require('db.php');

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;


$array = wait(parallelMap([
    'https://germany.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
    'https://wpcdn.us-east-1.vip.tn-cloud.net/www.channel3000.com/content/uploads/2020/03/Baby-Yoda.jpg',
    'https://newyork.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
    'https://dl1.cbsistatic.com/i/2020/05/04/18018b2a-91b1-40b5-b91a-4412a10fac7f/aedc25fa28604a2a87d3b7df56cb4877/imgingest-9025120176881342416.png',
], function ($url) {
    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
    $ch = curl_init();

    curl_setopt($curl, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);

    $result = curl_exec($ch);

    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    $currentDateTime = date('Y-m-d H:i:s');

    curl_close($ch);

    $res = array($response, $header_size, $contentType, $url, $result, $currentDateTime);
    return $res;
}));

foreach ($array as $val) {
    echo 'Response Code: ' . $val[0] . '<br>';
    echo 'Response Size: ' . $val[1] . '<br>';
    echo 'Response Time: ' . $val[5] . '<br>';
    echo 'Response Type: ' . $val[2] . '<br><br>';

    $base =  imageToBase64($val[4], $val[2]);

    if ($val[0] != 200) {
        $msg = "Error \n code 0";
        $msg = wordwrap($msg, 70);
       // mail("xxx", "Sniffer Error", $msg);
        echo 'Email sent...<br>';
    } else {
        $sql = "INSERT INTO snif (snif_time, snif_code, snif_size, snif_type, snif_base64) VALUES ('$val[5]', '$val[0]', '$val[1]' , '$val[2]', '$base')";

        if ($con->query($sql) === TRUE) {
            echo "DB INSERT RESPONSE: true<br><br>";
            echo '<img src="' . $base . '" /><br>';
        } else {
            echo "DB INSERT RESPONSE: Error: " . $sql . "<br>" . $con->error;
        }
    }
}

function imageToBase64($image, $type)
{
    $imageData = base64_encode($image);
    return 'data: ' . $type . ';base64,' . $imageData;
}
