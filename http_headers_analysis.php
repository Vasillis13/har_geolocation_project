<?php
    session_start();
    include "db_connection.php";
    include "User.php";


    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    $connection = connect();
    
    $sql_html_max_age = "SELECT response_headers FROM entries WHERE response_headers LIKE '%max-age%' AND response_headers LIKE '%html%' ";
    $html_max_age_result = mysqli_query($connection, $sql_html_max_age);
    $html_max_age = mysqli_fetch_all($html_max_age_result);

    $sql_javascript_max_age = "SELECT response_headers FROM entries WHERE response_headers LIKE '%max-age%' AND response_headers LIKE '%javascript%' ";
    $javascript_max_age_result = mysqli_query($connection, $sql_javascript_max_age);
    $javascript_max_age = mysqli_fetch_all($javascript_max_age_result);

    $sql_css_max_age = "SELECT response_headers FROM entries WHERE response_headers LIKE '%max-age%' AND response_headers LIKE '%css%' ";
    $css_max_age_result = mysqli_query($connection, $sql_css_max_age);
    $css_max_age = mysqli_fetch_all($css_max_age_result);

    $sql_image_max_age = "SELECT response_headers FROM entries WHERE response_headers LIKE '%max-age%' AND response_headers LIKE '%image%' ";
    $image_max_age_result = mysqli_query($connection, $sql_image_max_age);
    $image_max_age = mysqli_fetch_all($image_max_age_result);

    $sql_all_max_age = "SELECT response_headers FROM entries WHERE response_headers LIKE '%max-age%' ";
    $all_max_age_result = mysqli_query($connection, $sql_all_max_age);
    $all_max_age = mysqli_fetch_all($all_max_age_result);

    $sql_stale_fresh = "SELECT COUNT(request_headers) FROM entries WHERE request_headers LIKE '%max-stale%' OR request_headers LIKE '%min-fresh%' ";
    $stale_fresh_result = mysqli_query($connection, $sql_stale_fresh);
    $stale_fresh = mysqli_fetch_row($stale_fresh_result);
    $stale_fresh = implode("", $stale_fresh);

    $sql_request_count = "SELECT COUNT(request_headers) FROM entries";
    $request_count_result = mysqli_query($connection, $sql_request_count);
    $request_count = mysqli_fetch_row($request_count_result);
    $request_count = implode("", $request_count);

    $sql_response_public = "SELECT COUNT(response_headers) FROM entries WHERE response_headers LIKE '%public%' ";
    $public_result = mysqli_query($connection, $sql_response_public);
    $public_count = mysqli_fetch_row($public_result);
    $public_count = implode("", $public_count);

    $sql_response_private = "SELECT COUNT(response_headers) FROM entries WHERE response_headers LIKE '%private%' ";
    $private_result = mysqli_query($connection, $sql_response_private);
    $private_count = mysqli_fetch_row($private_result);
    $private_count = implode("", $private_count);

    $sql_response_no_cache = "SELECT COUNT(response_headers) FROM entries WHERE response_headers LIKE '%no-cache%' ";
    $no_cache_result = mysqli_query($connection, $sql_response_no_cache);
    $no_cache_count = mysqli_fetch_row($no_cache_result);
    $no_cache_count = implode("", $no_cache_count);

    $sql_response_no_store = "SELECT COUNT(response_headers) FROM entries WHERE response_headers LIKE '%no-store%' ";
    $no_store_result = mysqli_query($connection, $sql_response_no_store);
    $no_store_count = mysqli_fetch_row($no_store_result);
    $no_store_count = implode("", $no_store_count);

    $sql_response_count = "SELECT COUNT(response_headers) FROM entries";
    $response_count_result = mysqli_query($connection, $sql_response_count);
    $response_count = mysqli_fetch_row($response_count_result);
    $response_count = implode("", $response_count);


    $ajax_response = array(
        'html_max_age' => $html_max_age,
        'javascript_max_age' => $javascript_max_age,
        'css_max_age' => $css_max_age,
        'image_max_age' => $image_max_age,
        'all_max_age' => $all_max_age,
        'stale_fresh' => $stale_fresh,
        'request_count' => $request_count,
        'public_count' => $public_count,
        'private_count' => $private_count,
        'no_cache_count' => $no_cache_count,
        'no_store_count' => $no_store_count,
        'response_count' => $response_count
    );

    $ajax_response = json_encode($ajax_response, JSON_PRETTY_PRINT);

    print_r($ajax_response);

    disconnect($connection);
