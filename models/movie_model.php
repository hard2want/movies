<?php 
// the $_GET['value'] is passed as the value within the php code from the <a> tag on lines 106 or 107 of the index.php file 
$movieId = $_GET["movie"];

// get movie details
        $strSQL = "SELECT
        m.movie_id
        , p.person_id
        , m.title
        , p.first_nm AS first_name
        , p.last_nm AS last_name
        , m.year
        , m.release_date
        , m.description
        , m.duration
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
        AND m.movie_id = $movieId

        ORDER BY m.movie_id

        "; // be sure to assign the $movieId from the $_GET['value'] on line 3 to its appropriate table column like it is on line 32

// Step 1 - GET RESULTS: 
// the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
// the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
// the second argument is the query you want to execute and that comes from the $strSQL variable you declared on line 6 above, but you could enter that entire string in place of the variable
// the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
$result = mysqli_query($connect, $strSQL); // this should be the same for all queries based on the strSQL that you send it

// Step 2 - FETCH DATA: 
// the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
// the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
// the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
// you store the return value in a new variable that you can name whatever is descriptive for your use case
// IMPORTANT NOTE --> this variable, $movieBio, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments in movie.php line 18
$movieBio = mysqli_fetch_all($result, MYSQLI_ASSOC); // you will rename your variable for each specific query

// NOTE - all of the above is one query but your connection is still open so you can still perform a second, third, etc. query

// Now, get cast data that will need to be added via a second query

//Get Cast Details with a new $strSQL query statement
$strSQL = "SELECT
c.movie_id
, p.person_id
, p.first_nm as first_name
, p.last_nm as last_name
, c.character_nm as character_name
, r.role
FROM 
cis282movies.movies m
, cis282movies.persons p
, cis282movies.casts c
, cis282movies.roles r
WHERE
c.role_id = r.role_id
AND c.person_id = p.person_id
AND m.movie_id = c.movie_id
AND m.movie_id = $movieId

ORDER BY c.role_id
"; // be sure to assign the $movieId from the $_GET['value'] on line 3 to its appropriate table column like it is on line 74

// Step 1 - GET RESULTS: 
// the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
// the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
// the second argument is the query you want to execute and that comes from the $strSQL variable you declared on line 6 above, but you could enter that entire string in place of the variable
// the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
// NOTE: the $result variable can be reused and now holds the result from the second query as your first results are saved in $movieBio
$result = mysqli_query($connect, $strSQL);

// Step 2 - FETCH DATA: 
// the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
// the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
// the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
// you store the return value in a new variable that you can name whatever is descriptive for your use case
// IMPORTANT NOTE --> this variable, $movieCast, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments in movie.php line 71
$movieCast = mysqli_fetch_all($result, MYSQLI_ASSOC);


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