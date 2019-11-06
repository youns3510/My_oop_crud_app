<nav class="navbar navbar-light bg-light mb-5">
  <div class="btn-group" role="group">
    <a href="index.php" class="btn btn-primary">
      <i class="fas fa-home"></i>
      All Product
    </a>
    <a href="create.php" class="btn btn-success">
      <i class="fas fa-plus"></i>
      Create Product
    </a>
  </div>
  <form class="form-inline" action="search.php" method="get">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" value="<?php echo isset($product->search_query) ? $product->search_query : '';?>">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
</nav>

