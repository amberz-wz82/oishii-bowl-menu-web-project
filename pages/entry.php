<?php
include("includes/init.php");

// which entry should we show? get entry ID param
$edit_mode = False;
$edit_authorization = False;
$deleted = False;

$empty_feedback_css = "hidden";

if (isset($_GET['id'])) {
  $entry_id = trim($_GET['id']);
// are we in editing mode?
} else if (isset($_GET['edit'])) {
  $edit_mode = True;
  // edit param value is also entry ID
  $entry_id = trim($_GET['edit']);
}

$url = "/signature/entry?" . http_build_query(array('id' => $entry_id));
$edit_url = "/signature/entry?" . http_build_query(array('edit' => $entry['id']));


// find the entry record
if ($entry_id) {

  $records = exec_sql_query(
    $db,
    "SELECT * FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE entries.id = :entry_id;",
    array(':entry_id' => $entry_id)
  )->fetchAll();

  $tags = exec_sql_query(
    $db,
    "SELECT * FROM tags"
  )->fetchAll();

  if (count($records) > 0) {
    $entry = $records;
  } else {
    $entry = NULL;
  }

  // Only continue if we have a valid entry
  if ($entry) {

    // If user is admin, they can edit
    if ($is_admin) {
      $edit_authorization = True;

      $db->beginTransaction();
      if (isset($_POST["delete"])) {
        $deleted = True;
        exec_sql_query(
          $db,
          "DELETE FROM entry_tags WHERE (entry_id = :entry_id);",
          array(
            "entry_id" => $entry_id
          )
        );
        exec_sql_query(
          $db,
          "DELETE FROM entries WHERE (id = :id);",
          array(
            "id" => $entry_id
          )
        );
      }

      // was the entry edited?
      if (isset($_POST['save'])) {
        $title = trim($_POST['title']); // untrusted
        $price = trim($_POST['price']); // untrusted
        $description = trim($_POST['description']); // untrusted

        // if inputs not empty, update entry and tags
        if (!empty($title) && !empty($price) && !empty($description)) {
          exec_sql_query(
            $db,
            "UPDATE entries SET food = :title, price = :price, description = :description WHERE (id = :id);",
            array(
              'id' => $entry_id,
              'title' => $title,
              'price' => $price,
              'description' => $description
            )
          );

          // get updated entry
          exec_sql_query(
            $db,
            "DELETE FROM entry_tags WHERE (entry_id = :entry_id);",
            array("entry_id" => $entry_id)
          );
        }

        // if title, price, description are empty, show feedback and revert change
        else {
          $empty_feedback_css = "";

          // get updated entry
          exec_sql_query(
            $db,
            "DELETE FROM entry_tags WHERE (entry_id = :entry_id);",
            array("entry_id" => $entry_id)
          );
        }

        // update tags
        foreach ($tags as $tag) {
          $tag = $tag["id"];
          if ($_POST[$tag]) {
            $add_tag_id = $_POST[$tag];
            exec_sql_query(
              $db,
              "INSERT INTO entry_tags (entry_id, tag_id) VALUES (:entry_id, :tag_id);",
              array(
                "entry_id" =>  $entry_id,
                "tag_id" => $add_tag_id
              )
            );
          }
        }

        $records = exec_sql_query(
          $db,
          "SELECT * FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE entries.id = :id;",
          array(':id' => $entry_id)
        )->fetchAll();

        $entry =  count($records) > 0 ? $records : NULL;

      }
      $db->commit();

    }
    $description = $entry[0]['description'];
    $price = $entry[0]['price'];
    $title = $entry[0]['food'];
    $citation = $entry[0]['citation'];

  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Oishii Bowl</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/theme.css" media="all"/>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <?php include("includes/nav.php"); ?>

  <main class="entry">
    <section>

      <?php
      if ($entry) {
        if ($deleted) { ?>
          <h4 class="notice">*YOU HAVE SUCCESSFULLY DELETED THE ITEM: <em><?php echo htmlspecialchars($title); ?></em>!</h4>
          <h4><a href='/'>Return to Signature Items</a></h4>
        <?php
        } else {
        ?>
        <p class="notice <?php echo
          $empty_feedback_css; ?>">*Please do not leave inputs blank.</p>
        <div class="img-details">
          <div class="entry-img-container">
            <img src="/public/uploads/entries/<?php echo $entry_id . '.' . $entry[0]['file_ext']; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="entry-img" />
          </div>

          <?php if ($edit_authorization && $edit_mode) { ?>
            <!-- Note: form needs feedback messages.!!!!!!!!! -->
              <form class="edit details" action="<?php echo $url; ?>" method="post" novalidate >

              <h3 id="edit-item-title">Edit Item</h3>
              <div class="group_label_input">
                <label for="title">Title:</label>
                <input type="text"  id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required />
              </div>

              <div class="group_label_input">
                <label for="price"> Price:</label>
                <input type="text"  id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required />
              </div>

              <div class="group_label_input">
                <label for="description"> Description: </label>
                <textarea  id="description" name="description"  rows="5" cols="18" required><?php echo htmlspecialchars($description); ?></textarea>
              </div>

              <h4>Tags:</h4>
              <div class="choose-tags">
                <?php
                foreach ($tags as $tag) {
                  $current_tag = $tag["tag"];
                  $current_id = $tag["id"];
                  $checked = exec_sql_query(
                    $db,
                    "SELECT * FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE entries.id = :id AND tags.tag = :tag;",
                    array(':id' => $entry_id, ':tag' => $current_tag)
                  )->fetchAll() ? "checked" : "";
                ?>
                  <div class="group_label_input">
                    <input type="checkbox" id="<?php echo $current_tag ?>" name="<?php echo $current_id ?>" value="<?php echo $current_id ?>" <?php echo $checked ?> />
                    <label for="<?php echo $current_tag ?>"><?php echo $current_tag ?></label>
                  </div>
                <?php } ?>
              </div>

              <button type="submit"
              id="save" name="save" class="detail-block edit-button save-button">Save</button>
              </form>

              <?php
              } else {
              ?>

              <div class="details">
                <h2 class="detail-block">
                  <?php echo htmlspecialchars($title);?>
                </h2>

                <div class="tags-container">
                  <ul>
                    <?php
                    foreach ($entry as $ent) {
                      echo "<li class=\"tag-box\">" . $ent["tag"] . "</li>";
                    };
                    ?>
                  </ul>
                </div>

                <p class="detail-block">
                  <?php echo '$'.htmlspecialchars($price);?>
                </p>

                <p class="detail-block">
                  <?php echo htmlspecialchars($description);?>
                </p>

                <p class="detail-block">
                  <a href="<?php echo htmlspecialchars($citation); ?>">Source</a>
                </p>

                <?php if ($edit_authorization) { ?>

                  <section>
                    <div class="entry-edit-buttons">

                    <form action="<?php echo $edit_url; ?>" method="get" novalidate>
                      <input type="hidden" name="edit" value="<?php echo $entry_id ?>">
                      <button type="submit" id="edit_entry" class="detail-block edit-button">Edit</button>
                    </form>

                    <form action="<?php echo $url ?>" method="post" novalidate>
                      <input type="hidden" id="delete" name="delete" value="<?php echo $entry_id ?>">
                      <button type="submit" name="delete_submit" id="delete_entry" class="detail-block delete-button">Delete</button>
                    </form>

                  </div>
                </section>

              <?php } ?>
              <h4><a href='/signature#nav-border'>Return to Signature Items</a></h4>
            <?php } ?>
          <?php }
         ?>

        </div>

      </div>

        <?php

      } else { ?>
          <p class="notice"><strong>The item you were looking for does not exist.</strong> Try locating the item from the <a href="/signature">item listing</a>.</strong></p>
        <?php
      }

    ?>
    </section>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
