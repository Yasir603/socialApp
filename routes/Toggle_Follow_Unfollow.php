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
    die('failed_to _run_user_query');
  }

  $user = mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found_with_this_uid');
  }

  if (!isset($_POST['follower_uid'])) {
    die('follower_uid_misising');
  }

  $query = "SELECT * FROM users where uid ='" . $_POST['follower_uid'] . "'";

  $result = mysqli_query($conn,$query);

  if (!result) {
    die('no follower found');
  }

  $follow = mysqli_fetch_assoc($result);

  if ($follow === null) {
    die('no_follower_found_with_this_uid');
  }

  $uid = Uuid::uuid4()->toString();
  $now = Carbon::now();

  $query = "SELECT * FROM user_relation WHERE follower_uid = '" . $_POST['follower_uid'] . "'";

  $res = mysqli_query($conn, $query);

  if(($row = mysqli_fetch_assoc($res))){

      $row["follower_uid"] = $_POST["follower_uid"];

      $query="DELETE FROM user_relation WHERE follower_uid= '" . $_POST['follower_uid'] . "'";
      $result = mysqli_query($conn,$query);

      echo(json_encode([
          'status' => 'SUCCESS',
          'code' => '200',
          exception => 'user_Unfollowed'
      ]));
      die();

  }
  else{

  $query= "INSERT INTO user_relation (uid,user_uid,follower_uid,followed_at) VALUES ('".$uid."','" . $user['uid'] ."','".$follow['uid']."','".$now."' )";
  $result = mysqli_query($conn,$query);

  if (!$result) {
    die('failed_to_follow_user');
  }

  echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      exception => 'user_followed'
  ]));
  die();
  }

}
?>
