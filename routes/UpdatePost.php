<?php
require '../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST'){
$extArray = ['doc', 'docx', 'xlsx', 'jpeg', 'jpg', 'png', 'pdf'];

$fileInfo = pathinfo($_FILES['newimage']['name']);

$tmp = explode(".", $_FILES['newimage']['name']);

$size = ($_FILES["newimage"]["size"]/10).'MB';

$newimgName = time() . rand(0, 99999) . "." . end($tmp);
if ($_FILES["newimage"]["size"] > 10485760) {
    echo json_encode(array('status' => 'error', 'size' => 'File size is greater then 10 MB TRY AGAIN.'));

}
else {
    if (! move_uploaded_file($_FILES['newimage']['tmp_name'], __DIR__ . '/../data/updatepost/' . $newimgName)) {
    echo json_encode(array('status' => 'error', 'msg' => 'File could not be uploaded.'));
    die();
    }

}

        $path = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/socialapp/data/updatepost/' . $newimgName;
        var_dump($path);

        if (!isset($_POST['user_uid'])) {
          die('misising');
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

        $text = $_POST['text'];

        $query = "UPDATE posts
                  SET image = '$newimgName', text = '$text'
                  WHERE  user_uid= '" .$user["uid"]. "'";

        $result = mysqli_query($conn, $query);

        if($result> 0){
              echo(json_encode([
                  'status' => 'sucess',
                  'code' => '200',
                  exception => 'Post_is_updated'
              ]));
        }
         else{
              echo(json_encode([
                 'status' => 'failed',
                 'code' => '200',
                  exception => 'failed_to_update_Post'
              ]));
         }
}
?>
