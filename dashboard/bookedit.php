<?php
session_start();
include '../engine/conn.php';
if (isset($_SESSION['cravinkuname'])) {
  $cravinkuname = $_SESSION['cravinkuname'];
} else {
  header("Location:../login.php");
}
// if save change happen
if (!isset($_POST['save_change'])) {
  echo "Something wrong!";
  exit;
}

$isbn = trim($_POST['isbn']);
$title = trim($_POST['title']);
$author = trim($_POST['author']);
$descr = trim($_POST['descr']);
$price = floatval(trim($_POST['price']));

if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
  $image = $_FILES['image']['name'];
  $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
  $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "img/books/";
  $uploadDirectory .= $image;
  move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
}

$query = "UPDATE books SET
	book_title = '$title',
	book_author = '$author',
	book_descr = '$descr',
	book_price = '$price'";
if (isset($image)) {
  $query .= ", book_image = '$image' WHERE `book_isbn` = '$isbn'";
} else {
  $query .= " WHERE `book_isbn` = '$isbn'";
}
// two cases for file , if file submit is on => change a lot
$result = mysqli_query($conn, $query);
if (!$result) {
  echo "Can't update data " . mysqli_error($conn);
  exit;
} else {
  header("Location: editbook.php?bookisbn=$isbn");
}