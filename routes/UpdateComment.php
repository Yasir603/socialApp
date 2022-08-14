<?php
require "../config/conn.php";

use Carbon\Carbon;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  $text= $_REQUEST["text"];

  if (!isset($_POST['user_uid'])) {
    die('user_uid_misising');
  }

  $query = "SELECT * FROM user_comment where user_uid ='" . $_POST['user_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no user found');
  }


  $now = Carbon::now();

  $user = mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_comment_found_with_this_uid');
  }

  if (!isset($_POST['post_uid'])) {
    die('post_uid_misising');
  }
  $query = "SELECT * FROM user_comment where post_uid ='" . $_POST['post_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no post found');
  }

  $post = mysqli_fetch_assoc($result);

  if ($post === null) {
    die('no_post_found_with_this_uid');
  }

    $query = "UPDATE user_comment
              SET text = '$text' , updated_at = '$now'
              WHERE  post_uid= '" .$post["post_uid"]. "'";

    $result = mysqli_query($conn, $query);

    if($result> 0){
          echo(json_encode([
              'status' => 'sucess',
              'code' => '200',
              exception => 'User_Comment_is_updated'
          ]));
    }
     else{
          echo(json_encode([
             'status' => 'failed',
             'code' => '200',
              exception => 'failed_to_update_user_Comment'
          ]));
     }


}


 ?>
