<?php 

$personId = $_GET["person"]; // the GET request collect the value from the key/value pair set up within the <a> link and assigns it to the variable

// smaple query
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
 "; // you need a variable, e.g. $personId that is passed from the link and end the query in double quotes followed by the ;

// get results
$result = mysqli_query($connect, $strSQL); // this should be the same for all queries based on the strSQL that you send it

// fetch data and this variable is what links your person_model to your person.php page
$person = mysqli_fetch_all($result, MYSQLI_ASSOC); // you will rename your variable for each specific query




// get cast data that will need to be added next

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
";

// Get Result
$result = mysqli_query($connect, $strSQL);
// Fetch Data
$role = mysqli_fetch_all($result, MYSQLI_ASSOC);


// get cast data that will need to be added next

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

// Get Result
$result = mysqli_query($connect, $strSQL);
// Fetch Data
$director = mysqli_fetch_all($result, MYSQLI_ASSOC);





// free result
mysqli_free_result($result);

// close connection
mysqli_close($connect);
?>