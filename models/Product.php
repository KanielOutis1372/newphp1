<?php 
    class Product {
        private $id;
        private $sku;
        private $title;
        private $price;
        private $salePrice;
        private $featuredImage;
        private $gallery;
        private $category;
        private $tag;
        private $description;
        private $createdDate;
        private $modifiedDate;

        function __construct() { }
        
        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        } 

        public function setSku($sku) {
            $this->sku = $sku;
        }   
        
        public function getSku() {
            return $this->sku;
        }
        
        public function setTitle($title) {
            $this->title = $title;
        }   

        public function getTitle() {
            return $this->title;
        }

        public function setPrice($price) {
            $this->price = $price;
        }   

        public function getPrice() {
            return $this->price;
        }

        public function setSalePrice($salePrice) {
            $this->salePrice = $salePrice;
        }

        public function getSalePrice() {
            return $this->salePrice;
        }
        
        public function setFeaturedImage($featuredImage) {
            $this->featuredImage = $featuredImage;
        }

        public function getFeaturedImage() {
            return $this->featuredImage;
        }   

        public function setGallery($gallery) {
            $this->gallery = $gallery;
        }

        public function getGallery() {
            return $this->gallery;
        }

        public function setCategory($category) {
            $this->category = $category;
        }

        public function getCategory() {
            return $this->category;
        }
        
        public function setTag($tag) {
            $this->tag = $tag;
        }
        
        public function getTag() {
            return $this->tag;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function getDescription() {
            return $this->description;
        }

        public function setCreatedDate($createdDate) {
            $this->createdDate = $createdDate;
        }
        
        public function getCreatedDate() {
            return $this->createdDate;
        }
        
        public function setModifiedDate($modifiedDate) {
            $this->modifiedDate = $modifiedDate;
        }
        
        public function getModifiedDate() {
            return $this->modifiedDate;
        }

    }   

?>