<?php
$session_lifetime = 8 * 60 * 60; // 8 hours

// Set PHP session cookie lifetime
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

require_once("../PartsOfPage/Database.php");

// ADMIN PROTECTION
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: Log-in.php");
    exit();
}

// FETCH ALL ORDERS
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($db_conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../PartsOfPage/PartsOfPage.css" rel="stylesheet">
    <link href="../CssOfPages/admin_dashboard.css" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body>

<div class="head-nav">
    <?php include("../PartsOfPage/header.php"); ?>
    <?php include("../PartsOfPage/nav.php"); ?>
</div>

<main>

<h1 class="title">Admin Dashboard</h1>
<div class="dashboard-grid">

    <div class="dashboard-card create-order-card">
        <h3>Create New Order</h3>
        <p>Manually create a new customer order</p>
        <a class="btn order">Create Order</a>
    </div>

</div>


<?php while ($row = mysqli_fetch_assoc($result)): ?>

<div class="order-card">

    <div class="order-header">
        <span class="order-ref">Order #<?= $row['id'] ?></span>
        <span class="order-date"><?= $row['created_at'] ?></span>
    </div>

    <div class="order-grid">

        <!-- ITEMS -->
        <div class="order-section">
            <h3>Items</h3>
            <div class="items-box">
                <?php
                    $items = json_decode($row['cart_items'], true);
                    if ($items) {
                        foreach ($items as $item) {
                            print "<div class='item-line'>- {$item['title']} <span>(x{$item['quantity']})</span></div>";
                        }
                    } else {
                        print "No items";
                    }
                ?>
            </div>
        </div>

        <!-- CUSTOMER -->
        <div class="order-section">
            <h3>Customer Info</h3>
            <p><b>Name:</b> <?= $row['full_name'] ?></p>
            <p><b>Address:</b> <?= $row['address'] ?></p>
            <p><b>Email:</b> <?= $row['email'] ?></p>
            <p><b>Phone:</b> <?= $row['phone'] ?></p>
            <p><b>City:</b> <?= $row['city'] ?></p>
            <p><b>Postal Code:</b> <?= $row['postal_code'] ?></p>
            <p><b>Country:</b> <?= $row['country'] ?></p>
        </div>

        <!-- STATUS -->
        <div class="order-section">
            <h3>Status</h3>

            <span class="badge <?= str_replace(' ', '-', $row['status']) ?>">
                <?= $row['status'] ?>
            </span>
        </div>


        <!-- BUTTON -->
        <div class="order-section">
             <h3 id="button">Action</h3>

        <form method="POST" action="../phpFunctions/MarkAsShipped.php">
        <input type="hidden" name="order_id" value="<?php print $row['id'] ?>">

        <select name="status" class="status-select">
            <?php
                $statuses = ["Pending", "In Progress", "On Hold", "Delivered", "Cancelled"];
                foreach ($statuses as $s) {
                    $selected = ($row['status'] == $s) ? "selected" : "";
                    print "<option value='$s' $selected>" . $s . "</option>";
                }
            ?>
        </select>

        <button type="submit" class="btn blue">Update</button>
    </form>

     <form method="POST" action="../phpFunctions/delete_order.php" onsubmit="return confirm('Delete this order?');">
        <input type="hidden" name="order_id" value="<?php print $row['id'] ?>">
        <button type="submit" class="btn red">Delete</button>
     </form>

        </div>

    </div>

</div>

<?php endwhile; ?>

</main>

<!-- POPUP OVERLAY -->
<div id="createOrderPopup" class="popup-overlay">
  <div class="popup-box">

    <h2>Create New Order</h2>

    <form id="createOrderForm" method="POST" action="../phpFunctions/CreateOrder.php">

      <label>Full Name</label>
      <input type="text" name="full_name" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Phone</label>
      <input type="text" name="phone" required>

      <label>Address</label>
      <input type="text" name="address" required>

      <label>City</label>
      <input type="text" name="city" required>

      <label>Postal Code</label>
      <input type="text" name="postal_code" required>

      <label>Country</label>
      <input type="text" name="country" required>

      <label class="full-width">Title</label>
      <input type="text" name="title" class="full-width" required>

      <label>Author</label>
      <input type="text" name="author" required>

      <label class="full-width">Price</label>
      <input type="text" name="price" class="full-width" required>

      <label>Quantity</label>
      <input type="text" name="quantity" required>

      <div class="form-buttons">
        <button type="submit" class="btn blue">Create</button>
        <button type="button" class="btn red" id="closePopupBtn">Cancel</button>
      </div>

    </form>

  </div>
</div>

<script>
    // OPEN POPUP
    document.querySelector(".create-order-card .btn").addEventListener("click", function (e) {
        e.preventDefault();
        document.getElementById("createOrderPopup").style.display = "flex";
    });

    // CLOSE POPUP
    document.getElementById("closePopupBtn").addEventListener("click", function () {
        document.getElementById("createOrderPopup").style.display = "none";
    });

    // CLOSE POPUP IF CLICKED OUTSIDE THE BOX
    window.addEventListener("click", function (e) {
        const popup = document.getElementById("createOrderPopup");
        if (e.target === popup) {
            popup.style.display = "none";
        }
    });
</script>


<?php include("../PartsOfPage/footer.php"); ?>
</body>
</html>
