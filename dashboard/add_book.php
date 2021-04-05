<?php
include '../engine/conn.php';
session_start();
if (isset($_SESSION['cravinkuname'])) {
  $cravinkuname = $_SESSION['cravinkuname'];
} else {
  header("Location:../login.php");
}

include 'dashboard-nav.php';
?>

<main role="main" class="col-md-qw ml-sm-auto pt-1 px-5 mx-5">
  <div class="flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

    <form method="post" action="adbok.php" enctype="multipart/form-data">
      <h1 class="display-1">Add Book</h1>

      <table class="table">
        <tr>
          <th>ISBN</th>
          <td><input type="text" name="isbn"></td>
        </tr>
        <tr>
          <th>Title</th>
          <td><input type="text" name="title" required></td>
        </tr>
        <tr>
          <th>Author</th>
          <td><input type="text" name="author" required></td>
        </tr>
        <tr>
          <th>Image</th>
          <td><input type="file" name="image" class="adnpic"></td>
        </tr>
        <tr>
          <th>Description</th>
          <td><textarea name="descr" form-control" rows="5"></textarea></td>
        </tr>
        <tr>
          <th>Purchase Link</th>
          <td><input type="text" name="link"></td>
        </tr>
        <tr>
          <th>Price</th>
          <td><input type="text" name="price" required></td>
        </tr>
      </table>
  </div>
  <input type="submit" name="add" value="Add new book" class="btn btn-success ednnsub">
  <input type="reset" value="cancel" class="btn btn-default">
  </form>
  <br />
</main>

</body>

</html>