<?php
//
// To-do list data
//
function get_todo_list_count() {
    global $conn;

    $query = "SELECT id FROM `".DATABASE_PREFIX."todo_lists` WHERE 1";
    $rs = mysqli_query($conn,$query);
    return mysqli_num_rows($rs);
}
function get_todo_list_name($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `name` FROM `".DATABASE_PREFIX."todo_lists` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['name'];
}
function get_todo_list_visibility($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `visibility` FROM `".DATABASE_PREFIX."todo_lists` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['visibility'];
}
function get_todo_list_role_id($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `role_id` FROM `".DATABASE_PREFIX."todo_lists` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['role_id'];
}
function get_todo_list_owner_id($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `owner_id` FROM `".DATABASE_PREFIX."todo_lists` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['owner_id'];
}
function get_todo_list_status($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `status` FROM `".DATABASE_PREFIX."todo_lists` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['status'];
}
//
// To-do list item data
//
function get_todo_item_title($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `title` FROM `".DATABASE_PREFIX."todo_items` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['title'];
}
function get_todo_item_description($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `description` FROM `".DATABASE_PREFIX."todo_items` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['description'];
}
function get_todo_item_status($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `status` FROM `".DATABASE_PREFIX."todo_items` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['status'];
}
function get_todo_item_list_id($id) {
    $id = checkInput('DEFAULT', $id);

    global $conn;

    $query = "SELECT `list_id` FROM `".DATABASE_PREFIX."todo_items` WHERE `id` = ".$id;
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($rs);

    return $row['list_id'];
}