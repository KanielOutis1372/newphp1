<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <link rel="stylesheet" href="../lib/Semantic-UI-CSS-master/semantic.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="ui equal width grid">
    <div class="row">
      <div class="column">
        <a href="../controllers/index.php?action=getalltagandcate"><button class="ui primary button">Add product</button></a>
        <a href="../views/addproperty.php"><button class="ui button">Add property</button></a>
        <a href="#"><button class="ui button">Sync from VillaTheme</button></a>
      </div>
      <div class="column">
        <div class="ui icon input">
          <input type="text" placeholder="Search...">
          <i class="inverted circular search link icon"></i>
        </div>
      </div>
    </div>

    <div class="row">

      <form class="ui form demo" action="../controllers/index.php?action=filter" method="POST" enctype="multipart/form-data">

        <div class="column">
          <select class="ui dropdown" name="date">
            <option value="">Date</option>
            <?php
            foreach ($products as $value) {
              echo '<option value="'. $value->getCreatedDate() .'">' . $value->getCreatedDate() . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="column">
          <select class="ui dropdown" name="asc">
            <option value="">ASC</option>
            <option value="Increase">Increase</option>
            <option value="Decrease">Decrease</option>
          </select>
        </div>

        <div class="column">
          <select class="ui dropdown" name="cate">
            <option value="">Category</option>
            <?php
            foreach ($cates as $cate) {
              echo '<option value="'. $cate->getCateName() .'">' . $cate->getCateName() . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="column">
        <select class="ui dropdown" name="tag">
            <option value="">Select tag</option>
            <?php
            
            foreach ($tags as $tag) {
              echo '<option value="'. $tag->getTagName() .'">' . $tag->getTagName() . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="column">
          <div class="ui calendar list" id="standard_calendar">
            <div class="ui fluid input">
              <input type="date" id="birthday" name="startday">
            </div>
          </div>
        </div>

        <div class="column">
          <div class="ui calendar list" id="standard_calendar">
            <div class="ui fluid input">
              <input type="date" id="birthday" name="endday">
            </div>
          </div>
        </div>

        <div class="column">
          <div class="ui input list">
            <input type="number" placeholder="Price from" name="pricefrom">
          </div>
        </div>

        <div class="column">
          <div class="ui input list">
            <input type="number" placeholder="Price to" name="priceto">
          </div>
        </div>

        <div class="column">
          <button class="ui button">Filter</button>
        </div>
      </form>
    </div>
  </div>

  <table class="ui celled table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Product name</th>
        <th>SKU</th>
        <th>Price</th>
        <th>Feature Image</th>
        <th>Gallery</th>
        <th>Categories</th>
        <th>Tags</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $value) : ?>
        <tr>
          <td><?php echo $value->getCreatedDate() ?></td>
          <td><?php echo $value->getTitle() ?></td>
          <td><?php echo $value->getSku() ?></td>
          <td><?php echo '&#36;' . $value->getPrice() ?></td>
          <td><?php echo '<img width="80px" src="' . '../assets/img/' . $value->getFeaturedImage() . '">' ?></td>
          <td>
            <?php
            $galleryArr = explode(',', $value->getGallery());
            foreach ($galleryArr as $gallery) {
              echo '<img width="80px" src="' . '../assets/img/' . $gallery . '">';
            }
            ?>
          </td>
          <td><?php echo $value->getCategory() ?></td>
          <td><?php echo $value->getTag() ?></td>
          <td>
            <a href="../controllers/index.php?action=updateform&id=<?php echo $value->getId() ?>"><i class="edit icon"></i></a>
            <a href="../controllers/index.php?action=delete&id=<?php echo $value->getId() ?>"><i class="trash icon"></i></a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <div class="center">
    <div class="pagination">
      <a href="#">&laquo;</a>
      <a href="../controllers/index.php?limit=8&offset=0">1</a>
      <a href="../controllers/index.php?limit=8&offset=8">2</a>
      <a href="../controllers/index.php?limit=8&offset=16">3</a>
      <a href="#">&raquo;</a>
    </div>
  </div>
</body>

</html>