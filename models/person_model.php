<?php 
// the $_GET['value'] is passed as the value within the php code from the <a> tag on line 109 of the index.php file or lines 42 or 76 of the person.php file
// the GET request collect the value from the key/value pair set up within the <a> link and assigns it to the variable $personId
$personId = $_GET["person"]; 

// Query the individual person info
$strSQL = "SELECT p.first_nm
, p.last_nm
, p.dob
, p.dod
, co.country_nm as cob
, g.description as gender

FROM
cis282movies.persons p
, cis282movies.countries co
, cis282movies.genders g

WHERE
 p.person_id = $personId
 AND co.country_id = p.country_id
 AND p.gender_id = g.gender_id
 "; // be sure to assign the $personId from the $_GET['value'] on line 4 to its appropriate table column like it is on line 20

// Step 1 - GET RESULTS: 
// the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
// the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
// the second argument is the query you want to execute and that comes from the $strSQL variable you declared on line 7 above, but you could enter that entire string in place of the variable
// the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
$result = mysqli_query($connect, $strSQL); // this should be the same for all queries based on the strSQL that you send it

// Step 2 - FETCH DATA: 
// the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
// the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
// the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
// you store the return value in a new variable that you can name whatever is descriptive for your use case
// IMPORTANT NOTE --> this variable, $person, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments in person.php line 17
// you will rename your variable for each specific query
$person = mysqli_fetch_all($result, MYSQLI_ASSOC); 


// NOTE - all of the above is one query but your connection is still open so you can still perform a second, third, etc. query

// Now, get actor's movies and character played data that will need to be added via a second query

// Query the movies and characters each actor portrayed

$strSQL = "SELECT
m.movie_id
, m.title
, c.character_nm

FROM
cis282movies.movies m
, cis282movies.casts c
, cis282movies.persons p

WHERE
m.movie_id = c.movie_id
AND c.person_id = p.person_id
AND p.person_id = $personId

ORDER BY c.movie_id
"; // be sure to assign the $personId from the $_GET['value'] on line 4 to its appropriate table column like it is on line 61

// Step 1 - GET RESULTS: 
// the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
// the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
// the second argument is the query you want to execute and that comes from the $strSQL variable you declared on line 7 above, but you could enter that entire string in place of the variable
// the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
// NOTE: the $result variable can be reused and now holds the result from the second query as your first results are saved in $movieBio
$result = mysqli_query($connect, $strSQL);

// Step 2 - FETCH DATA: 
// the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
// the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
// the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
// you store the return value in a new variable that you can name whatever is descriptive for your use case
// IMPORTANT NOTE --> this variable, $role, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments in movie.php line 84
// you will rename your variable for each specific query
$role = mysqli_fetch_all($result, MYSQLI_ASSOC);


// NOTE - your connection is still open so you can still perform a third, fourth, etc. query

// Now, query each director's movies

$strSQL = "SELECT
m.movie_id
, m.title

FROM
cis282movies.movies m
, cis282movies.persons p

WHERE
m.director_id = p.person_id
AND p.person_id = $personId

ORDER BY m.movie_id
";

// Step 1 - GET RESULTS: 
// the mysqli_query() function takes two required arguments, the information needed to connect to the database ($connect) and the query string you want to execute ($strSQL)
// the first argument is $connect that is coming from your config.php file that includes the 'local host address', 'you usesrname', 'you password', 'the database you want to access'
// the second argument is the query you want to execute and that comes from the $strSQL variable you declared on line 7 above, but you could enter that entire string in place of the variable
// the function returns a mysqli_result object that you'll then need to process via mysqli_fetch_all()
// NOTE: the $result variable can be reused and now holds the result from the second query as your first results are saved in $movieBio
$result = mysqli_query($connect, $strSQL);

// Step 2 - FETCH DATA: 
// the myslqi_fetch_all() function fetches all records (rows) per your query and returns the results as an associative array, a numeric array, or both
// the function take two arguments, the $results (required) received from Step 1 - GET RESULTS and the format for how you want those results (optional), .e.g. mysqli_fetch_all(result, resultType)
// the result type can be associative (MYSQLI_ASSOC), numeric (MYSQLI_NUM) or both (MYSLQI_BOTH)
// you store the return value in a new variable that you can name whatever is descriptive for your use case
// IMPORTANT NOTE --> this variable, $director, is what holds all the data returned and what you'll use to access specific record fields in your display via php echo statments in movie.php line 104
// you will rename your variable for each specific query
$director = mysqli_fetch_all($result, MYSQLI_ASSOC);

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