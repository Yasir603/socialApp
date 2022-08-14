<?php
require '../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

  $userUid = $_POST['user_uid'];

  $query = "SELECT * FROM blocked_users where user_uid='". $userUid ."'";

  $blockedUserResult = mysqli_query($conn,$query);

  if (!result) {
    die('no user found');
  }

  if ($userUid === null) {
    die('no_user_found_with_this_uid');
  }
    $postMeta = [];

    $query="SELECT * FROM posts ";
    $result = mysqli_query($conn,$query);

    while ($post = mysqli_fetch_assoc($result)) {

      $query = "SELECT count(*) as comments FROM user_comment where post_uid='". $post['uid'] . "'";

      $res = mysqli_query($conn, $query);

      $row1 = mysqli_fetch_array($res);

      $comments = $row1['comments'];

      $query = "SELECT count(*) as likes FROM user_like where post_uid='". $post['uid'] . "'";

      $re = mysqli_query($conn, $query);

      $row2 = mysqli_fetch_array($re);

      $likes = $row2['likes'];

      $row = mysqli_fetch_assoc($blockedUserResult);

      if (count($row) === 0) {

        array_push($postMeta, [
            'uid' => $post['uid'],
            'user_uid' => $post['user_uid'],
            'image' => $post['image'],
            'text' => $post['text'],
            'created_at' => $post['created_at'],
            'Likes' => $likes,
            'Comments' => $comments
        ]);
      } else {
        while ($row = mysqli_fetch_assoc($blockedUserResult)) {

        if($row['blocked_user_uid'] !== $post['user_uid']){
          array_push($postMeta, [

              'uid' => $post['uid'],
              'user_uid' => $row['user_uid'],
              'image' => $post['image'],
              'text' => $post['text'],
              'created_at' => $post['created_at'],
              'Likes' => $likes,
              'Comments' => $comments

          ]);
        }
      }

    }
    }
   echo(json_encode([
       'status' => 'SUCCESS',
       'code' => '200',
       'data' => $postMeta
   ]));

    die();
}
?>
