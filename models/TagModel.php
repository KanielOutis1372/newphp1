<?php
require_once 'Tag.php';
class TagModel
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

    static function getAllTag() {
        self::connectDB();
        $query = 'SELECT TagName FROM Tags';
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $list = array();
        while ($row = $result->fetch_assoc()) {
            $tag = new Tag();
            $tag->setTagName($row['TagName']);
            array_push($list, $tag);
        }
        return $list;
    }

    static function getIdOfTag($tagName) {
        self::connectDB();
        $query = 'SELECT TagId FROM TAGS WHERE TagName = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $tagName);
        $stmt->execute();
        $result = $stmt->get_result();
        $tagId = $result->fetch_assoc()['TagId'];
        return $tagId;
    }

    // add properties tags
    static function addTag($tagName) {
        self::connectDB();
        $query = 'INSERT INTO TAGS (TagName) VALUES (?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $tagName);
        $stmt->execute();
    }
    
}
// echo(TagModel::getIdOfTag('Tag 3'));