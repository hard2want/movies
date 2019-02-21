<?php 

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

        "; // you need a variable and put the query in double quotes

// get results
$result = mysqli_query($connect, $strSQL); // this should be the same for all queries based on the strSQL that you send it

// fetch data
$movieBio = mysqli_fetch_all($result, MYSQLI_ASSOC); // you will rename your variable for each specific query

// NOTE - all of the above is one query

// get cast data





// free result
mysqli_free_result($result);

// close connection
mysqli_close($connect);
?>