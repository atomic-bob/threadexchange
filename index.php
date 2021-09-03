<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$databaseDirectory = __DIR__ . "/threadexchangeDatabase";
require_once "SleekDB/Store.php";
echo "SleekDB is loaded.<br />";

$peopleStore = new \SleekDB\Store("people", $databaseDirectory);
echo "peopleStore is loaded.<br />";

$allPeople = $peopleStore->findAll();
foreach ($allPeople as $person){
      $people[$person['_id']]=$person;
}
//var_dump($people);

$threadStore = new \SleekDB\Store("thread", $databaseDirectory);
echo "threadStore is loaded.<br />";

$manufacturerStore = new \SleekDB\Store("manufacturer", $databaseDirectory);
echo "manufacturerStore is loaded.<br />";

/*
$person = [
 "name" => "Test User",
 "email" => "kennedy7@gmail.com",
 "password" => "",
 "business" => "PatchCube?",
 "location" => [
   "timezone" => "EST",
   "country" => "US"
 ]
];
$results = $peopleStore->insert($person);
//var_dump($results);
*/
/*
$manufacturers = [
 ["name" => "New Brothread"],
 ["name" => "Madeira"],
 ["name" => "Coates & Clark"],
 ["name" => "Brother"],
 ["name" => "Simthread"], 
];
$results = $manufacturerStore->insertMany($manufacturers);
var_dump($results);
*/
/*
$threads = [
 ["desc" => "N210 Yellowish White",
 "price" => "2",
 "currency" => "USD",
 "manufacturerID" => 1,
 "userID" => 1],
 ["desc" => "007 Blue",
 "price" => "2.50",
 "currency" => "USD",
 "manufacturerID" => 1,
 "userID" => 1],
];
$results = $threadStore->insertMany($threads);
var_dump($results);
*/



//get threads with user and manu data associated
$searchQuery = "007";
$threadsSearchWithUsersandManufacturers = $threadStore->createQueryBuilder()
  //->where([ "desc", "=", "007 Blue" ]) // filter to blue
  ->search(["desc"], $searchQuery)
  ->orderBy(["searchScore" => "DESC"]) // sort result
  ->except(["searchScore"]) // exclude field from result
  ->join(function($thread) use ($peopleStore) { // add person data
    return $peopleStore->findById($thread['userID']);
  }, "user")
    ->join(function($thread) use ($manufacturerStore) { //add manufacturer data
    return $manufacturerStore->findById($thread['manufacturerID']);
  }, "manufacturer")
  ->getQuery()
  ->fetch();
var_dump($threadsSearchWithUsersandManufacturers);

//get threads with user and manu data associated
$allThreadsWithUsersandManufacturers = $threadStore->createQueryBuilder()
  ->join(function($thread) use ($peopleStore) { // add person data
    return $peopleStore->findById($thread['userID']);
  }, "user")
    ->join(function($thread) use ($manufacturerStore) { //add manufacturer data
    return $manufacturerStore->findById($thread['manufacturerID']);
  }, "manufacturer")
  ->getQuery()
  ->fetch();
var_dump($allThreadsWithUsersandManufacturers);