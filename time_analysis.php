<?php
    include "db_connection.php";
    session_start();

    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $connection = connect();
    
    $sql_html = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE response_headers LIKE '%/html%'";
    $result_html = mysqli_query($connection, $sql_html);
    $html_headers = mysqli_fetch_all($result_html);

    $sql_javascript = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE response_headers LIKE '%/javascript%'";
    $result_javascript = mysqli_query($connection, $sql_javascript);
    $javascript_headers = mysqli_fetch_all($result_javascript);

    $sql_css = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE response_headers LIKE '%/css%'";
    $result_css = mysqli_query($connection, $sql_css);
    $css_headers = mysqli_fetch_all($result_css);

    $sql_image = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE response_headers LIKE '%image/%'";
    $result_image = mysqli_query($connection, $sql_image);
    $image_headers = mysqli_fetch_all($result_image);

    $sql_monday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Monday'";
    $monday_result = mysqli_query($connection, $sql_monday);
    $monday_timings = mysqli_fetch_all($monday_result);

    $sql_tuesday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Tuesday'";
    $tuesday_result = mysqli_query($connection, $sql_tuesday);
    $tuesday_timings = mysqli_fetch_all($tuesday_result);

    $sql_wednesday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Wednesday'";
    $wednesday_result = mysqli_query($connection, $sql_wednesday);
    $wednesday_timings = mysqli_fetch_all($wednesday_result);

    $sql_thursday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Thursday'";
    $thursday_result = mysqli_query($connection, $sql_thursday);
    $thursday_timings = mysqli_fetch_all($thursday_result);

    $sql_friday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Friday'";
    $friday_result = mysqli_query($connection, $sql_friday);
    $friday_timings = mysqli_fetch_all($friday_result);

    $sql_saturday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Saturday'";
    $saturday_result = mysqli_query($connection, $sql_saturday);
    $saturday_timings = mysqli_fetch_all($saturday_result);

    $sql_sunday = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE DAYNAME(startedDateTime) = 'Sunday'";
    $sunday_result = mysqli_query($connection, $sql_sunday);
    $sunday_timings = mysqli_fetch_all($sunday_result);

    $sql_get = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE request_method = 'GET' ";
    $get_result = mysqli_query($connection, $sql_get);
    $get_timings = mysqli_fetch_all($get_result);

    $sql_post = "SELECT EXTRACT(HOUR FROM startedDateTime), timings_wait FROM entries WHERE request_method = 'POST' ";
    $post_result = mysqli_query($connection, $sql_post);
    $post_timings = mysqli_fetch_all($post_result);

    $ajax_array = array(
        'html_headers' => $html_headers,
        'javascript_headers' => $javascript_headers,
        'css_headers' => $css_headers,
        'image_headers' => $image_headers,
        'monday_timings' => $monday_timings,
        'tuesday_timings' => $tuesday_timings,
        'wednesday_timings' => $wednesday_timings,
        'thursday_timings' => $thursday_timings,
        'friday_timings' => $friday_timings,
        'saturday_timings' => $saturday_timings,
        'sunday_timings' => $sunday_timings,
        'get_timings' => $get_timings,
        'post_timings' => $post_timings
    );

    $ajax_json = json_encode($ajax_array, JSON_PRETTY_PRINT);
    print_r($ajax_json);
    


    disconnect($connection);
