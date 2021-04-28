<?php
$page = 'book';
$title = "Book - CravinkMinds";
$description = "Tired of the heart ache of wirtter's block-you want to write but can't get?..........";
include 'header.php';
include 'engine/conn.php';
include 'functions/db_functions.php';

$id = $_GET['id'];
$query = "SELECT * FROM books WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
  echo "Can't retrieve data " . mysqli_error($conn);
  exit;
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
  echo "Empty book";
  exit;
}

?>

<div class="container px-5">
  <p class="lead mt-4"><a href="books.php">Books</a> > <?= $row['book_title']; ?></p>
  <div class="row">
    <div class="col-md-3 text-center mb-3">
      <img class="img-responsive img-thumbnail" src="./img/books/<?= $row['book_image']; ?>">
    </div>
    <div class="col-md-9">
      <h4>Book Description</h4>
      <p class="text-justify"><?= $row['book_descr']; ?></p>
      <h4>Book Details</h4>
      <table class="table">
        <tbody>
          <tr>
            <td>Author</td>
            <td><?= $row['book_author'] ?></td>
          </tr>
          <tr>
            <td>Published By</td>
            <td>
              <?php
              $bookId = $row['u_id'];
              $rquery = "SELECT * FROM register WHERE id = '$bookId'";
              $cresult = mysqli_query($conn, $rquery);
              $rrow = mysqli_fetch_assoc($cresult);
              echo $rrow['name'];
              ?>
            </td>
          </tr>
          <tr>
            <td>Publication Date</td>
            <td><?= pretty_date($row['created_at']); ?></td>
          </tr>
          <tr>
            <td>Old Price</td>
            <td><strike class="text-red">N<?= $row['list_price']; ?></strike></td>
          </tr>
          <tr>
            <td>Price</td>
            <td>N<?= $row['book_price'] ?></td>
          </tr>

        </tbody>
      </table>
      <?php if (!empty($row['purchase_link'])) : ?>
        <a role="button" target="_blank" href="<?= $row['purchase_link']; ?>" class="btn btn-success mb-4 text-decoration-none"> Purchase </a>
      <?php else : ?>

        <button type="button" class="btn btn-success mb-3" data-toggle="collapse" data-target="#pForm">Purchase</button>

        <div id="pForm" class="collapse">
          <form id="paymentForm">
            <!-- <form id="paymentForm" action="pay.php" method="POST"> -->
            <div class="form-group">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email-address" required>
            </div>
            <div class="form-group">
              <!-- <label for="amount">Amount</label> -->
              <input type="hidden" id="book_id" value="<?= $row['id']; ?>">
              <input type="hidden" class="form-control" id="amount" value="<?= $row['book_price']; ?>" required />
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <div class="form-group">
                  <label for="first-name">First Name</label>
                  <input type="text" class="form-control" id="first-name" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="last-name">Last Name</label>
                  <input type="text" class="form-control" id="last-name" />
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success mb-3" onclick="payWithPaystack()"> Pay </button>
          </form>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>


</div>

<!-- Page Footer-->
<?php include 'footer.php'; ?>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
  const paymentForm = document.getElementById('paymentForm');
  paymentForm.addEventListener("submit", payWithPaystack, false);

  function payWithPaystack(e) {
    e.preventDefault();
    let handler = PaystackPop.setup({
      key: 'pk_test_21817dec44e03c6736666c8196ecda193d8c9f9e', // Replace with your public key
      email: document.getElementById("email-address").value,
      amount: document.getElementById("amount").value * 100,
      ref: 'CIM' + Math.floor((Math.random() * 1000000000) + 1),
      metadata: {
        book_id: document.getElementById("book_id").value,
        last_name: document.getElementById("last-name").value,
        first_name: document.getElementById("first-name").value,
      },
      // label: "Optional string that replaces customer email"
      onClose: function() {
        alert('Transaction was not completed, window closed.');
      },
      callback: function(response) {
        let reference = response.reference;
        let message = 'Payment complete! Reference: ' + reference;
        alert(message);
        // window.location = "https://www.cravinkminds.com/verify_transaction.php?reference=" + reference
        window.location = "http://localhost/cravinkminds/verify_transaction.php?reference=" + reference;
      },
    });

    handler.openIframe();

  }
</script>
</body>

</html>