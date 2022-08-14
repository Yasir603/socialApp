<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
  if ($_SERVER["REQUEST_METHOD"] === 'POST'){

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

    if (!isset($_POST['blocked_user_uid'])) {
      die('blocked_user_uid_misising');
    }

    $query = "SELECT * FROM users where uid ='" . $_POST['blocked_user_uid'] . "'";

    $result = mysqli_query($conn,$query);

    if (!result) {
      die('no user found');
    }

    $blockuser = mysqli_fetch_assoc($result);

    if ($blockuser === null) {
      die('no_blockuser_found_with_this_uid');
    }

    $query = "SELECT * FROM blocked_users WHERE blocked_user_uid = '" . $_POST['blocked_user_uid'] . "'";

    $res = mysqli_query($conn, $query);

    if(($row = mysqli_fetch_assoc($res))){

        $row["blocked_user_uid"] = $_POST["blocked_user_uid"];

        $query="DELETE FROM blocked_users WHERE blocked_user_uid= '" . $_POST['blocked_user_uid'] . "'";
        $result = mysqli_query($conn,$query);

        echo(json_encode([
            'status' => 'SUCCESS',
            'code' => '200',
            exception => 'user_Unblocked'
        ]));

        die();
    }
    else{


           $uid = Uuid::uuid4()->toString();
           $now = Carbon::now();

           $query = " INSERT INTO blocked_users (uid,user_uid,blocked_user_uid,blocked_at) VALUES ('".$uid."','" . $user['uid'] ."','" . $blockuser['uid'] ."','".$now."')";

           $result = mysqli_query($conn,$query);

           if (!$result) {
             die('failed_to_block_user');
           }

           echo(json_encode([
               'status' => 'SUCCESS',
               'code' => '200',
               exception => 'user_blocked'
           ]));

           die();
      }
          // update user with new block state
 }
?>
