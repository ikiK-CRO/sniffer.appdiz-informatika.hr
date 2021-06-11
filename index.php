<?php
require __DIR__ . '/vendor/autoload.php';
require('db.php');

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;


$html = '';
$array = wait(parallelMap([
    'https://germany.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
    'https://wpcdn.us-east-1.vip.tn-cloud.net/www.channel3000.com/content/uploads/2020/03/Baby-Yoda.jpg',
    'https://newyork.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
], function ($url) {
    return $url;
}));


$num = 1;
foreach ($array as $url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 1);

    $response = curl_exec($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $headers = explode("\r\n", $headers);

    $headers = array_filter($headers);

    foreach ($headers as &$value) {
        $html .= '<li>' . $value . '</li>';
    }
    $html = '<ol>' . $html . '</ol>';

    // header("Content-Type:text/html; charset=UTF-8");
    echo $html;

    // // $currentDateTime = date('Y-m-d H:i:s');
    // echo $currentDateTime;


    // $sql = "INSERT INTO snif (time) VALUES (NOW())";

    // if ($con->query($sql) === TRUE) {
    //     echo "true";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $con->error;
    // }

}
