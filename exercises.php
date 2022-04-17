<?php
require('connect-db.php');
require('exercise_db.php');
require('workout_db.php');
require('search-db.php');

session_start();

if(!isset($_SESSION["username"]))
{
    header("location:login.php");
}

//echo $_SESSION['username'];

$trainer = trainerCheck($_SESSION['username']);

$list_of_exercises = getAllExercises();
$exercise_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        addExercise(NULL, $_SESSION['username'], $_POST['intensity_factor'], $_POST['body_part'], $_POST['time_per_set'], $_POST['equipment'], $_POST['exercise_name']);
        $list_of_exercises = getAllExercises();
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {   
      $exercise_to_update = getExercise_byId($_POST['exercise_to_update']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
    {
      deleteExercise($_POST['exercise_to_delete']);
      $list_of_exercises = getAllExercises();
    }
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update")
    {
      updateExercise($_POST['exercise_id'], $_SESSION['username'], $_POST['intensity_factor'], $_POST['body_part'], $_POST['time_per_set'], $_POST['equipment'], $_POST['exercise_name']);
      $list_of_exercises = getAllExercises();
    }

    if(!empty($_POST['action']) && $_POST['action'] == "Search Name of Exercise") {
        $exercise_matches = searchDB_name($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Equipment Used") {
        $exercise_matches = searchDB_equipment($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Time Per Set") {
        $exercise_matches = searchDB_time($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Target Body Part") {
        $exercise_matches = searchDB_body($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Intensity Factor") {
        $exercise_matches = searchDB_intensity($_POST['search']);
    
    }
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

    <!-- bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

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
        <div>
            <a class="navbar-brand mx-3" href="dashboard.php">Dashboard</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="exercises.php">Exercises</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="view_workout.php">Workouts</a>
        </div>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome, <?php echo $_SESSION["username"]?>
            </span>
            <a href="logout.php" class="navbar-item btn btn-outline-light">Logout</a>
        </div>
    </nav>
    
    <div class="container">
    <form  action="exercises.php" method="POST">
                <div class="form-group mx-sm-3 mb-2" padding = "20 px" >
                    <center>
                        <h2 for="example"> Search our database with any of these criteria! </h2>
                    </center>
                    <input type="text" name="search" class="form-control" required/>
                </div>
            <center>
                <div class="btn-group">
                    <input class="btn btn-outline-secondary" type="submit" name="action" value="Search Name of Exercise" />
                    <input class="btn btn-outline-secondary" type="submit" name="action" value="Search Equipment Used" />
                    <input class="btn btn-outline-secondary" type="submit" name = "action" value="Search Time Per Set" />
                    <input class="btn btn-outline-secondary" type="submit" name = "action" value="Search Target Body Part" />
                    <input class="btn btn-outline-secondary" type="submit" name = "action" value="Search Intensity Factor" />
                </div>
            </center>
            
    </form>  


    <div class="table-responsive">
                    <table class="table table-striped table-hover table-light">
                        <thead>
                            <tr>
                            <th scope=" col">Name</th>
                            <th scope="col">Equipment</th>
                            <th scope="col">Time Per Set</th>
                            <th scope="col">Body Part(s)</th>
                            <th scope="col">Intensity Factor</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <?php if (is_array($exercise_matches) || is_object($exercise_matches)): ?> 
                                <?php foreach ($exercise_matches as $exercise):  ?>
                                <tr>
                                    <th scope="col"><?php echo $exercise['name']; ?></td>
                                    <td><?php echo $exercise['equipment']; ?></td>
                                    <td><?php echo $exercise['time_per_set']; ?></td>
                                    <td><?php echo $exercise['body_part']; ?></td>
                                    <td><?php echo $exercise['intensity_factor']; ?></td>
                                    
                                    <td>
                                    <?php if ($_SESSION['username'] == $exercise['username']): ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                                        data-target="#updateModal"><i class="bi-pencil"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
                                        aria-labelledby="updateModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel">Are you sure you want to
                                                        update
                                                        this
                                                        exercise?
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <br>
                                                    <p class="text-muted mx-3">Updating this exercise will update it for all
                                                        members
                                                        and trainers. This
                                                        CANNOT be undone.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="exercises.php" method="post">
                                                        <input type="submit" value="Update" name="btnAction"
                                                            class="btn btn-primary" />
                                                        <input type="hidden" name="exercise_to_update"
                                                            value="<?php echo $exercise['exercise_id'] ?>" />
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <button class="btn btn-secondary" disabled><i class="bi-pencil"></i></button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($_SESSION['username'] == $exercise['username']): ?>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal"><i class="bi-trash3"></i></button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to
                                                        delete
                                                        this
                                                        exercise?
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <br>
                                                    <p class="text-muted mx-3">
                                                        Deleting this exercise will permanently remove it
                                                        from our collection of exercises. This CANNOT be undone.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="exercises.php" method="post">
                                                        <input type="submit" value="Delete" name="btnAction"
                                                            class="btn btn-danger" />
                                                        <input type="hidden" name="exercise_to_delete"
                                                            value="<?php echo $exercise['exercise_id'] ?>" />
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <button class="btn btn-danger" disabled><i class="bi-trash3"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                    <?php endforeach; ?> 
                <?php endif ?>
            </table>          
        </div>
</div>


    <div class="container">
        <hr>
        <h1 class="display-2">Add an Exercise.</h1>
        <form name="exerciseForm" action="exercises.php" method="post">
            <div class="row mb-3 mx-2" style="padding: 5px">
                Exercise Name:
                <input placeholder="Enter exercise name" aria-describedby="nameHelp" type="text" class="form-control"
                    name="exercise_name" required
                    value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['name'] ?>" />
                <small id="nameHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">e.g.
                    Barbell Squat
                </small>
            </div>
            <div class="row mb-3 mx-2" style="padding: 5px">
                Equipment:
                <input placeholder="Enter equipment" aria-describedby="equipmentHelp" type="text" class="form-control"
                    name="equipment" required
                    value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['equipment'] ?>" />
                <small id="equipmentHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">Enter
                    your equipment in a comma-separated list. If
                    your exercise requires no equipment, enter None.
                </small>
            </div>
            <div class="row mb-3 mx-2" style="padding: 5px">
                Body Part(s):
                <input placeholder="Enter body part(s)" aria-describedby="bodypartHelp" type="text" class="form-control"
                    name="body_part" required
                    value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['body_part'] ?>" />
                <small id="bodypartHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">e.g.
                    Chest, Shoulders, Triceps or Full Body
                </small>
            </div>
            <div class="row mb-3 mx-2">
                <div class="col" style="padding: 5px">
                    Time Per Set:
                    <div class="input-group">
                        <div>
                            <input placeholder="Enter time per set" aria-describedby="timeHelp" style="width: 543px"
                                type="number" class="form-control" name="time_per_set" required
                                value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['time_per_set'] ?>" />
                            <small id="timeHelp" class="form-text text-muted"
                                style="text-align: left; padding-left: 0px">The time it takes to complete one set of
                                this exercise.
                            </small>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">seconds</span>
                        </div>
                    </div>
                </div>
                <div class="col" style="padding: 5px">
                    Intensity Factor:
                    <input placeholder="Enter intensity factor" aria-describedby="ifHelp" type="number"
                        class="form-control" name="intensity_factor" required min="1" max="5"
                        value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['intensity_factor'] ?>" />
                    <small id="ifHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">Rate the
                        intensity of your exercise from 1-5.
                    </small>
                </div>
            </div>
            <input type="hidden" name="exercise_id" required
                value="<?php if ($exercise_to_update!=null) echo $exercise_to_update['exercise_id'] ?>" />

            <?php if ($exercise_to_update==null): ?>
            <input type="submit" value="Add" name="btnAction" class="btn btn-dark mx-3 my-2 px-3" />
            <?php else: ?>
            <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-success mx-3 my-2 px-3"
                title="confirm update on exercise" />
            <a href="exercises.php" class="btn btn-secondary my-2 px-3">Cancel</a>
            <?php endif ?>
        </form>
        <hr />
        <br>
        <h1 class="col display-5">Our Exercises</h1>
        <br>  
        <center>
            <div class="table-responsive">
                <table class="lead table table-striped table-hover table-light">
                    <thead>
                        <tr>
                            <th scope=" col">Name</th>
                            <th scope="col">Equipment</th>
                            <th scope="col">Time Per Set</th>
                            <th scope="col">Body Part(s)</th>
                            <th scope="col">Intensity Factor</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <?php foreach ($list_of_exercises as $exercise):  ?>
                    <tr>
                        <th scope="col"><?php echo $exercise['name']; ?></td>
                        <td><?php echo $exercise['equipment']; ?></td>
                        <td><?php echo $exercise['time_per_set']; ?></td>
                        <td><?php echo $exercise['body_part']; ?></td>
                        <td><?php echo $exercise['intensity_factor']; ?></td>

                        <td>
                            <?php if ($_SESSION['username'] == $exercise['username']): ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                data-target="#updateModal"><i class="bi-pencil"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
                                aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Are you sure you want to
                                                update
                                                this
                                                exercise?
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <br>
                                            <p class="text-muted mx-3">Updating this exercise will update it for all
                                                members
                                                and trainers. This
                                                CANNOT be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="exercises.php" method="post">
                                                <input type="submit" value="Update" name="btnAction"
                                                    class="btn btn-primary" />
                                                <input type="hidden" name="exercise_to_update"
                                                    value="<?php echo $exercise['exercise_id'] ?>" />
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <button class="btn btn-secondary" disabled><i class="bi-pencil"></i></button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($_SESSION['username'] == $exercise['username']): ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal"><i class="bi-trash3"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to
                                                delete
                                                this
                                                exercise?
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <br>
                                            <p class="text-muted mx-3">
                                                Deleting this exercise will permanently remove it
                                                from our collection of exercises. This CANNOT be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="exercises.php" method="post">
                                                <input type="submit" value="Delete" name="btnAction"
                                                    class="btn btn-danger" />
                                                <input type="hidden" name="exercise_to_delete"
                                                    value="<?php echo $exercise['exercise_id'] ?>" />
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <button class="btn btn-danger" disabled><i class="bi-trash3"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </center>                      
    </div>
</body>

</html>