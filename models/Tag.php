<?php
    class Tag {
        private $tagId;
        private $tagName;
        
        function __construct() {
            
        }

        function setId($tagId) {
            $this->tagId = $tagId;
        }
        
        function getId() {
            return $this->tagId;
        }
        
        function setTagName($tagName) {
            $this->tagName = $tagName;
        }
        
        function getTagName() {
            return $this->tagName;
        }
    }
?>