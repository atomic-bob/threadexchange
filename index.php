<html>
<head>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

</head>
<body>
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
// $searchQuery = "007";
// $threadsSearchWithUsersandManufacturers = $threadStore->createQueryBuilder()
//   //->where([ "desc", "=", "007 Blue" ]) // filter to blue
//   ->search(["desc"], $searchQuery)
//   ->orderBy(["searchScore" => "DESC"]) // sort result
//   ->except(["searchScore"]) // exclude field from result
//   ->join(function($thread) use ($peopleStore) { // add person data
//     return $peopleStore->findById($thread['userID']);
//   }, "user")
//     ->join(function($thread) use ($manufacturerStore) { //add manufacturer data
//     return $manufacturerStore->findById($thread['manufacturerID']);
//   }, "manufacturer")
//   ->getQuery()
//   ->fetch();
// var_dump($threadsSearchWithUsersandManufacturers);

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
  echo '<div class="container">';
foreach($allThreadsWithUsersandManufacturers as $t){
  echo '
  <div class="row">
    <div class="col">';
      echo $t['desc'];
    echo '</div>
    <div class="col">
      ';
      echo number_format($t['price'],2).' '.$t['currency'];
    echo '
    </div>
    <div class="col">
      <a href=#>View Contact Info</a>
    </div>
  </div>
  ';
}
echo '</div>';