<?php
require '../config/conn.php';
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  $Profile = [];
  $query = "SELECT * FROM users ";

  $result = mysqli_query($conn , $query);

  if (!$result) {
    die('failed_to_run_user_query');
  }

  $user =  mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found');
  }
  $dt = Carbon::create(2022, 7, 31, 10, 45, 20);

   if($user['created_at'] == $dt)
   {
   array_push($Profile ,[
     'Avatar' => $user['avatar'],
     'user_name' => $user['username'],
     'email' => $user['email'],
     'Created_at' => $user['created_at']
   ]);
   }
   echo(json_encode([
       'status' => 'SUCCESS',
       'code' => '200',
       'data' => $Profile
   ]));
   die();




  $msg = $_POST['msg'];
  $subject = $_POST['subject'];
  $email = $_POST['email'];
  // use wordwrap() if lines are longer than 70 characters
  $msg = wordwrap($msg,70);

  // send email
  mail($email,$subject,$msg);

}
 ?>
