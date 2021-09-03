<?php

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

$manufacturers = [
 ["name" => "New Brothread"],
 ["name" => "Madeira"],
 ["name" => "Coates & Clark"],
 ["name" => "Brother"],
 ["name" => "Simthread"], 
];
$results = $manufacturerStore->insertMany($manufacturers);
var_dump($results);

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