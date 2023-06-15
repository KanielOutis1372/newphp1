<?php
require_once '../models/ProductModel.php';
require_once '../models/TagModel.php';
require_once '../models/CategoryModel.php';
require_once '../models/Product.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
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
    case 'update':
        update();
        header('Location: index.php');
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
        $title = 'Update product';
        include '../views/edit.php';
        break;

    case 'filter':
        // $_POST['date'];
        $dateSelected = $_POST['date'];
        $cateSelected = $_POST['cate'];
        $tagSelected = $_POST['tag'];
        $ascSelected = $_POST['asc'];
        $startdaySelected = $_POST['startday'];
        $enddaySelected = $_POST['endday'];
        $pricefrom = $_POST['pricefrom'];
        $priceto = $_POST['priceto'];
        filter($dateSelected, $cateSelected, $tagSelected, $ascSelected, $startdaySelected, $enddaySelected, $pricefrom, $priceto);
        break;
    default:
        $products = ProductModel::getAllProduct(isset($_GET['limit']) ? $_GET['limit'] : 8, isset($_GET['offset']) ? $_GET['offset'] : 0);
        $tags   = TagModel::getAllTag();
        $cates  = CategoryModel::getAllCate();

        include '../views/list.php';
        break;
}

// define func
function getDataInputForm()
{
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
    $product->setTag($tagSelected);
    $product->setCategory($cateSeleted);
    $product->setGallery($galS);

    return $product;
}

function add($_product)
{

    ProductModel::addProduct($_product);

    // upload file
    $target_dir = '../assets/img/';

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

function delete($id)
{
    ProductModel::deleteProductTags($id);
    ProductModel::deleteProductCates($id);
    ProductModel::deleteProductGalleries($id);
    ProductModel::deleteProduct($id);
}

function update()
{
    $_product = getDataInputForm();
    $productUpdate = ProductModel::getProductById($_GET['id']);
    $_product = getDataInputForm();
    $_product->setModifiedDate(date('Y-m-d'));
    // print_r($_product);
    // print_r($productUpdate);

    $proId = $_product->getId();

    if (!empty($_product->getFeaturedImage())) {
        ProductModel::updateProduct($proId, $_product);
    } else {
        $_product->setFeaturedImage($productUpdate->getFeaturedImage());
        ProductModel::updateProduct($proId, $_product);
    }

    $arrTagU = $_product->getTag();
    ProductModel::deleteProductTags($proId);
    foreach ($arrTagU as $tag) {
        ProductModel::updateProductTags($proId, TagModel::getIdOfTag($tag));
    }

    $arrCateU = $_product->getCategory();
    ProductModel::deleteProductCates($proId);
    foreach ($arrCateU as $cate) {
        ProductModel::updateProductCates($proId, CategoryModel::getIdOfCate($cate));
    }

    $arrGalleryU = $_product->getGallery();
    if (!empty($arrGalleryU) && !empty($arrGalleryU[0])) {
        ProductModel::deleteProductGalleries($proId);
        foreach ($arrGalleryU as $gallery) {
            ProductModel::addGallery($gallery);
        }
    }
}

function addproperty($tagName, $cateName)
{
    TagModel::addTag($tagName);
    CategoryModel::addCate($cateName);
}

function filter($dateSelected, $cateSelected, $tagSelected, $asc, $startday, $endday, $pricefrom, $priceto)
{

    $pricefrom = intval($pricefrom);
    $priceto = intval($priceto);
    $startday = date('Y-m-d', strtotime($startday));
    $endday = date('Y-m-d', strtotime($endday));

    // echo $cateSelected;
    
    $qrbuilder = 'SELECT P.ID, P.SKU, P.Title, P.Price, P.FeaturedImage, P.Description, P.CreatedDate, P.ModifiedDate,
                    GROUP_CONCAT(DISTINCT C.CategoryName) AS Categories,
                    GROUP_CONCAT(DISTINCT T.TagName) AS Tags,
                    GROUP_CONCAT(DISTINCT G.ImageURL) AS ImageURLs
                    FROM Products P
                    INNER JOIN ProductCategories PC ON P.ID = PC.ProductID
                    INNER JOIN Categories C ON PC.CategoryID = C.CategoryID
                    INNER JOIN ProductTags PT ON P.ID = PT.ProductID
                    INNER JOIN Tags T ON PT.TagID = T.TagID
                    INNER JOIN Gallery G ON P.ID = G.ProductID WHERE 1 = 1';
    if (!empty($dateSelected)) {
        $qrbuilder .= " AND P.CreatedDate = '$dateSelected'";
    }
    if (!empty($cateSelected)) {
        $qrbuilder .= " AND C.CategoryName = '$cateSelected'";
    }
    if (!empty($tagSelected)) {
        $qrbuilder .= " AND T.TagName = '$tagSelected'";
    }
    if (!empty($startday)) {
        $qrbuilder .= ' AND P.CreatedDate >= ' . $startday;
    }
    if (!empty($endday)) {
        $qrbuilder .= ' AND P.CreatedDate <= '. $endday;
    }
    if (!empty($pricefrom)) {
        $qrbuilder .= ' AND P.Price >= ' . $pricefrom;
    }
    if (!empty($priceto)) {
        $qrbuilder .= ' AND P.Price <= ' . $priceto;
    }

    $qrbuilder .= ' GROUP BY P.ID;';

    // if (!empty($esc)) {
    //     $qrbuilder .= $asc;
    // }

    // $result = [];
    // echo $qrbuilder;
    $result = ProductModel::getAllProductNoLimit($qrbuilder);
    print_r($result);
}
