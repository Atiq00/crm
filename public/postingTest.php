<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://secure.setshape.com/postlead/11685/12127',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('firstname' => 'johnTEST','lastname' => 'DoeTEST','email' => 'TEST@TEST.COM','phone' => '7785415215','city' => 'texas','state' => 'TX','zip' => '55221','leadfulladdress' => 'TEST ADDRESS','LoanAmount' => '150000','bormortgageinterestRate' => '4.26','loncashOutAmt' => '22000'),
  //CURLOPT_HTTPHEADER => array(
  //  'Cookie: XSRF-TOKEN=eyJpdiI6IjBFOTk1Ulo3TFRnbThqcjlVQTBRS3c9PSIsInZhbHVlIjoiUnlGRytSaHNUQUtJbVwvdmhrbHE2WExGb0RaaEFkdVFES1ZvMVo5d0xFMFd2SVBRSVhNdFRpYnRBVWpZck9oOWtTWnVTZ2xlWW54ZTMrZENuOWFLSDNnPT0iLCJtYWMiOiI1MjI1YTE2OTk0MTE4NDM4YjBjYjI5ZjJiNTJjY2UyNWEzOWQ0NWNmYzQyMmRjNjVlMDc3ZDc4M2Q4MzlhODE1In0%3D; laravel_session=eyJpdiI6Im9WVG8rZExqZHVSVkdHZUZDTGREWkE9PSIsInZhbHVlIjoiXC9Jc3pmRm5hVWY0a25vNHREMlEydnMyR0ltdjhwODFcL1E3MXpUazRjZmpHV0l2RFwva25ZZXR0aFRjeEN4QWNNQll5aFRwTVYrUmtNclVjWW55UURrWUE9PSIsIm1hYyI6ImI1NmE4YTQ2ODNkYzFmNmU5YjFkNWMzYTRiY2E2MTIxODU5NzNhOTE5MzkzMzNlYjBmZmY1MzBkNjJjOTZjZjMifQ%3D%3D'
  //),
));

$response = curl_exec($curl);

curl_close($curl);
echo json_encode($response);

