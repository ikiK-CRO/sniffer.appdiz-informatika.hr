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
], function ($url) {
    $ch = curl_init();

    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );

    curl_setopt_array($ch, $optArray);

    $result = curl_exec($ch);

    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);

    $res = array($response, $header_size, $contentType, $url);
    // var_dump($errors);
    return $res;
}));

foreach ($array as $val) {
    // echo $val[0] . '<br>';
    // echo $val[1] . '<br>';
    // echo $val[2] . '<br><br>';
    $base =  imageToBase64($val[3]);
    // echo '<img src="' . $base . '" />';

    // echo '<img src="' . imageToBase64($val[3]) . '" />';
    // $currentDateTime = date('Y-m-d H:i:s');
    // echo $currentDateTime;

    if ($val[0] != 0) {
        $sql = "INSERT INTO snif (snif_time, snif_code, snif_size, snif_type, snif_base64) VALUES (NOW(), '$val[0]', '$val[1]' , '$val[2]', '$base')";

        if ($con->query($sql) === TRUE) {
            echo "true";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        $msg = "Error \n code 0";
        $msg = wordwrap($msg, 70);
        mail("kiki.ikik@gmail.com", "Sniffer Error", $msg);
    }
}

function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function imageToBase64($image)
{
    $imageData = base64_encode(curl_get_contents($image));
    $mime_types = array(
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'odt' => 'application/vnd.oasis.opendocument.text ',
        'docx'    => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'gif' => 'image/gif',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'bmp' => 'image/bmp'
    );
    $ext = pathinfo($image, PATHINFO_EXTENSION);

    if (array_key_exists($ext, $mime_types)) {
        $a = $mime_types[$ext];
    }
    return 'data: ' . $a . ';base64,' . $imageData;
}

// How To Use it
