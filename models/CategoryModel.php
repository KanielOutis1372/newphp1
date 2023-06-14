<?php
require_once 'Category.php';

class CategoryModel
{
    public static $db;

    public function __construct() {
        self::connectDB();
    }

    private static function connectDB()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_huy2";
        self::$db = new mysqli($servername, $username, $password, $dbname);
    }

    static function getAllCate() {
        self::connectDB();
        $query = 'SELECT CategoryName FROM Categories';
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = array();
        while ($row = $result->fetch_assoc()) {
            $cate = new Category();
            $cate->setCateName($row['CategoryName']);
            array_push($list, $cate);
        }
        return $list;
    }

    static function getIdOfCate($cateName) {
        self::connectDB();
        $query = 'SELECT CategoryId FROM CATEGORIES WHERE CategoryName = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $cateName);
        $stmt->execute();
        $result = $stmt->get_result();
        $cateId = $result->fetch_assoc()['CategoryId'];
        return $cateId;
    }

    static function addCate($cateName) {
        self::connectDB();
        $query = 'INSERT INTO CATEGORIES (CategoryName) VALUES (?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $cateName);
        $stmt->execute();
    }
}
// print_r(CategoryModel::getIdOfCate('Cate 1'));