<?php

include("includes/init.php");

$sql_query_entries = "SELECT * FROM entries";
$sql_query_tags = "SELECT * FROM tags";
$filter_tag_param = array();

$edit_authorization = False;
if ($is_admin) {
  $edit_authorization = True;
}

if (isset($_GET["tag"])) {
  $filter_tag = trim($_GET["tag"]);
  if ($filter_tag) {
    $sql_query_entries = "SELECT entries.id, entries.food, entries.description, entries.file_ext, tags.tag FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE tag_id = :tag_id";
    $filter_tag_param = array(":tag_id" => $filter_tag);
  }
}

// ----------------------Add new entry----------------------
// create sticky variables for add entry form
$sticky_food = "";
$sticky_price = "";
$sticky_description = "";
$sticky_citation = "";

// feedback for add entry form
$food_feedback_css = "hidden";
$price_feedback_css = "hidden";
$description_feedback_css = "hidden";
$file_feedback_css = "hidden";
$add_invalid_feedback_css = "hidden";

// define max file size
$add_entry_confirmation = False;
define("MAX_FILE_SIZE", 2000000);

$records_tags = exec_sql_query(
  $db,
  $sql_query_tags
)->fetchAll();

// sticky tags list array
$sticky_tags = array();
foreach ($records_tags as $records_tag) {
  $current_tag = $records_tag["id"];
  $sticky_tags[$current_tag] = "";
}

// if  user submits add entry form
if (isset($_POST["add_entry"])) {

  $form_valid = True;

  // tainted
  $food = ucfirst(trim($_POST['food']));
  $price = number_format((float)trim($_POST['price']), 2);
  $description = trim($_POST['description']);
  $citation = trim($_POST['citation']);
  $upload = $_FILES["image_file"];

  // if uploads error, form is invalid
  if ($upload['error'] == UPLOAD_ERR_OK) {
    $upload_filename = basename($upload['name']);
    $upload_ext = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));

    if (!in_array($upload_ext, array("jpeg", "jpg", "png"))) {
      $form_valid = False;
      $file_feedback_css = "";
    }
  } else {
    $form_valid = False;
    $file_feedback_css = "";
  }

  // if inputs are empty, form invalid
  if (empty($food)) {
    $food_feedback_css = "";
    $form_valid = False;
  }

  if (empty($price)) {
    $price_feedback_css = "";
    $form_valid = False;
  }

  if (empty($description)) {
    $description_feedback_css = "";
    $form_valid = False;
  }

  // if form valid, insert into db
  if ($form_valid) {
    $add_entry_confirmation = True;

    $db->beginTransaction();

    $result = exec_sql_query(
      $db,
      "INSERT INTO entries (food, description, price, citation, file_ext) VALUES(:food, :description, :price, :citation, :file_ext)",
      array(
        ':food' => $food,
        ':description' => $description,
        ':price' => $price,
        ':citation' => $citation,
        ':file_ext' => $upload_ext
      )
    );

    // save new entry img and move to uploads folder from temp location
    if ($result) {
      $entry_id = $db->lastInsertId('id');
      $id_filename = "public/uploads/entries/" . $entry_id . "." . $upload_ext;
      move_uploaded_file($upload["tmp_name"], $id_filename);

      // insert new entry's tag into tags db
      foreach ($records_tags as $records_tag) {
        $records_tag = $records_tag["id"];

        if ($_POST[$records_tag]) {
          $current_tag = $_POST[$records_tag];
          exec_sql_query(
            $db,
            "INSERT INTO entry_tags (entry_id, tag_id) VALUES (:entry_id, :tag_id);",
            array(
              "entry_id" =>  $entry_id,
              "tag_id" => $current_tag
            )
          );
        }

      }
    }

    $db->commit();

  // if form not valid, save user input to sticky
  } else {

  $add_invalid_feedback_css = "";

    // tainted
    $sticky_food = $food;
    $sticky_price = $price;
    $sticky_description = $description;
    $sticky_citation = $citation;
    foreach ($records_tags as $records_tag) {
      $current_tag = $records_tag["id"];

      if ($_POST[$current_tag]) {
        $sticky_tags[$current_tag] = "checked";
      } else {
        $sticky_tags[$current_tag] = "";
      }
    }
  }
}

// ----------------------Add Tag----------------------
$add_tag_feedback_css = "hidden";
$add_tag_confirmation = False;

// if user submit add tag form
if (isset($_POST["submit_add_tag"])) {
  $new_tag = ucfirst(trim($_POST['add_tag']));
  $form_valid = True;

  // if input is empty, form invalid
  if (empty($new_tag)) {
    $form_valid = False;
    $add_tag_feedback_css = "";
    $add_invalid_feedback_css = "";
  }

  // if new tag is not unique, form invalid
  $is_duplicate = exec_sql_query(
    $db,
    "SELECT * FROM tags where (tag = :tag)",
    array(
      ":tag" => $new_tag
    )
  )->fetchAll();
  if ($is_duplicate) {
    $form_valid = False;
    $add_tag_feedback_css = "";
    $add_invalid_feedback_css = "";
  }

  // if form is valid, insert new tag into db
  if ($form_valid) {
    $add_tag_confirmation = True;
    exec_sql_query(
      $db,
      "INSERT INTO tags (tag) VALUES (:tag);",
      array(
        "tag" =>  $new_tag
      )
    );
  }
}

$records_tags = exec_sql_query(
  $db,
  $sql_query_tags
)->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Oishii Bowl</title>

  <link rel="stylesheet" type="text/css" href="public/styles/theme.css" media="all"/>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <?php include("includes/nav.php"); ?>

  <main>

    <?php
    // Add tag & entry confirmation message
    if ($add_entry_confirmation) {
    ?>
      <section>
        <p class="notice">*NEW ITEM SUCCESSFULLY ADDED!</p>
      </section>
    <?php
    }
    if ($add_tag_confirmation) { ?>
      <section>
        <p class="notice">*NEW TAG SUCCESSFULLY ADDED!</p>
      </section>
    <?php } ?>

    <p class="notice <?php echo
          $add_invalid_feedback_css; ?>">Your new add was NOT successful. <a href="/#employee-add">Click here to try again</a></p>

    <h2>Our Signature Items</h2>

    <?php

    // Tag Filtering
    $records_entries = exec_sql_query(
      $db,
      $sql_query_entries,
      $filter_tag_param
    )->fetchAll();
    ?>

    <!-- Tags side bar -->
    <div class="signature-page">
      <div class="tags-bar">

        <a href="/">All Items</a>

        <?php foreach ($records_tags as $records_tag) {
          $tag_name = $records_tag['tag'];
          $tag_id = $records_tag["id"];
          // $tag_param = str_replace(' ', '-', strtolower($tag_name));
          ?>
          <a href="/?tag=<?php echo $tag_id ?>"><?php echo ucfirst($tag_name) ?></a>
        <?php } ?>

        <a href="/#employee-add" class="edit-button">Employee? <br> Add new listings here</a>

      </div>

    <section class="gallery">
      <?php
      // query the database
      $records = exec_sql_query(
        $db,
        "SELECT * FROM entries ORDER BY id ASC;"
      )->fetchAll();

      // Only show the entries gallery if we have records to display.
      if (!empty($filter_tag)) { ?>

      <h3>
        <?php
        // show title of tag when filtered
        $tags_name = $filter_tag ? $tags_name . ucfirst(htmlspecialchars($records_entries[0]["tag"])) : $tags_name;
        echo $tags_name ?>
      </h3>

      <?php }
      // Show signature imgs
      if (count($records_entries) > 0) { ?>
        <ul>
          <?php
          foreach ($records_entries as $record) { ?>
            <li>
              <a href="/signature/entry?<?php echo http_build_query(array('id' => $record['id'])); ?>">
                <img src="/public/uploads/entries/<?php echo $record['id'] . '.' . $record['file_ext']; ?>" alt="<?php echo htmlspecialchars($record['food']); ?>" />
                <p><?php echo ucfirst($record['food']); ?></p>
              </a>
              <p class="description">✥ <?php echo ucfirst($record['description']); ?></p>
            </li>
          <?php
          } ?>
        </ul>
      <?php } else { ?>
        <p class="notice">We can't find any matched signature item.</p>
      <?php } ?>
    </section>

    </div>

    <div class="authorized-forms" id="employee-add">
      <?php

      // check if user is logged in for all add forms
      if (is_user_logged_in()) { ?>

        <?php
        // if user has edit authorization (is admin)
        if ($edit_authorization) { ?>
            <section>

            <!-- Add new tag form -->
            <form action="/" method="post" novalidate>
              <h3>Add New Tags</h3>
              <p class="feedback <?php echo $add_tag_feedback_css; ?>">Please enter a unique tag name</p>
              <div class="group_label_input">
                <label for="add_tag">Tag Name:</label>
                <input type="text" id="add_tag" name="add_tag" size="40">
              </div>
              <button type="submit" name="submit_add_tag" class="login-submit">Add Tag</button>
            </form>



            <!-- Add new entry form -->
            <form action='/' method="post" enctype="multipart/form-data" id="add_entry_form" novalidate>

              <h3>Add New Items</h3>

              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

              <p class="feedback <?php echo $file_feedback_css; ?>">Please select an image</p>
              <div class="group_label_input">
                <label for="image_file">Image File: </label>
                <input type="file" id="image_file" name="image_file" required />
              </div>

              <p id="food_feedback_css" class="feedback <?php echo $food_feedback_css; ?>">Please enter a valid item name</p>
              <div class="group_label_input">
                <label for="food">Title: </label>
                <input type="text" id="food" name="food" value="<?php echo htmlspecialchars($sticky_food)  ?>" size="40" required>
              </div>

              <p id="price_feedback_css" class="feedback <?php echo $price_feedback_css; ?>">Please enter a valid price</p>
              <div class="group_label_input">
                <label for="price">Price: </label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($sticky_price) ?>" required>
              </div>

              <p id="description_feedback_css" class="feedback <?php echo $description_feedback_css; ?>">Please enter a valid description</p>
              <div class="group_label_input">
                <label for="description">Description: </label>
                <textarea id="description" name="description" rows="4" cols="33" required><?php echo htmlspecialchars($sticky_description) ?></textarea>
              </div>

              <div class="group_label_input">
                <label for="citation">Citation: </label>
                <textarea id="citation" name="citation" rows="3" cols="33" placeholder="Optional"><?php echo htmlspecialchars($sticky_citation) ?></textarea>
              </div>

              <h4>Tags (Optional): </h4>
              <div class="choose-tags">
                <?php
                foreach ($records_tags as $records_tag) {
                  $current_tag = $records_tag["tag"];
                  $current_id = $records_tag["id"];
                  $checked = $sticky_tags[$current_id] ?>

                  <div class="group_label_input">

                    <input type="checkbox" id=<?php echo  $current_tag ?> name="<?php echo $current_id ?>" value="<?php echo  $current_id ?>" <?php echo $checked ?>>

                    <label for=<?php echo  $current_tag ?>><?php echo  $current_tag ?></label>

                  </div>

                <?php } ?>
              </div>
              <button type="submit" name="add_entry" class="login-submit">Add Item</button>

            </form>


          </section>
        <?php }
        } else { ?> <p class="notice">Employees please sign in to add new items!</p>
          <div class="sign-in">
            <a href="/login#forms" class="edit-button">Sign In</a>
          </div>

        <?php }

      ?>

    </div>

  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
