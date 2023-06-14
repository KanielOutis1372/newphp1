
<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../lib/Semantic-UI-CSS-master/semantic.min.css">
    <script src="../lib/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script src="../lib/Semantic-UI-CSS-master/semantic.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php 
    // print_r($productUpdate)
    ?>
    <div class="ui equal width grid"> 
        <div class="row">
            <div class="column">
                <h1><?php echo $title?></h1>
            </div>
            <div class="column">
                <a href="../controllers/index.php"><button class="ui primary button pull-right">Cancel</button></a>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <form class="ui form" action="../controllers/index.php?action=add" method="POST" enctype="multipart/form-data">
                    <div class="field">
                        <div class="two fields">
                            <div class="field">
                                <label for="skuId">SKU</label>
                                <input  type="text" id="skuId" name="sku" placeholder="SKU...">
                            </div>
                            <div class="field">
                                <label for="titleId">TITLE</label>
                                <input  type="text" id="titleId" name="title" placeholder="title...">
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="priceId">PRICE</label>
                                <input  type="number" id="priceId" name="price" placeholder="price...">
                            </div>
                            <div class="field">
                                <label for="salepriceId">SALE PRICE</label>
                                <input  type="number" id="salepriceId" name="sale-price" placeholder="sale price...">
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="featuredimgId">FEAETURED IMAGE</label>
                                <input  type="file" id="featuredimgId" name="featuredimg">
                            </div>
                            <div class="field">
                                <label for="gallariesId">GALLARIES</label>
                                <input  type="file" id="gallariesId" name="gallary[]" multiple>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>TAGS</label>

                                <select  multiple="" class="ui dropdown" name="mySelectTag[]">
                                    <option value="">Select Tag</option>
                                    
                                    <?php
                                        foreach ($tags as $tag) {
                                            echo '<option value="' . $tag->getTagName() . '">' . $tag->getTagName() . '</option>';
                                        }
                                    ?>
                                </select>

                            </div>

                            <div class="field">
                                <label>CATEGORIES</label>

                                <select  multiple="" class="ui dropdown" name="mySelectCate[]">
                                    <option value="">Select Category</option>
                                    <?php
                                        foreach ($cates as $cate) {
                                            echo '<option value="' . $cate->getCateName() . '">' . $cate->getCateName() . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="field">
                            <label for="descId">DESCRIPTION</label>
                            <textarea  name="desc" id="descId" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <button class="ui button" type="submit" name="submit">Add</button>
                </form>
            </div>
        </div>

        <script>
            $('select.dropdown').dropdown();
        </script>
    </div>
</body>

</html>
</body>
</html>