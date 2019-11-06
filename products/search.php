<?php


$page_title = "Search | Products";
include_once(__DIR__ . '/../layouts/header.php');

include_once(__DIR__ . "/../classes/product.php");
include_once(__DIR__ . "/../classes/category.php");
include_once(__DIR__ . '/../config/core.php');
// $db = (new Database())->getConnection();

  $product = new Product();
  $category = new Category();
  $product->search_query = isset($_GET['query']) ? htmlspecialchars(($_GET['query'])) : '';
  $page_url = "search.php?query={$product->search_query}&";
  include_once(__DIR__ . '/../layouts/_top_bar.php');
  $stmt = $product->searchResults($record_per_page, $start_read_from);
  if ($stmt->rowCount() > 0) {
 
    ?>


    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Price</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php


              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $category->id = $category_id;
                $category->readName();
                echo " 
          <tr>
            <td>{$id}</td>
            <td>{$name}</td>
            <td>{$price}</td>
            <td>{$description}</td>
            <td>{$category->name}</td>
            <td>
            <div class='btn-group' role='group' aria-label='Basic example'> 
              <a class='btn m-1 btn-primary' href='read.php?product={$id}'>
                <i class='fas fa-eye'></i>                
              </a>
              <a class='btn m-1  btn-success' href='update.php?product={$id}'>
                <i class='fas fa-edit'></i>                
              </a>
              <a class='btn m-1  btn-danger' href='delete.php?product={$id}'>
                <i class='fas fa-trash'></i>                
              </a>
              </div>
            </td>
          </tr>";
           
              } ?>

        </tbody>
      </table>

    </div>

<?php
    $product->searchResultsCount();
    include_once(__DIR__ . '/../layouts/pagination.php');
  } else {

    echo "<h3 class='h3 text-center'>There is no product here</h3>";
  }
 

include_once(__DIR__ . '/../layouts/footer.php'); ?>