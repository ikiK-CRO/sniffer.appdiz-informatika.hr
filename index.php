<?php
require __DIR__ . '/vendor/autoload.php';
require('db.php');

use function Amp\ParallelFunctions\parallelMap;
use function Amp\Promise\wait;


$array = wait(parallelMap([
    'https://germany.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
    'https://london.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
    'https://newyork.zapwp.net/key:51f0429e31298bf7461bed0a35589cb68d1babce/q:intelligent/retina:false/webp:true/w:1/url:https:/vloryas.com/wp-content/uploads/2019/11/h1-testimonials-img-2-1-768x522.jpg',
], function ($url) {
    return file_get_contents($url);
}));



foreach ($array as $val) {
    // $currentDateTime = date('Y-m-d H:i:s');
    // echo $currentDateTime;
    $sql = "INSERT INTO snif (time) VALUES (NOW())";

    if ($con->query($sql) === TRUE) {
        echo "true";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
