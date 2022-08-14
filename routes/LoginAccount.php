<?php
require '../config/conn.php';

   if ($_SERVER["REQUEST_METHOD"] === 'POST') {

     $email= $_REQUEST["email"];
     $password= $_REQUEST["password"];



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


     $queryLogin = "SELECT * FROM users WHERE email = '".$email."'";

     $res = mysqli_query($conn, $queryLogin);

     if(($row = mysqli_fetch_assoc($res))){

        $row["email"] == $email;
     }
     else{
        echo(json_encode([
            'status' => 'failed',
            'code' => '200',
            exception => 'invalid_email'
        ]));
        die();

    }

     $queryLogin = "SELECT * FROM users WHERE password = '".$password."'";

     $res = mysqli_query($conn, $queryLogin);

     if(($row = mysqli_fetch_assoc($res))){

        $row["password"] = $password;
     }
     else{
        echo(json_encode([
            'status' => 'failed',
            'code' => '200',
            exception => 'invalid_password'
        ]));
        die();
     }

     $queryLogin = "SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."' ";

     $res = mysqli_query($conn, $queryLogin);

     if(mysqli_num_rows($res) > 0) {

        $User = [];

        while ($row = mysqli_fetch_assoc($res)) {

            array_push($User, [
                'uid'      => $row['uid'],
                'username' => $row['username'],
                'email'    => $row['email'],
                'password' => $row['password'],
                'avatar'   => $row['avatar'],
                'created_at' => $row['created_at']

              ]);

          }

        echo(json_encode([
            'status' => 'SUCCESS',
            'code' => '200',
            'data' => $User
        ]));

        die();
     }
   }
?>
