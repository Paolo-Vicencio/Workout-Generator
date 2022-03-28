<!-- this php code checks if the user is logged in, if they aren't it redirects them back to the login page. -->
<?php
require('connect-db.php');
require('exercise_db.php');

$list_of_exercises = getAllExercises();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        addExercise($_POST['id'], $_POST['username'], $_POST['name'], $POST['equipment'], $POST['time_per_set'], $POST['body_part'], $POST['intensity_factor']);
        $list_of_exercises = getAllExercises();
    }

}
    session_start();


    if(!isset($_SESSION["username"]))
    {
        header("location:login.php");
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 
    Bootstrap is designed to be responsive to mobile.
    Mobile-first styles are part of the core framework.
    
    width=device-width sets the width of the page to follow the screen-width
    initial-scale=1 sets the initial zoom level when the page is first loaded   
    -->

    <title>Workout Generator</title>

    <!-- 3. link bootstrap -->
    <!-- if you choose to use CDN for CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- you may also use W3's formats -->
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

    <!-- 
    Use a link tag to link an external resource.
    A rel (relationship) specifies relationship between the current document and the linked resource. 
    -->

    <!-- If you choose to use a favicon, specify the destination of the resource in href -->
    <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

    <!-- if you choose to download bootstrap and host it locally -->
    <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

    <!-- include your CSS -->
    <!-- <link rel="stylesheet" href="custom.css" />  -->
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand mx-3" href="dashboard.php">Workout Generator</a>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome, <?php echo $_SESSION["username"] ?>
            </span>
            <a href="logout.php" class="navbar-item btn btn-outline-light">Logout</a>
        </div>
    </nav>
    <div class="container">
    <input id="searchBar" type="text" placeholder="Search for an exercise">
    <style type="text/css">
        
  #searchBar{
  float: center;
  padding: 6px;
  margin-top: 8px;
  margin-right: px;
  font-size: 20px;
  }
        </style>
        <p>Search criteria would go here once we integrate it</p>
        <hr>
        <h1 >Add an Exercise.</h1>
            <form name="exerciseForm" action="exercises.php" method="post">
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Exercise Name:
                    <input type="text" class="form-control" name="exercise_name" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Equipment:
                    <input type="text" class="form-control" name="equipment" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Time Per Set:
                    <input type="text" class="form-control" name="time_per_set" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Body Part:
                    <input type="text" class="form-control" name="body_part" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Intensity Factor:
                    <input type="text" class="form-control" name="intensity_factor" required />
                </div>
                <input type="submit" value="Add" name="btnAction" class="btn btn-dark" style="margin: 15px" />
                <hr style="margin: 15px">
                </form>

                <hr/>
<h2>List of Exercises</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th >Exercise Name</th>        
    <th >Equipment</th>        
    <th >Time Per Set</th> 
    <th >Body Part</th>
    <th >Intensity Factor</th> 
  </tr>
  </thead>
  <?php foreach ($list_of_exercises as $exercise):  ?>
  <tr>
    <td ><?php echo $exercise['name']; ?></td>
    <td><?php echo $exercise['equipment']; ?></td>
    <td><?php echo $exercise['time_per_set']; ?></td>
    <td><?php echo $exercise['body_part']; ?></td>
    <td><?php echo $exercise['intensity_factor']; ?></td>
  </tr>
  <?php endforeach; ?>

  
  </table>
    </div>
</body>

</html>
