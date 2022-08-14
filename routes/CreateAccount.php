<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $extArray = ['doc', 'docx', 'xlsx', 'jpeg', 'jpg', 'png', 'pdf'];

    $fileInfo = pathinfo($_FILES['avatar']['name']);

    $tmp = explode(".", $_FILES['avatar']['name']);

    $size = ($_FILES["avatar"]["size"]/10).'MB';

    $newName = time() . rand(0, 99999) . "." . end($tmp);
    if ($_FILES["avatar"]["size"] > 10485760) {

        echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));
    }
    else {
          if (! move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../data/avatar/' . $newName)) {
          echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
          die();
          }
    }

    if(!isset($_POST["username"])){
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'username_feild_is_required'
            ]));
            die();
    }

    if(!isset($_POST["email"])){
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'email_feild_is_required'
            ]));
            die();
    }

    if(!isset($_POST["password"])){
            echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'password_feild_is_required'
            ]));
            die();
    }



          $username= $_REQUEST["username"];
          $email= $_REQUEST["email"];
          $password= $_REQUEST["password"];
          $avatar= $_REQUEST["avatar"];

          $uid = Uuid::uuid4()->toString();
          $now = Carbon::now();
          $date1 = Carbon::create(2021,10, 25, 12, 48, 00);
          $date5 = Carbon::createFromTimestamp(1633703084);
          $date3 = Carbon::createFromDate(2018, 8, 14);
          $time = $now->addDays(90);


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

              $reg_users = "INSERT into users (uid,username,email,password,avatar,created_at) VALUES ('".$uid."','".$username."','".$email."','".$password."','".$newName."','".$time."')";

              $result = mysqli_query($conn, $reg_users);

              if($result> 0){

                echo(json_encode([
                'status' => 'sucess',
                'code' => '200',
                exception => 'User_data__is_submitted'
                ]));
              }
              else{
                echo(json_encode([
                'status' => 'failed',
                'code' => '200',
                exception => 'failed_to_insert_User'
                ]));
              }
          }
}
?>
