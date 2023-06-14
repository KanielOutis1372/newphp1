<?php
require_once '../models/ProductModel.php';
require_once '../models/TagModel.php';
require_once '../models/CategoryModel.php';
require_once '../models/Product.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$limit = isset($_GET['limit']) ? $_GET['limit'] : 3;
switch ($action) {
    case 'add':
        // print_r(getDataInputForm());
        $_product = getDataInputForm();
        $createdDate = date('Y-m-d');
        $modifiedDate = $createdDate;
        $_product->setCreatedDate($createdDate);
        $_product->setModifiedDate($modifiedDate);
        add($_product);
        header('Location: index.php');
        break;

    case 'addproperty':
        addproperty($_POST['tag'], $_POST['category']);
        header('Location: index.php');
        break;
    case 'update': //-----------------------------------------> chua xong
        // $id = $_POST['id'];
        // $name = $_POST['name'];
        // $price = $_POST['price'];
        // $description = $_POST['description'];
        // Product::update($id, $name, $price, $description);
        // header('Location: index.php');
        $_product = getDataInputForm();
        $_product->setModifiedDate(date('Y-m-d'));
        update($_product);
        // print_r($_product);
        break;
    case 'delete':
        $id = $_GET['id'];
        delete($id);
        header('Location: index.php');
        break;
    case 'getalltagandcate':
        $tags = TagModel::getAllTag();
        $cates = CategoryModel::getAllCate();
        $title = 'Add new product';
        include '../views/form.php';
        break;
    case 'updateform':
        $productUpdate = ProductModel::getProductById($_GET['id']);
        $tags = TagModel::getAllTag();
        $cates = CategoryModel::getAllCate();
        // print_r($product); 
        $title = 'Update product';
        include '../views/edit.php';
        break;
    default:
        $products = ProductModel::getAllProduct(isset($_GET['limit']) ? $_GET['limit'] : 3, isset($_GET['offset']) ? $_GET['offset'] : 0);
        include '../views/list.php';
        break;
    }
    
    // define some func
    function getDataInputForm() {
        $product = new Product();

        $product = new Product();
        $id = $_GET['id'];
        $sku = $_POST['sku'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $salePrice = $_POST['sale-price'];
        $featuredImg = $_FILES['featuredimg']['name'];
        $desc = $_POST['desc'];
        // $createdDate = date('Y-m-d');
        // $modifiedDate = $createdDate;

        $selectedOptionTag = array_unique($_POST["mySelectTag"]);
        foreach ($selectedOptionTag as $tag) {
            $tagSelected[] = $tag;
        }

        $selectedOptionCate = array_unique($_POST["mySelectCate"]);
        foreach ($selectedOptionCate as $cate) {
            $cateSeleted[] = $cate;
        }

        $selectedFiles = $_FILES['gallary'];
        for ($i = 0; $i < count($selectedFiles['name']); $i++) {
            $galS[] = $selectedFiles['name'][$i];
        }
        $product->setId($id);
        $product->setSku($sku);
        $product->setTitle($title);
        $product->setPrice($price);
        $product->setSalePrice($salePrice);
        $product->setFeaturedImage($featuredImg);
        $product->setDescription($desc);
        // $product->setCreatedDate($createdDate);
        $product->setTag($tagSelected);
        $product->setCategory($cateSeleted);
        $product->setGallery($galS);
        // $product->setModifiedDate($modifiedDate);

        return $product;
    }

    function add($_product) {
        // $_product = getDataInputForm();
        
        ProductModel::addProduct($_product);

        // upload file
        $target_dir = '../assets/img';

        $target_file = $target_dir . $_product->getFeaturedImage();
        move_uploaded_file($_FILES["featuredimg"]["tmp_name"], $target_file);


        $selectedOptionTag = $_product->getTag();
        foreach ($selectedOptionTag as $tag) {
            ProductModel::addProductTags(TagModel::getIdOfTag($tag));
        }

        $selectedOptionCate = $_product->getCategory();
        foreach ($selectedOptionCate as $cate) {
            ProductModel::addProductCates(CategoryModel::getIdOfCate($cate));
        }

        $selectedFiles = $_product->getGallery();
        $selectedPathFiles = $_FILES['gallary']['tmp_name'];
        // Lặp qua danh sách các tệp tin được chọn
        for ($i = 0; $i < count($selectedFiles); $i++) {
            ProductModel::addGallery($selectedFiles[$i]);
            $target_file = $target_dir . $selectedFiles[$i];
            move_uploaded_file($selectedPathFiles[$i], $target_file);
        }
    }

    function delete($id) {
        ProductModel::deleteProductTags($id);
        ProductModel::deleteProductCates($id);
        ProductModel::deleteProductGalleries($id);
        ProductModel::deleteProduct($id);
    }

    function update($_product) {
        $proId = $_product->getId();
        ProductModel::updateProduct($proId, $_product);
        $arrTagU = $_product->getTag();
        foreach ($arrTagU as $tag) {
            echo $tag;
            // ProductModel::deleteProductTags($proId);
            // ProductModel::addProductTags(TagModel::getIdOfTag($tag));
            ProductModel::updateProductTags($proId, TagModel::getIdOfTag($tag));
        }

        $arrCateU = $_product->getCategory();
        foreach ($arrCateU as $cate) {
            echo $cate;
            // ProductModel::deleteProductCates($proId);
            // ProductModel::addProductCates(CategoryModel::getIdOfCate($cate));
            ProductModel::updateProductCates($proId, CategoryModel::getIdOfCate($cate));
        }

        // $arrGalleryU = $_product->getGallery();
        // foreach ($arrGalleryU as $gallery) {
        //     // echo $gallery;
        //     ProductModel::deleteProductGalleries($proId);
        //     ProductModel::addGallery($gallery);
        // }
    }

    function addproperty($tagName, $cateName) {
        TagModel::addTag($tagName);
        CategoryModel::addCate($cateName);   
    }