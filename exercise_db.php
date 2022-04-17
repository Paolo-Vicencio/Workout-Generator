<?php

function addExercise($exercise_id, $username, $intensity, $bodyPart, $time, $equipment, $name)
{
	// db handler
	global $db;

	// write sql
	$query = "insert into exercise values(NULL,:username, :intensity, :bodyPart, :time, :equipment, :name)";

	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':intensity', $intensity);
	$statement->bindValue(':bodyPart', $bodyPart);
	$statement->bindValue(':time', $time);
	$statement->bindValue(':equipment', $equipment);
	$statement->bindValue(':name', $name);


	$statement->execute();
	
	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getNextExerciseId()
{
	// db handler
	global $db;

	// write sql
	$query = "select max(exercise_id) from exercise";

	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();   

	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
	return $result;
}

function getAllExercises()
{
	global $db;
	$query = "select * from exercise";
	$statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result 
	
	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getExercise_byId($exercise_id)
{
	global $db;
	$query = "select * from exercise where exercise_id = :exercise_id";
	// "select * from exercise where name = $name";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

function getExercise_byUsername($username) {
	global $db;
	$query = "select * from exercise where username = :username";
	// "select * from exercise where name = $name";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;
}

function updateExercise($exercise_id, $username, $intensity, $bodyPart, $time, $equipment, $name)
{
	global $db;
	$query = "update exercise set intensity_factor=:intensity, name =:name, body_part=:bodyPart, time_per_set=:time, equipment=:equipment, name=:name where exercise_id=:exercise_id";
	$statement = $db->prepare($query); 
	$statement->bindValue(':intensity', $intensity);
	$statement->bindValue(':bodyPart', $bodyPart);
	$statement->bindValue(':time', $time);
	$statement->bindValue(':equipment', $equipment);
	$statement->bindValue(':name', $name);
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->bindValue(':username', $username);
	$statement->execute();
	$statement->closeCursor();
}

function deleteExercise($exercise_id)
{
	global $db;
	$query = "delete from exercise where exercise_id=:exercise_id";
	$statement = $db->prepare($query); 
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->execute();
	$statement->closeCursor();
}


function addMetrics($exercise_id, $metric_id)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into metrics values(:exercise_id, NULL)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

function addCardioMetrics($exercise_id, $metric_id, $distance, $duration)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into cardioMetrics values(:exercise_id, NULL, :distance, :duration)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
	$statement->bindValue(':distance', $distance);
    $statement->bindValue(':duration', $duration);

    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

function addLiftingMetrics($exercise_id, $metric_id, $reps, $sets)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into liftingMetrics values(:exercise_id, NULL, :reps, :sets)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
	$statement->bindValue(':reps', $reps);
    $statement->bindValue(':sets', $sets);

    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}


?>