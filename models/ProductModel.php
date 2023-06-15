<?php
require_once 'Product.php';
class ProductModel {
    public static $db;

    public function __construct() {
        
        self::connectDB();
        // Create connection
        
    }

    private static function connectDB()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_huy2";
        self::$db = new mysqli($servername, $username, $password, $dbname);
        // Thiết lập kết nối cơ sở dữ liệu
    }

    static function getAllProductNoLimit($qrbuilder) {
        self::connectDB();
        $stmt = self::$db->prepare($qrbuilder);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = array();
        while ($row = $result->fetch_assoc()) {
            $product = new Product();
            $product->setId($row['ID']);
            $product->setSku($row['SKU']);
            $product->setTitle($row['Title']);
            $product->setPrice($row['Price']);
            $product->setFeaturedImage($row['FeaturedImage']);
            $product->setDescription($row['Description']);
            $product->setCreatedDate($row['CreatedDate']);
            $product->setModifiedDate($row['ModifiedDate']);
            $product->setCategory($row['Categories']);
            $product->setTag($row['Tags']);
            $product->setGallery($row['ImageURLs']);
            array_push($list, $product);
        }
        return $list;
    }

    static function getAllProduct($limit, $offset) {
        self::connectDB();
        $query = 'SELECT P.ID, P.SKU, P.Title, P.Price, P.FeaturedImage, P.Description, P.CreatedDate, P.ModifiedDate,
                GROUP_CONCAT(DISTINCT C.CategoryName) AS Categories,
                GROUP_CONCAT(DISTINCT T.TagName) AS Tags,
                GROUP_CONCAT(DISTINCT G.ImageURL) AS ImageURLs
                FROM Products P
                LEFT JOIN ProductCategories PC ON P.ID = PC.ProductID
                LEFT JOIN Categories C ON PC.CategoryID = C.CategoryID
                LEFT JOIN ProductTags PT ON P.ID = PT.ProductID
                LEFT JOIN Tags T ON PT.TagID = T.TagID
                LEFT JOIN Gallery G ON P.ID = G.ProductID
                GROUP BY P.ID' . ' LIMIT ' . $limit . ' OFFSET ' . $offset.';';
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = array();
        while ($row = $result->fetch_assoc()) {
            $product = new Product();
            $product->setId($row['ID']);
            $product->setSku($row['SKU']);
            $product->setTitle($row['Title']);
            $product->setPrice($row['Price']);
            $product->setFeaturedImage($row['FeaturedImage']);
            $product->setDescription($row['Description']);
            $product->setCreatedDate($row['CreatedDate']);
            $product->setModifiedDate($row['ModifiedDate']);
            $product->setCategory($row['Categories']);
            $product->setTag($row['Tags']);
            $product->setGallery($row['ImageURLs']);
            array_push($list, $product);
        }
        return $list;
    }

    //add product
    static function getLastProductId() {
        self::connectDB();
        $query = 'SELECT MAX(ID) AS ID FROM Products';
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = new Product();
        while ($row = $result->fetch_assoc()) {
            $product->setId($row['ID']);
        }
        return $product->getId();
    }

    static function addProduct($product) {
        self::connectDB();
        $sku = $product->getSku();
        $title = $product->getTitle();
        $price = $product->getPrice();
        $salePrice = $product->getSalePrice();
        $featuredImage = $product->getFeaturedImage();
        $description = $product->getDescription();
        $createdDate = $product->getCreatedDate();
        $modifiedDate = $product->getModifiedDate();
        $query = 'INSERT INTO Products (SKU, Title, Price, SalePrice, FeaturedImage, Description, CreatedDate, ModifiedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ssddssss', $sku, $title, $price, $salePrice, $featuredImage, $description, $createdDate, $modifiedDate);
        $stmt->execute();
    }


    static function addProductTags($tagId) {
        self::connectDB();
        $lastProductId = ProductModel::getLastProductId();
        $query = 'INSERT INTO PRODUCTTAGS (ProductID, TagID) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $lastProductId, $tagId);
        $stmt->execute();
    }

    static function addProductCates($categoryId) {
        self::connectDB();
        $lastProductId = ProductModel::getLastProductId();
        $query = 'INSERT INTO PRODUCTCATEGORIES (ProductID, CategoryID) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $lastProductId, $categoryId);
        $stmt->execute();
    }

    static function addGallery($imgName) {
        self::connectDB();
        $lastProductId = ProductModel::getLastProductId();
        $query = 'INSERT INTO GALLERY (ProductID, ImageURL) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('is', $lastProductId, $imgName);
        $stmt->execute();
    }


    //delete product
    static function deleteProduct($productId) {
        self::connectDB();
        $query = 'DELETE FROM PRODUCTS WHERE ID = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
    }
    static function deleteProductTags($productId) {
        self::connectDB();
        $query = 'DELETE FROM PRODUCTTAGS WHERE ProductID = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
    }
    static function deleteProductCates($productId) {
        self::connectDB();
        $query = 'DELETE FROM PRODUCTCATEGORIES WHERE ProductID = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
    }
    static function deleteProductGalleries($productId) {
        self::connectDB();
        $query = 'DELETE FROM GALLERY WHERE ProductID = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
    }

    //update product
    static function getProductById($productId) {
        self::connectDB();
        $query = 'SELECT P.ID, P.SKU, P.Title, P.Price, P.SalePrice, P.FeaturedImage, P.Description, P.CreatedDate, P.ModifiedDate,
                    GROUP_CONCAT(DISTINCT C.CategoryName) AS Categories,
                    GROUP_CONCAT(DISTINCT T.TagName) AS Tags,
                    GROUP_CONCAT(DISTINCT G.ImageURL) AS ImageURLs
                    FROM Products P
                    LEFT JOIN ProductCategories PC ON P.ID = PC.ProductID
                    LEFT JOIN Categories C ON PC.CategoryID = C.CategoryID
                    LEFT JOIN ProductTags PT ON P.ID = PT.ProductID
                    LEFT JOIN Tags T ON PT.TagID = T.TagID
                    LEFT JOIN Gallery G ON P.ID = G.ProductID
                    WHERE P.ID = ?
                    GROUP BY P.ID';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = new Product();
        while ($row = $result->fetch_assoc()) {
            $product->setId($row['ID']);
            $product->setTitle($row['Title']);
            $product->setSku($row['SKU']);
            $product->setPrice($row['Price']);
            $product->setSalePrice($row['SalePrice']);
            $product->setFeaturedImage($row['FeaturedImage']);
            $product->setDescription($row['Description']);
            $product->setTag($row['Tags']);
            $product->setCategory($row['Categories']);
            $product->setGallery($row['ImageURLs']);
        }
        return $product;
    }

    static function updateProduct($id, $product) {
        self::connectDB();
        $id = $product->getId();
        $title = $product->getTitle();
        $sku = $product->getSku();
        $price = $product->getPrice();
        $salePrice = $product->getSalePrice();
        $featuredImage = $product->getFeaturedImage();
        $description = $product->getDescription();
        $modifiedDate = $product->getModifiedDate();
        $query = 'UPDATE Products SET Title =?, SKU =?, Price =?, SalePrice =?, FeaturedImage =?, Description =?, ModifiedDate = ? WHERE ID =?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ssiisssi', $title, $sku, $price, $salePrice, $featuredImage, $description, $modifiedDate, $id);
        $stmt->execute();
    }

    static function updateProductTags($productId, $tagId) {
        self::connectDB();
        $query = 'INSERT INTO PRODUCTTAGS (ProductID, TagID) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $productId, $tagId);
        $stmt->execute();
    }

    static function updateProductCates($productId, $cateId) {
        self::connectDB();
        $query = 'INSERT INTO PRODUCTCATEGORIES (ProductID, CategoryID) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $productId, $cateId);
        $stmt->execute();
    }

    static function updateProductGallery($productId, $imgUrl) {
        self::connectDB();
        $query = 'UPDATE Gallery SET ImageURL = ? WHERE ProductID = ? AND ImageID = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('sii', $imgUrl, $productId);
        $stmt->execute();   
    }

    //filter
    static function filterDate($date) {
        
    }
}

// print_r(ProductModel::updateProductGallery(29, 50, 'tfm3.jpg'));