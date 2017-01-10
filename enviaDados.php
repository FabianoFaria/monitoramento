<?php
// where are we posting to?
$url = 'http://monitor.eficazsystem.com.br/datasync.php';

// what post fields?
$fields = array(
   'A' => '860719028549255',
   'B' => '1111',
   'C' => '2222',
   'D' => '3333',
   'E' => '1111',
   'F' => '2222',
   'G' => '3333',
   'H' => '1111',
   'I' => '2222',
   'J' => '3333',
   'L' => '1111',
   'M' => '2222',
   'N' => '3333',
   'O' => '1111',
   'P' => '2222',
   'Q' => '3333',
   'R' => '1111',
   'S' => '2222',
   'T' => '3333',
   'U' => '3333'
);

// build the urlencoded data
$postvars = http_build_query($fields);

// open connection
$ch = curl_init();

// set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

// execute post
$result = curl_exec($ch);

// close connection
curl_close($ch);

?>
