<?php
    class Category {
        private $cateId;
        private $cateName;

        public function __construct() {
            
        }
        public function getCateId() {
            return $this->cateId;
        }
        public function setCateId($cateId) {
            $this->cateId = $cateId;
        }
        public function getCateName() {
            return $this->cateName;
        }
        public function setCateName($cateName) {
            $this->cateName = $cateName;
        }
    } 
?>