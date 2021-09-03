<?php
function getThreadList($search=false){
	global $threadStore, $peopleStore, $manufacturerStore;

	if ($search){
		$setItUp = $threadStore->createQueryBuilder()
		->search(["desc"], $search)
  		->orderBy(["searchScore" => "DESC"]) // sort result
  		->except(["searchScore"]); // exclude field from result
	}
	else{
		$setItUp = $threadStore->createQueryBuilder();
	}

//get threads with user and manu data associated
  $bigList = $setItUp->join(function($thread) use ($peopleStore) { // add person data
    return $peopleStore->findById($thread['userID']);
  }, "user")
    ->join(function($thread) use ($manufacturerStore) { //add manufacturer data
    return $manufacturerStore->findById($thread['manufacturerID']);
  }, "manufacturer")
  ->getQuery()
  ->fetch();

  if($bigList) return $bigList;
  else return false;
}

function showHeader($title, $search=false){
	echo '<html>
<head>
<title>'.$title.'</title>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

</head>
<body>
  <div class="container">
  <h1>'.$title.'</h1>';
  echo '<div class="row gx-5"><div class="col">';
  echo "<input class='form-control form-control-lg' type='text' placeholder='Search for something...' aria-label='.form-control-lg example'><br>";
  echo "</div><div class='col'>";
  if($search){ echo 'Searching for "'.$search.'" <a href="index.php">Clear</a>';}
  echo "</div></div>";
}

function showFooter(){
	echo '</div></body></html>';
}