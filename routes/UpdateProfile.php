<?php
require "../config/conn.php";

use Carbon\Carbon;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  $username= $_REQUEST["username"];
  $email= $_REQUEST["email"];
  $password= $_REQUEST["password"];

  if (!isset($_POST['user_uid'])) {
    die('misising');
  }

  $query = "SELECT * FROM users where uid ='" . $_POST['user_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no user found');
  }


  $now = Carbon::now();

  $user = mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found_with_this_uid');
  }
  
  if(!isset($_POST["email"])){
          echo(json_encode([
              'status' => 'failed',
              'code' => '200',
              exception => 'email_feild_is_required'
          ]));
          die();
  }

  $query = "SELECT * FROM users WHERE email = '".$email."'";
  $res = mysqli_query($conn, $query);

  if(($row = mysqli_fetch_assoc($res))){

      $row["email"] = $_POST["email"];

      echo(json_encode([
          'status' => 'failed',
          'code' => '200',
          exception => 'user_email_already_exist'
      ]));

      die();
  }
  else{

    $query = "UPDATE users
              SET username = '$username', email = '$email' , password = '$password' , updated_at = '$now'
              WHERE  uid= '" .$user["uid"]. "'";

    $result = mysqli_query($conn, $query);

    if($result> 0){
          echo(json_encode([
              'status' => 'sucess',
              'code' => '200',
              exception => 'User_data_is_updated'
          ]));
    }
     else{
          echo(json_encode([
             'status' => 'failed',
             'code' => '200',
              exception => 'failed_to_update_user_data'
          ]));
     }
  }

}


 ?>
