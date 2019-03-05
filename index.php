<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>CIS 282 | Movies List</title>


    <?php 
        // the require statement enables the data from config.php to be used by the index.php file. 
        // If the require statement returns an error, then the script execution fails
        require('includes/config.php');
        // the $strSQL is a generic variable name (could be anything) that will feed the assigned SQL query to a function
        $strSQL = "SELECT
                    m.movie_id
                    , p.person_id
                    , m.title
                    , p.first_nm AS first_name
                    , p.last_nm AS last_name
                    , m.year
                    , m.release_date
                    , r.rating_nm AS rating
                    , m.post_credit
                    , m.gross_box_office AS gate
                    , l.language_nm AS language
                    , m.rt_rating AS rotten_rating

                    FROM 
                    cis282movies.movies m
                    , cis282movies.persons p
                    , cis282movies.ratings r
                    , cis282movies.languages l


                    WHERE 
                    m.director_id = p.person_id
                    AND m.rating_id = r.ratings_id
                    AND m.language_id = l.languange_id

                    ORDER BY m.movie_id

                    "; // you need a variable and put the query in double quotes

        // Step 1 - GET RESULTS: 
        // the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
        // the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
        // the second argument is the querry you want to execute and that comes from the $strSQL variable you previously established, but you could enter that entire string in place of the variable
        // the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
        $result = mysqli_query($connect, $strSQL); // this should be the same for all queries based on the strSQL that you send it

        // Step 2 - FETCH DATA: 
        // the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
        // the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
        // the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
        // you store the return value in a new variable that you can name whatever is descriptive for your use case
        // IMPORTANT NOTE --> this variable, $movies, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments
        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC); // you will rename your variable for each specific query

        // Step 3 - FREE RESULT: 
        // the mysqli_free_result() function fetches rows from a result-set, then frees the memory associated with the result
        // the one required argument to pass is the $result obtained via Step 1 - GET RESULTS using mysqli_query()
        // this function has no return value so you don't assign it to a variable
        mysqli_free_result($result);

        // Step 4 - CLOSE CONNECTION: 
        // myslqi_close() will close a previously opended database connection.
        // the function takes one argument and that is the same $connection data path you sent to it via myqsli_query() in step 1 - GET RESULTS
        // the function will return TRUE on success and FALSE on failure
        mysqli_close($connect);
    ?>
</head>
<body>
    <div class="container-fluid main-title">
        <div class="row">
            <div class="col">
                <h1>Movie List</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid main-headers">
        <div class="row">
        <!-- NOTE: the bootstrap grid is 12x wide, e.g. the sum of all columns is: col-1 + col-3 + col-2 + col-2 + col-2 + col-2 = 12-->
            <div class="col-1"></div>
            <div class="col-3">Title</div>
            <div class="col-2">Release Date</div>
            <div class="col-2">Director</div>
            <div class="col-2">Ratings</div>                                                
            <div class="col-2">Rotten Tomatoes</div>
        </div>
    </div>

    <!--    the foreach loop takes $movies from line 60 in the querry above and iterates through each line; temporarily holding each individual
            record in the $row variable and used to access each key:value pair.  They key is $row<'insert the SELECT column name or 'as' name'> 
            and the value returned is the field of that column -->
    <?php foreach($movies as $row) { ?>
    <!-- NOTE: the bootstrap grid is 12x wide, e.g. the sum of all columns is: col-1 + col-3 + col-2 + col-2 + col-2 + col-2 = 12-->
    <div class="container-fluid list">
        <div class="row">
            <!--    the <a> tag uses php to append the appropriate value into the GET request that is then passed to the appropriate
                    movie_model.php or person_model.php file via the movie.php or person.php include<> staement.
                    There, the value is used to querry the specific movie / person requested -->
            <div class="col-1 text-center"><a href="movie.php?movie=<?php echo $row['movie_id']; ?>"><?php echo $row['movie_id']; ?></a></div>
            <div class="col-3"><a href="movie.php?movie=<?php echo $row['movie_id']; ?>"><?php echo $row['title']; ?></a></div>
            <div class="col-2"><?php echo $row['release_date']; ?></div>
            <div class="col-2"><a href="person.php?person=<?php echo $row['person_id']; ?>"><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></a></div>
            <div class="col-2"><?php echo $row['rating']; ?></div>
            <div class="col-2"><?php echo $row['rotten_rating']; ?></div>
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