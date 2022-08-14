<?php
require '../config/conn.php';
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $extArray = ["mp4","avi","3gp","mov","mpeg"];

    $fileInfo = pathinfo($_FILES['video']['name']);

    $tmp = explode(".", $_FILES['video']['name']);

    $size = ($_FILES["video"]["size"]/10).'MB';

    $newName = time() . rand(0, 99999) . "." . end($tmp);
    if ($_FILES["video"]["size"] > 10485760) {

        echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));
    }
    else {
          if (! move_uploaded_file($_FILES['video']['tmp_name'], __DIR__ . '/../data/videos/' . $newName)) {
          echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
          die();
          }
    }

    if (!isset($_POST['user_uid'])) {
      die('user_uid_misising');
    }
    $text = $_POST['text'];
    $query = "SELECT * FROM users where uid ='" . $_POST['user_uid'] . "'";

    $result = mysqli_query($conn,$query);

    if (!result) {
      die('no user found');
    }

    $user = mysqli_fetch_assoc($result);

    if ($user === null) {
      die('no_user_found_with_this_uid');
    }

    $uid = Uuid::uuid4()->toString();
    $now = Carbon::now();

    $query= "INSERT INTO videos (uid,user_uid,video,uploaded_at) VALUES ('".$uid."','" . $user['uid'] ."','".$newName."','".$now."' )";
    $result = mysqli_query($conn,$query);

    if (!$result) {
      die('failed_to_upload_video');
    }

    echo(json_encode([
        'status' => 'SUCCESS',
        'code' => '200',
        exception => 'video_uploaded'
    ]));

    die();
}


 ?>
