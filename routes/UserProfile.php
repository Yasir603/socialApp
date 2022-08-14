<?php
require '../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {


  if (!isset($_POST['user_uid'])) {
    die('user_uid_missing');
  }

  $query = "SELECT * FROM users where uid='". $_POST['user_uid'] . "'";

  $result = mysqli_query($conn , $query);

  if (!$result) {
    die('failed_to_run_user_query');
  }

  $user =  mysqli_fetch_assoc($result);

  if ($user === null) {
    die('no_user_found_with_this_uid');
  }


  $avatar = $user['avatar'];

  $query = "SELECT count(*) as Following FROM user_relation where user_uid='". $_POST['user_uid'] . "'";

  $result = mysqli_query($conn , $query);
  $row = mysqli_fetch_array($result);

  $Following = $row['Following'];



  $query = "SELECT count(*) as Posts FROM posts where user_uid='". $_POST['user_uid'] . "'";

  $result = mysqli_query($conn , $query);
  $row = mysqli_fetch_array($result);

  $Posts = $row['Posts'];




  $result = mysqli_query($conn , $query);
  $row = mysqli_fetch_array($result);

  $Posts = $row['Posts'];

  $Profile =[];
  $userpostsMeta = [];

  $query = "SELECT * FROM posts where user_uid='". $_POST['user_uid'] . "'";
  $result = mysqli_query($conn , $query);

  while($data = mysqli_fetch_assoc($result)){

    $query = "SELECT count(*) as comments FROM user_comment where post_uid='". $data['uid'] . "'";

    $res = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($res);

    $comments = $row['comments'];

    $query = "SELECT count(*) as likes FROM user_like where post_uid='". $data['uid'] . "'";

    $re = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($re);

    $likes = $row['likes'];

  array_push($userpostsMeta, [


    'post_uid' => $data['uid'],
    'user_uid' => $data['user_uid'],
    'Image' =>   $data['image'],
    'Text' => $data['text'],
    'Created_at' => $data['created_at'],
    'Likes' => $likes,
    'Comments' => $comments
  ]);
}

  array_push($Profile ,[
    'Avatar' => $user['avatar'],
    'user_name' => $user['username'],
    'Following' => $Following,
    'Posts' => $Posts,
    'UserPosts' => $userpostsMeta
  ]);

  echo(json_encode([
      'status' => 'SUCCESS',
      'code' => '200',
      'data' => $Profile
  ]));
  die();

}


 ?>
