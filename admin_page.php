<?php
    include "db_connection.php";
    session_start();

    if ($_SESSION["name"] == "") {
        header("location:login.php");
    }

    

    $connection = connect();

    $sql_count_users = "SELECT count(id) FROM users";
    $result_count_users = mysqli_query($connection, $sql_count_users);
    $row_count_users = mysqli_fetch_row($result_count_users);
    $count_users = implode("", $row_count_users);

    $sql_domains = "SELECT count(DISTINCT(request_url)) FROM entries";
    $result_domains = mysqli_query($connection, $sql_domains);
    $row_domains = mysqli_fetch_row($result_domains);
    $unique_domains = implode("", $row_domains);

    $sql_isp = "SELECT count(DISTINCT(user_isp)) FROM users";
    $result_isp = mysqli_query($connection, $sql_isp);
    $row_isp = mysqli_fetch_row($result_isp);
    $unique_isp = implode("", $row_isp);

    $sql_get_count = "SELECT count(request_method) FROM entries WHERE request_method = 'GET' ";
    $result_get_count = mysqli_query($connection, $sql_get_count);
    $get_count_row = mysqli_fetch_row($result_get_count);
    $get_count = implode("", $get_count_row);

    $sql_post_count = "SELECT count(request_method) FROM entries WHERE request_method = 'POST' ";
    $result_post_count = mysqli_query($connection, $sql_post_count);
    $post_count_row = mysqli_fetch_row($result_post_count);
    $post_count = implode("", $post_count_row);

    $sql_response_0 = "SELECT count(response_status) FROM entries WHERE response_status = 0 ";
    $result_resp_0 = mysqli_query($connection, $sql_response_0);
    $row_resp_0 = mysqli_fetch_row($result_resp_0);
    $response_0 = implode("", $row_resp_0);

    $sql_response_101 = "SELECT count(response_status) FROM entries WHERE response_status = 101 ";
    $result_resp_101 = mysqli_query($connection, $sql_response_101);
    $row_resp_101 = mysqli_fetch_row($result_resp_101);
    $response_101 = implode("", $row_resp_101);

    $sql_response_200 = "SELECT count(response_status) FROM entries WHERE response_status = 200 ";
    $result_resp_200 = mysqli_query($connection, $sql_response_200);
    $row_resp_200 = mysqli_fetch_row($result_resp_200);
    $response_200 = implode("", $row_resp_200);

    $sql_response_204 = "SELECT count(response_status) FROM entries WHERE response_status = 204 ";
    $result_resp_204 = mysqli_query($connection, $sql_response_204);
    $row_resp_204 = mysqli_fetch_row($result_resp_204);
    $response_204 = implode("", $row_resp_204);

    $sql_response_301 = "SELECT count(response_status) FROM entries WHERE response_status = 301 ";
    $result_resp_301 = mysqli_query($connection, $sql_response_301);
    $row_resp_301 = mysqli_fetch_row($result_resp_301);
    $response_301 = implode("", $row_resp_301);

    $sql_response_302 = "SELECT count(response_status) FROM entries WHERE response_status = 302 ";
    $result_resp_302 = mysqli_query($connection, $sql_response_302);
    $row_resp_302 = mysqli_fetch_row($result_resp_302);
    $response_302= implode("", $row_resp_302);

    $sql_response_304 = "SELECT count(response_status) FROM entries WHERE response_status = 304 ";
    $result_resp_304 = mysqli_query($connection, $sql_response_304);
    $row_resp_304 = mysqli_fetch_row($result_resp_304);
    $response_304 = implode("", $row_resp_304);

    $sql_response_307 = "SELECT count(response_status) FROM entries WHERE response_status = 307 ";
    $result_resp_307 = mysqli_query($connection, $sql_response_307);
    $row_resp_307 = mysqli_fetch_row($result_resp_307);
    $response_307 = implode("", $row_resp_307);

    $sql_avg_html = "SELECT AVG(ABS(id)) FROM entries WHERE response_headers LIKE '%/html%' ";
    $result_avg_html = mysqli_query($connection, $sql_avg_html);
    $row_avg_html = mysqli_fetch_row($result_avg_html);
    $avg_html = implode("", $row_avg_html);

    $sql_avg_js = "SELECT AVG(ABS(id)) FROM entries WHERE response_headers LIKE '%/javascript%' ";
    $result_avg_js = mysqli_query($connection, $sql_avg_js);
    $row_avg_js = mysqli_fetch_row($result_avg_js);
    $avg_js = implode("", $row_avg_js);

    $sql_avg_css = "SELECT AVG(ABS(id)) FROM entries WHERE response_headers LIKE '%/css%' ";
    $result_avg_css = mysqli_query($connection, $sql_avg_css);
    $row_avg_css = mysqli_fetch_row($result_avg_css);
    $avg_css = implode("", $row_avg_css);

    $sql_avg_image = "SELECT AVG(ABS(id)) FROM entries WHERE response_headers LIKE '%image/%' ";
    $result_avg_image = mysqli_query($connection, $sql_avg_image);
    $row_avg_image = mysqli_fetch_row($result_avg_image);
    $avg_image = implode("", $row_avg_image);


    



    $user_array = array(
        'count_users' => $count_users,
        'unique_domains' => $unique_domains,
        'unique_isp' => $unique_isp,
        'get_count' => $get_count,
        'post_count' => $post_count,
        'response_0' => $response_0,
        'response_101' => $response_101,
        'response_200' => $response_200,
        'response_204' => $response_204,
        'response_301' => $response_301,
        'response_302' => $response_302,
        'response_304' => $response_304,
        'response_307' => $response_307,
        'avg_html' => $avg_html,
        'avg_js' => $avg_js,
        'avg_css' => $avg_css,
        'avg_image' => $avg_image
    );

    $user_array = json_encode($user_array);

    print_r($user_array);


    disconnect($connection);

?>

