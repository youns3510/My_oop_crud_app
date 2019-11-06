<?php
include_once(__DIR__ . "/../config/database.php");
class  Product
{
    // database

    private $conn;
    private $table_name = "products";

    // class properties
    // public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $image;
    public $error = array();
    public $all_error = '';
    public $allProducts;
    public $search_query, $search_results_count;



    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function create()
    {
        //clean data ,sanitize data

        $this->checkErrors();
        if (count($this->error) > 0) {

            // $err = implode("<br>",$this->error);
            // $this->all_error .="<div class='alert alert-danger'>{$err}</div>";
            $this->all_error .= "<div class='alert alert-danger'>";
            $i = 1;
            foreach ($this->error as $err) {
                $this->all_error .= "<span class='mr-1'>{$i}</span>: {$err}<hr>";
                $i++;
            }
            $this->all_error .= "</div>";
        } else {
            //  insert query
            $query = "insert into `{$this->table_name}`(`name`,`price`,`description`,`category_id`,`image`)values(:name,:price,:description,:category_id,:image);";

            $stmt = $this->conn->prepare($query);
            // bind parameters


            // echo $this->name       . '<br>';
            // echo $this->price      . '<br>';
            // echo $this->description . '<br>';
            // echo $this->category_id . '<br>';
            // echo $this->image      . '<br>';

            // echo gettype($this->price); 

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":image", $this->image);
            // $stmt->bindParam(":created", $this->timestamp);

            // INSERT INTO `products`
            // SET
            //     `name` = 'phone',
            //     `price` = 12,
            //     `description` = 'phone descritpi',
            //     `category_id` = 1,
            //     `image` = 'image.png',
            //     `created` = '2019-11-03 16:36:55';

            // excute statment
            // var_dump($stmt);
            $check =  $stmt->execute();

            if ($check) {
                return true;
            } else {
                print_r($stmt->errorInfo()[2]);
                return false;
            }
        }
    }
    public function uploadPhoto()
    {
        $result_msg = "";
        // if image not empty then upload it
        if ($this->image) {
            $target_dir = __DIR__ . "/../uploads/";
            $target_file = $target_dir . "" . $this->image;

            // error message
            $file_upload_error_msg  = "";
            // check if the image are real file or empty 
            $chk = getimagesize($_FILES['image']['tmp_name']); //return false if empty or array if not empty
            if ($chk == false) {
                $file_upload_error_msg  .= "<div class='alert alert-danger'>Submitted file is not an image.</div>";
            }

            // check type of image
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $allowed_file_types = array("jpg", 'jpeg', 'png', 'gif');
            if (!in_array($file_type, $allowed_file_types)) {
                $file_upload_error_msg .= "<div class='alert alert-danger'>Only  JPG, JPEG, PNG, GIF files are allowed.</div>";
            }

            // prevent deplecate files 'file didn't upload before'
            if (file_exists($target_file)) {
                $file_upload_error_msg .= "<div class='alert alert-danger'>Image already exists. try to change file name. and upload again</div>";
            }
            // make sure submitted file is not too large, can't be larger than 1 MB.
            if ($_FILES['image']['size'] > (1024000)) {
                $file_upload_error_msg .= "<div class='alert alert-danger'>Image must be less than 1MB in size.</div>";
            }

            // make sure the 'uploads' folder exists if not create it
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            // if $file_upload_error_msg is still empty
            if (empty($file_upload_error_msg)) {
                // it means there is no errors, so try to upload the file 
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $result_msg .= "<div class='alert alert-danger'>";
                    $result_msg .= "<div>Unable to upload photo.</div>";
                    $result_msg .= "<div>update the record to upload photo</div></div>";
                }
            } else {
                // it means there are errors 
                $result_msg .= "<div class='alert alert-danger'>";
                $result_msg .= "{$file_upload_error_msg}";
                $result_msg .= "<div>update the record to upload photo</div></div>";
            }
        }
        return $result_msg;
    }


    public function readOne()
    {
        $q = "SELECT * FROM `{$this->table_name}` WHERE id=?";
        $stmt = $this->conn->prepare($q);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            // echo $stmt->rowCount();
            return $stmt;
        } else {
            // print_r($stmt->errorInfo([2]));
            header('location:/products/');
        }
    }

    public function readAll($record_per_page, $start_read_from)
    {
        $q = "SELECT * FROM `{$this->table_name}` LIMIT ?,?;";

        $stmt = $this->conn->prepare($q);
        $stmt->bindParam(1, $start_read_from, PDO::PARAM_INT);
        $stmt->bindParam(2, $record_per_page, PDO::PARAM_INT);
     
        if ($stmt->execute()) {
           
            return $stmt;
        }
        // else {
        //     var_dump($stmt->errorInfo());
        // }
    }

    public function countAll()
    {
        $q = "SELECT `id` FROM `{$this->table_name}`;";
        $stmt = $this->conn->prepare($q);

        if ($stmt->execute()) {
            $this->allProducts = $stmt->rowCount();
            // return   $this->countAll;
        }
        // else {

        //     var_dump($stmt->errorInfo());
        // }
    }

    public function update()
    {
        //clean data ,sanitize data

        $this->checkErrors();
        if (count($this->error) > 0) {

            // $err = implode("<br>",$this->error);
            // $this->all_error .="<div class='alert alert-danger'>{$err}</div>";
            $this->all_error .= "<div class='alert alert-danger'>";
            $i = 1;
            foreach ($this->error as $err) {
                $this->all_error .= "<span class='mr-1'>{$i}</span>: {$err}<hr>";
                $i++;
            }
            $this->all_error .= "</div>";
        } else {
            //  insert query
            $query = "UPDATE `{$this->table_name}` SET `name`= ?,`price` =?,`description` = ?,`category_id` = ?,`image` = ? WHERE `id` = ?;";

            $stmt = $this->conn->prepare($query);
            // bind parameters


            // echo $this->name       . '<br>';
            // echo $this->price      . '<br>';
            // echo $this->description . '<br>';
            // echo $this->category_id . '<br>';
            // echo $this->image      . '<br>';

            // echo gettype($this->price); 

            $stmt->bindParam(1, $this->name);
            $stmt->bindParam(2, $this->price);
            $stmt->bindParam(3, $this->description);
            $stmt->bindParam(4, $this->category_id);
            $stmt->bindParam(5, $this->image);
            $stmt->bindParam(6, $this->id);

            // $stmt->bindParam(":created", $this->timestamp);

            // INSERT INTO `products`
            // SET
            //     `name` = 'phone',
            //     `price` = 12,
            //     `description` = 'phone descritpi',
            //     `category_id` = 1,
            //     `image` = 'image.png',
            //     `created` = '2019-11-03 16:36:55';

            // excute statment
            // var_dump($stmt);
            $check =  $stmt->execute();

            if ($check) {
                return true;
            } else {
                print_r($stmt->errorInfo()[2]);
                return false;
            }
        }
    }
    public function delete()
    {
        // select photo
        $q = "SELECT `image` FROM `{$this->table_name}` WHERE `id` = ?";
        $stmt0 = $this->conn->prepare($q);
        $stmt0->bindValue(1, $this->id, PDO::PARAM_INT);
        if ($stmt0->execute()) {
            extract($stmt0->fetch(PDO::FETCH_ASSOC));
        } else {
            print_r("select image :" . $stmt0->errorInfo()[2]);
        }

        // delete products
        $q = "DELETE  FROM `{$this->table_name}` WHERE `id` = ?";
        $stmt = $this->conn->prepare($q);
        $stmt->bindValue(1, $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // delete image from disk
            if (file_exists(__DIR__ . '/../uploads/' . $image)) {
                unlink(__DIR__ . '/../uploads/' . $image);
            }
            return true;
        } else {
            print_r("delete product :" . $stmt->errorInfo()[2]);
        };
    }


    public function searchResultsCount()
    {
        $this->search_query = '%'.$this->test_input($this->search_query).'%';
        $q = "SELECT * FROM `{$this->table_name}` WHERE `name` LIKE ? OR `price` LIKE ? ";

        $stmt = $this->conn->prepare($q);
        $stmt->bindParam(1, $this->search_query);
        $stmt->bindParam(2, $this->search_query);

        if ($stmt->execute()) {
            $this->allProducts = $stmt->rowCount();
        }
        else{
            print_r('search Count'.$stmt->errorInfo()[2]);
        }
    }
    public function searchResults($record_per_page, $start_read_from)
    {
        if (!empty($this->search_query)) {

            $this->search_query = '%'.$this->test_input($this->search_query).'%';
           
            $q = "SELECT * FROM `{$this->table_name}` WHERE `name` LIKE ? OR `price` LIKE ?   order by  `name` LIMIT ?,?";
           // SELECT * FROM `products` WHERE `name` %'Hu'% OR `price` LIKE %'Hu'% LIMIT 0,5 ;
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(1, $this->search_query);
            $stmt->bindParam(2, $this->search_query);          
            $stmt->bindParam(3, $start_read_from, PDO::PARAM_INT);
            $stmt->bindParam(4, $record_per_page, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt;
            }
            else{
                print_r('Search Results'.$stmt->errorInfo()[2]);
            }
        }
    }

    public  function checkErrors()
    {

        if (empty($this->name)) {
            $this->error['name'] = "name is required";
        } else {
            $this->name = $this->test_input($this->name);
        }
        if (empty($this->price)) {
            $this->error['price'] = "price is required";
        } else {
            $this->price = $this->test_input($this->price);
        }
        if (empty($this->description)) {
            $this->error['description '] = "description  is required";
        } else {
            $this->description = $this->test_input($this->description);
        }
        if (empty($this->category_id)) {
            $this->error['category'] = "category  is required";
        } else {
            $this->category_id =  $this->test_input($this->category_id);
        }
        if (empty($this->image)) {
            $this->error['image'] = "image is required";
        } else {
            $this->image =   $this->test_input($this->image);
        }
    }
    public function test_input($data)
    {
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
