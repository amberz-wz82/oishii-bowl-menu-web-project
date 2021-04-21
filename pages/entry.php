<?php
include("includes/init.php");

// which entry should we show? get entry ID param
$entry_id = (int)trim($_GET['id']);
$url = "/signature/entry?" . http_build_query(array('id' => $entry_id));

$edit_mode = False;
$edit_authorization = False;

// are we in editing mode?
if (isset($_GET['edit'])) {
  $edit_mode = True;

  // edit param value is also entry ID
  $entry_id = (int)trim($_GET['edit']);
}

// find the entry record
if ($entry_id) {
  $records = exec_sql_query(
    $db,
    "SELECT * FROM entries WHERE id = :id;",
    array(':id' => $entry_id)
  )->fetchAll();
  if (count($records) > 0) {
    $entry = $records[0];
  } else {
    $entry = NULL;
  }
}
// Only continue if we have a valid entry
if ($entry) {

  // If user is admin, they can edit
  if ($is_admin) {
    $edit_authorization = True;

    // was the entry edited?
    if (isset($_POST['save'])) {
      $title = trim($_POST['title']); // untrusted
      $price = trim($_POST['price']); // untrusted
      $description = trim($_POST['description']); // untrusted

      // If title is not empty, update it.
      if (!empty($title)) {
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
        $records = exec_sql_query(
          $db,
          "SELECT * FROM entries WHERE id = :id;",
          array(':id' => $entry_id)
        )->fetchAll();
        $entry = $records[0];
      }
    }
  }

  // entry information
  $title = htmlspecialchars($entry['food']);
  $url = "/signature/entry?" . http_build_query(array('id' => $entry['id']));
  $edit_url = "/signature/entry?" . http_build_query(array('edit' => $entry['id']));
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

      <?php if ($entry) { ?>
        <div class="img-details">
          <img src="/public/uploads/entries/<?php echo $entry['id'] . '.' . $entry['file_ext']; ?>" alt="<?php echo htmlspecialchars($entry['title']); ?>" class="entry-img" />

          <?php if ($edit_authorization && $edit_mode) { ?>
            <!-- Note: form needs feedback messages. -->

              <form class="edit details" action="<?php echo $url; ?>" method="post" novalidate />

              <label> Title:
                <input type="text" name="title" value="<?php echo htmlspecialchars($entry['food']); ?>" required />
              </label>

              <label> Price:
                <input type="text" name="price" value="<?php echo htmlspecialchars($entry['price']); ?>" required />
              </label>

              <label> Description:
                <textarea name="description" required><?php echo htmlspecialchars($entry['description']); ?></textarea>
              </label>

              <button type="submit" name="save">Save</button>
              </form>

              <?php
              } else { ?>

              <div class="details">
                <h2 class="detail-block">
                  <?php echo htmlspecialchars($entry['food']);?>
                </h2>

                <p class="detail-block">
                  <?php echo '$'.htmlspecialchars($entry['price']);?>
                <p>

                <p class="detail-block">
                  <?php echo htmlspecialchars($entry['description']);?>
                <p>

                <cite class="detail-block">
                  Source: <a href="<?php echo htmlspecialchars($entry['citation']); ?>"><?php echo htmlspecialchars($entry['citation']); ?></a>
                </cite>

                <?php if ($edit_authorization) { ?>
                    <a href="<?php echo $edit_url; ?>" class="detail-block edit-button">Edit</a>
                  <?php } ?>
              </div>

        </div>

          <?php
        } ?>

        <?php
      } else { ?>
          <p><strong>The entry you were looking for does not exist.</strong> Try locating the entry from the <a href="/signature">entry listing</a>.</strong></p>
        <?php
      }

      if (!$is_admin) { ?>
      <p>Please sign in to edit this item.</p>
    <?php
      echo_login_form($url, $session_messages);
    }
    ?>
    </section>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
