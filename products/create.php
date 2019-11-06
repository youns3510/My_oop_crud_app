<?php

$page_title = "Create Product";
include_once(__DIR__ . "/../config/database.php");
include_once(__DIR__ . "/../classes/product.php");
include_once(__DIR__ . "/../classes/category.php");
include_once(__DIR__ . '/../layouts/header.php');
include_once(__DIR__ . '/../layouts/_top_bar.php');

$conn = (new Database())->getConnection();

$product  = new Product($conn);
$category = new Category($conn);

if (isset($_POST['submit_create'])) {
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    $image = !empty($_FILES['image']['name']) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES['image']['name']) : "";
    $product->image = $image;
   // echo $image;
    //var_dump($_FILES);
    if ($product->create()) {
        // product created successfully
        echo "<div class='alert alert-success'>product created successfully</div>";
        // upload photo after success
        // echo errors if exist
        echo $product->uploadPhoto();
    } else {
        echo $product->all_error;
    }
}

?>
<form method="post" action="create.php" enctype="multipart/form-data">
    <table class="table  table-bordered create-form">
        <tr>
            <th>Name</th>
            <td><input type="text" placeholder="Type Product's Name" name="name"></td>
        </tr>
        <tr>
            <th>Price</th>
            <td><input type="text" placeholder="Type Product's price 00.00" name="price"></td>
        </tr>
      
        <tr>
            <th>Category</th>
            <td>

                <!--read all categories-->
                <select name="category_id">
                    <option value="">Select Category</option>
                    <?php
                    $stmt = $category->read();

                    while ($row_cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_cat);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                    ?>
                </select>

            </td>
        </tr>
        <tr>
            <th>Description</th>
            <td><textarea  placeholder="Type Product's description" name="description"></textarea>
</td>
        </tr>
        <tr>
            <th>Photo</th>
            <td><input type="file" accept="image/*" name="image"></td>
        </tr>
    </table>
    <button type="submit" class="btn btn-success" name="submit_create">Create</button>
</form>
<?php include_once(__DIR__ . '/../layouts/footer.php'); ?>