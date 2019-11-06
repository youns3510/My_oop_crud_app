<?php


include_once(__DIR__.'/../classes/product.php');
if(isset($_GET['product']) && filter_var($_GET['product'],FILTER_VALIDATE_INT)){
  $product = new Product();
  $product->id = (int)$_GET['product'];
  if($product->delete()){
    $_SESSION['action'] = true;   
    $_SESSION['message'] = "the product deleted successfully";
    $_SESSION['class']= 'success';
    header('location: /products/');
  }
}