<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ATN STORE </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <!-- main css -->
    <link rel="stylesheet" href="./views/css/style.css" />
  </head>
  <body>
  <?php 
    include('connect.php');
    $get_products="SELECT * FROM products";
    $get_categories="SELECT * FROM category";
    $products= mysqli_query($conn,$get_products);
    $categories=[];
    $category = mysqli_query($conn,$get_categories);
    if ($category){
      while ($row = mysqli_fetch_assoc($category)){
        $categories[$row['id']]=$row['cate_name'];
      }
    }
    ?>
   
    <!-- HEADER START -->
    <header class="header__ATN">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="./index.html">ATN STORE </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./create.php">Product</a>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input
                class="form-control mr-sm-2"
                type="search"
                placeholder="Search"
              />
              <button
                class="btn btn-outline-info my-2 my-sm-0"
                type="submit"
              >
                Search
              </button>
            </form>
          </div>
        </nav>
      </div>
    </header>
    <!-- HEADER END -->
    
    <!-- PRODUCT START -->
    <div class="product__list mt-5">
      <div class="container">
        <div class="row gap-3 justify-content-center">
        <?php foreach ($products as $product){?>
          <div class="col-12 col-sm-9 col-md-6 col-lg-3">
            <div class="card">
              <img src="<?php echo $product['thumbnail'];?>" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title"><?php echo $product['prod_name'];?></h5>
                <div
                  class="product__danger d-flex justify-content-between align-items-center"
                >
                  <p class="text-danger fs-4"><?php echo $product['price'];?> VNĐ</p>
                    <span class="badge bg-light">#<?php echo $categories[$product['category_id']];?></span>
                  </p>
                </div>
                <p class="card-text">
                
                </p>
                <div class="product__update">
                  <a href="./update.php/<?php echo $product["id"];?>"
                  class= "btn btn-success  w-100 mb-1">Update</a>
                  <button
                   class="btn btn-danger w-100"
                    data-toggle="modal"
                    data-target="#product-<?php echo $product["id"] ?>">
                    Delete</button>
                </div>
                <div
                  class="modal fade"
                  id="product-<?php echo $product["id"] ?>"
                  tabindex="-1"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5
                          class="modal-title text-warning"
                          id="exampleModalLabel"
                        >
                          Warning
                        </h5>
                        <button
                          type="button"
                          class="close"
                          data-dismiss="modal"
                          aria-label="Close"
                        >
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">Are you sure to delete?</div>
                      <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-dismiss="modal"
                        >
                          Close
                        </button>
                        <button type="button" class="btn btn-danger">
                          <a href="index.php?delete_product_id=<?php echo $product["id"];?>"
                          class="text-white text-decoration-none">
                          Delete
                          </a>
                        </button>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        </div>
      </div>
    </div>
    <!-- PRODUCT END -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

<?php 
if (isset($_GET['delete_product_id'])) {
  $product_id = $_GET['delete_product_id'];
  $delete_product = "delete from products where id='$product_id'";
  $execute = mysqli_query($conn,$delete_product);
  if($execute){
    echo"<script>window.open('index.php','_self)</script>";
  };
}
?>