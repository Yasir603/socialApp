<?php
require '../config/conn.php';
require '../vendor/__autoload';
use Location\Coordinate;
  use Location\Distance\Haversine;
  echo 'jkdjflk';
if ($_SERVER["REQUEST_METHOD"] === 'POST') {



  $STARTING_LATITUDE = $_POST['starting_latitude'];
  $ENDING_LATITUDE = $_POST['ending_latitude'];
  $STARTING_LONGITUDE = $_POST['starting_longitude'];
  $ENDING_LONGITUDE = $_POST['ending_longitude'];


      $haversineCalculator = new Haversine();

      $starting_coordinates = new Coordinate($STARTING_LATITUDE, $STARTING_LONGITUDE);
      $ending_coordinate = new Coordinate($ENDING_LATITUDE, $ENDING_LONGITUDE);

      $distance = $starting_coordinates->getDistance($ending_coordinate , $haversineCalculator);

      echo(json_encode([
          'status' => 'SUCCESS',
          'code' => '200',
          'data' => $distance
      ]));
      die();

}



?>
