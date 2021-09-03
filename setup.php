<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$databaseDirectory = __DIR__ . "/threadexchangeDatabase";
require_once "SleekDB/Store.php";
//echo "SleekDB is loaded.<br />";
$peopleStore = new \SleekDB\Store("people", $databaseDirectory);
//echo "peopleStore is loaded.<br />";
$allPeople = $peopleStore->findAll();
foreach ($allPeople as $person){
      $people[$person['_id']]=$person;
}
//var_dump($people);
$threadStore = new \SleekDB\Store("thread", $databaseDirectory);
//echo "threadStore is loaded.<br />";
$manufacturerStore = new \SleekDB\Store("manufacturer", $databaseDirectory);
//echo "manufacturerStore is loaded.<br />";
require_once('require/functions.php');