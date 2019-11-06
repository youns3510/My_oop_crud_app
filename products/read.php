<?php
$page_title = "Read Product";
include_once(__DIR__ . '/../layouts/header.php');
include_once(__DIR__ . '/../layouts/_top_bar.php');
include_once(__DIR__ . '/../classes/product.php');
include_once(__DIR__ . '/../classes/category.php');
if (isset($_GET['product']) && filter_var($_GET['product'], FILTER_VALIDATE_INT)) {

  $product  = new Product();
  $category = new Category();

  $product->id = (int) $_GET['product'];
  $stmt = $product->readOne();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $category->id = $row['category_id'];
    $category->readName();
    ?>
    <div class="product m-4">
      <div class="card" style="width: 80%;">
        <img src="<?php echo $host; ?>uploads/<?php echo $row['image']; ?>" alt="<?php echo  $row['name']; ?>" class=" card-img-top img-thumbnail">
        <div class="card-body">
          <h5 class="card-title"><?php echo  $row['name']; ?></h5>
          <h4 class="h4">Price:&dollar; <?php echo $row['price']; ?></h4>
          <h4 class="h4">Category: <?php echo  $category->name; ?></h4>
          <p class="card-text"><?php echo $row['description']; ?></p>
        </div>
      </div>
    </div>

<?php
  }
} else {
  header('location: /products/');
}
include_once(__DIR__ . '/../layouts/footer.php'); ?>