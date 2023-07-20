<!DOCTYPE html>
<html lang="en">

<head>
  <title>ATN STORE</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <!-- main css -->
  <link rel="stylesheet" href="./views/css/style.css" />
</head>

<body>
  <?php
  include('connect.php');
  $get_categories = "SELECT * FROM category";
  $categories = mysqli_query($conn, $get_categories);

  $categoriesArr = [];
  if ($categories) {
    while ($row = mysqli_fetch_assoc($categories)) {
      $categoriesArr[$row['id']] = $row['cate_name'];
    }
  }




  $currentURL = $_SERVER['REQUEST_URI'];
  $baseURL = dirname(substr($currentURL, 0, strrpos($currentURL, '/')));

  $parts = explode('/', $currentURL);
  $id = end($parts);
  $getProductById = "SELECT * FROM products WHERE id = '$id'";
  $currentProduct = mysqli_query($conn, $getProductById);
  if ($currentProduct && mysqli_num_rows($currentProduct) > 0) {
    $productData = mysqli_fetch_assoc($currentProduct);
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];

   // Handle thumbnail file upload
   $thumbnail = $_FILES["thumbnail"];
   $thumbnailName = $thumbnail["name"];
   $thumbnailTmpName = $thumbnail["tmp_name"];
   $thumbnailPath = "image/" . $thumbnailName;
   move_uploaded_file($thumbnailTmpName, $thumbnailPath);

    //  Process from submission
    $sql = "UPDATE products SET prod_name = ?, price= ?, category_id= ?, thumbnail = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdisi", $title, $price, $category, $thumbnailPath, $id); // string, double, integer, string

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Redirect to the hompage
      header("Location: ../index.php");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Close the prepared statenebt and database connection
    $stmt->close();
  }
  ?>

  <!-- HEADER START -->
  <header class="header__ATN">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">ATN Dolls</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home</a>
</li>
            <li class="nav-item">
              <a class="nav-link" href="#">Add product</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-3" type="search" placeholder="Search" />
            <button class="btn btn-outline-info my-3 my-sm-0" type="submit">
              Search
            </button>
          </form>
        </div>
      </nav>
    </div>
  </header>
  <!-- HEADER END -->

  <!-- FORM START -->
  <div class="ATN__form">
    <form class="container mx-auto py-3" method="POST" enctype="multipart/form-data">
      <h1 class="text-dark font-Dark-bold">Update Product</h1>
      <?php foreach ($currentProduct as $product) { ?>
        <div class="form-group">
          <label for="product__name">Product name</label>
          <input type="text" class="form-control" id="product__name" placeholder="Enter product name ..." name="name" value="<?php echo $product["prod_name"] ?>">

        </div>
        <div class="form-group">
          <label for="product__price">Price</label>
          <input type="number" class="form-control" id="product__price" placeholder="Enter price ..." name="price" value="<?php echo $product["price"] ?>">

        </div>
        <div class="form-group">
          <label for="category" class="from-label">Category</label>
          <select class="form-select" id="category" name="category">
            <option selected hidden value="<?php echo $product["category_id"] ?>">
              <?php echo "#" . $categoriesArr[$product["category_id"]] ?></option>
            <?php foreach ($categories as $category) { ?>
              <option class="text-dark" value="<?php echo $category["id"] ?>"><?php echo "#" . $category["cate_name"] ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">

          <label for="prod_img" class="form-label">Product image</label>
          <input type="file" class="form-control" id="prod_img" value="<?php echo $product["thumbnail"] ?>" name="thumbnail" />
          <img src="<?php echo $baseURL . '/' . $product["thumbnail"]; ?>" class="mt-3" alt="preview" width="200" height="200"> </div>
        <?php } ?>
        <div class="form-group">
          <a href="./index.php" class="btn btn-outline-secondary">Back to Products</a>
          <button class="btn btn-success">Update</button>
        </div>
    </form>
  </div>
  <!-- FORM END -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
<?php
if (isset($_GET['update_product_id'])) {
  $product_id = $_GET['update_product_id'];
  $update_product = "update from products set prod_name='$title'category_id='$category'price='$price' thumbnail ='$thumbnailPath' where id='$product_id'";
  $execute = mysqli_query($conn, $update_product);
  if ($execute) {
    echo "<script>window.open('index.php','_self)</script>";
  };
}
?>