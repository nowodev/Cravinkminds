<?php
$title = 'Edit Books';
$page = 'editbook';
session_start();
include '../engine/conn.php';
if (isset($_SESSION['cravinkuname'])) {
  $cravinkuname = $_SESSION['cravinkuname'];
} else {
  header("Location:../login.php");
}

include 'dashboard-nav.php';


if (isset($_GET['bookisbn'])) {
  $book_isbn = $_GET['bookisbn'];
} else {
  echo "Empty query!";
  exit;
}

if (!isset($book_isbn)) {
  echo "Empty isbn! check again!";
  exit;
}

// get book data
$query = "SELECT * FROM books WHERE book_isbn = '$book_isbn'";
$result = mysqli_query($conn, $query);
if (!$result) {
  echo "Can't retrieve data " . mysqli_error($conn);
  exit;
}
$row = mysqli_fetch_assoc($result);
?>
<script type="text/javascript" src="js/npost.js"></script>

<main role="main" class="col-md-qw ml-sm-auto col-lg-10 pt-1 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

    <form method="post" action="bookedit.php" enctype="multipart/form-data">
      <h1 class="display-1">Edit Book</h1>
      <table class="table">
        <tr>
          <th>ISBN</th>
          <td><input type="text" name="isbn" value="<?php echo $row['book_isbn']; ?>" readOnly="true"></td>
        </tr>
        <tr>
          <th>Title</th>
          <td><input type="text" name="title" value="<?php echo $row['book_title']; ?>" required></td>
        </tr>
        <tr>
          <th>Author</th>
          <td><input type="text" name="author" value="<?php echo $row['book_author']; ?>" required></td>
        </tr>
        <tr>
          <th>Image</th>
          <td><input type="file" name="image"></td>
        </tr>
        <tr>
          <th>Description</th>
          <td><textarea name="descr" cols="40" rows="5"><?php echo $row['book_descr']; ?></textarea>
        </tr>
        <tr>
          <th>Price</th>
          <td><input type="text" name="price" value="<?php echo $row['book_price']; ?>" required></td>
        </tr>
      </table>
      <input type="submit" name="save_change" value="Change" class="btn btn-primary">
      <input type="reset" value="cancel" class="btn btn-default">
      <br>
      <a href="viewbooks.php" class="mt-4 btn btn-success">Confirm</a>
    </form>

  </div>
</main>
<?php
if (isset($conn)) {
  mysqli_close($conn);
}
?>


</body>

</html>