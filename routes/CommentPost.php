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

  $uid = Uuid::uuid4()->toString();
  $now = Carbon::now();

  $text = $_POST['text'];

  $query= "INSERT INTO user_comment(uid,user_uid,text,post_uid,comment_at) VALUES ('".$uid."','" . $user['uid'] ."','".$text."','". $post['uid'] ."','".$now."' )";
  $result = mysqli_query($conn,$query);

  if (!$result) {
    die('failed_to_comment_Post');
  }

  echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      exception => 'Post_Commented'
  ]));

  die();
}
?>
