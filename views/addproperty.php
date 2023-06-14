
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
                <h1>Add property</h1>
            </div>
            <div class="column">
                <a href="../controllers/index.php"><button class="ui primary button pull-right">Cancel</button></a>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <form class="ui form" action="../controllers/index.php?action=addproperty" method="POST" enctype="multipart/form-data">
                    <div class="field">
                            <div class="field">
                                <label for="skuId">TAG</label>
                                <input  type="text" id="skuId" name="tag" placeholder="tag..." >
                            <div class="field">
                                <label for="titleId">CATEGORY</label>
                                <input  type="text" id="titleId" name="category" placeholder="category..." >
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

    <?php 
        // print_r($tags);
    ?>
</body>

</html>