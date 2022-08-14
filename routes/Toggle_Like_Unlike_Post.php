<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  if (!isset($_POST['user_uid'])) {
    die('user_uid_misising');
  }

  $query = "SELECT * FROM users where uid ='" . $_POST['user_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no user found');
  }

  $user = mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found_with_this_uid');
  }

  if (!isset($_POST['post_uid'])) {
    die('post_uid_misising');
  }

  $query = "SELECT * FROM posts where uid ='" . $_POST['post_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no post found');
  }

  $post = mysqli_fetch_assoc($result);

  if ($post === null) {
    die('no_post_found_with_this_uid');
  }


  $query = "SELECT * FROM user_like WHERE post_uid = '" . $_POST['post_uid'] . "'";

  $res = mysqli_query($conn, $query);

  if(($row = mysqli_fetch_assoc($res))){

      $row["post_uid"] = $_POST["post_uid"];

      $query="DELETE FROM user_like WHERE post_uid= '" . $_POST['post_uid'] . "'";
      $result = mysqli_query($conn,$query);

      echo(json_encode([
          'status' => 'SUCCESS',
          'code' => '200',
          exception => 'user_Unliked'
      ]));
      die();

  }
  else{
    $uid = Uuid::uuid4()->toString();
    $now = Carbon::now();

    $liked = $_POST['like'];

    $query= "INSERT INTO user_like (uid,user_uid,post_uid,liked,liked_at) VALUES ('".$uid."','" . $user['uid'] ."','".$post['uid']."','".$liked."','".$now."' )";
    $result = mysqli_query($conn,$query);

    if (!$result) {
      die('failed_to_like_Post');
    }

    echo(json_encode([
        'status' => 'SUCCESS',
        'code' => '200',
        exception => 'Post_liked'
    ]));

    die();
  }



}
?>
