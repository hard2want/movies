<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/styles.css">

        <?php 
            // REQUIRE: the access path to the config.php file to get to your database access arguments that are used by your person_model.php file
            require('includes/config.php');
           // REQUIRE: the person_model.php that holds your querry statements and returns the each querry's values for presentation
            require('models/person_model.php');
        ?>
        <!-- Note, the $person data is coming from line 39 after the first query of the person_model.php file -->
        <?php foreach ($person as $row) { ?>
        <title>CIS 282 | <?php echo $row['first_nm'] ; ?> <?php echo $row['last_nm']; ?> </title>
        <?php }; ?>
    </head>

    <body>
        <div class="container-fluid main-title">
            <div class="row">
                <div class="col">
                    <a href="http://3.82.206.20/movies/">
                        <h1>The Ultimate Movie Database</h1>
                    </a>                
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row cast">
                <div class="col-4 offset-md-1">
                    <h2>Actor Info</h2>
                </div>
            </div>
        </div>
        <!-- Note, the $person is coming from line 39 after the first query of the person_model.php file -->
        <?php // var_dump($person); ?>
        <?php foreach($person as $row) { ?>
            <div class="container-fluid">
                <div class="row cast">
                    <div class="col-4 offset-md-1">
                        <h4>
                            Name: 
                            <?php echo $row['first_nm']; ?> <?php echo $row['last_nm']; ?>
                        </h4>
                    </div>
                    <div class="col-5">
                        <h4>Gender: <?php echo $row['gender']; ?></h4> 
                    </div> 
                </div>
            </div>
            <div class="container-fluid">
                <div class="row cast">
                    <div class="col-4 offset-md-1">
                        <h4>Birth date: <?php echo $row['dob']; ?></h4> 
                    </div> 
                    <div class="col-5">
                        <h4>Country of birth: <?php echo $row['cob']; ?></h4> 
                    </div> 
                </div>
            </div>
        <?php 
        }
        ?>

        <?php // var_dump($role); ?>

        <div class="container-fluid">
                <div class="row cast">
                    <div class="col-4 offset-md-1">
                        <h2>Movie</h2>
                    </div>
                    <div class="col-7">
                        <h2>Character</h2> 
                    </div> 
                </div>
            </div>

        <!-- Note, the $role data is coming from line 81 after the second query of the person_model.php file -->
        <?php foreach($role as $row) { ?>
            <div class="container-fluid">
                <div class="row cast">
                    <div class="col-4 offset-md-1">
                        <h4>
                            <a href="movie.php?movie=<?php echo $row['movie_id']; ?>">
                            <?php echo $row['title']; ?>
                            </a>
                        </h4>
                    </div>
                    <div class="col-7">
                        <h4><?php echo $row['character_nm']; ?></h4> 
                    </div> 
                </div>
            </div>
        <?php 
        }
        ?>
    <!-- Note, the $director data is coming from line 118 after the third query of the person_model.php file -->
    <?Php // var_dump($director); ?>
    <?php foreach($director as $row) { ?>
            <div class="container-fluid">
                <div class="row cast">
                    <div class="col-4 offset-md-1">
                        <h4>
                            <a href="movie.php?movie=<?php echo $row['movie_id']; ?>">
                            <?php echo $row['title']; ?>
                            </a>
                        </h4>
                    </div>
                    <div class="col-7">
                        <h4><?php echo "Director"; ?></h4> 
                    </div> 
                </div>
            </div>
        <?php 
        }
        ?>



        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>