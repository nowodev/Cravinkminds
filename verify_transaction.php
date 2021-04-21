<?php
include 'engine/conn.php';

$ref = $_GET['reference'];
if ($ref = "") {
  header("Location: javascript://history.go(-1)");
}

$curl = curl_init();

curl_setopt_array($curl, array(
  // CURLOPT_URL => "https://api.paystack.co/transaction/verify/:reference",
  // CURLOPT_URL => 'https://api.paystack.co/transaction/verify/' . rawurlencode($ref),
  CURLOPT_URL => 'https://api.paystack.co/transaction/verify/' . $ref,
  CURLOPT_SSL_VERIFYPEER => false, // to test on localhost
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer sk_test_87a34498d6a904890ded7ee70cdac23bb722e319",
    "Cache-Control: no-cache",
  ),
));


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  $result = json_decode($response);
  // echo $result->message;
}

if ($result->data->status == 'success') {
  $status = $result->data->status;
  $reference = $result->data->reference;
  $amount = $result->data->amount;
  $lname = $result->data->customer->last_name;
  $fname = $result->data->customer->first_name;
  $fullname = $lname . ' ' . $fname;
  $customer_email = $result->data->customer->email;

  date_default_timezone_set('Africa/Lagos');
  $date_time = date('m/d/Y hi:s a', time());

  $query = "INSERT INTO payment (status, reference, fullname, date_purchased, amount, email) 
          VALUES ('$status', '$reference', '$fullname', '$date_time', '$amount', '$customer_email')";
  $result = mysqli_query($conn, $query);

  if (!$result) {
    echo "Can't add new data " . mysqli_error($conn);
    exit;
  } else {
    header("Location: private/purchase.php?status=success");
    exit;
  }
} else {
  // header('HTTP/1.0 403 Forbidden', TRUE, 403);
  print('error'. $err);
  exit;
}
