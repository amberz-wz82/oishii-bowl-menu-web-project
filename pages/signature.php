<?php

include("includes/init.php");

$sql_query_entries = "SELECT * FROM entries";
$sql_query_tags = "SELECT * FROM tags";
$filter_tag_param = array();

if (isset($_GET["tag_id"])) {
  $filter_tag = trim($_GET["tag_id"]);
  if ($filter_tag) {
    $sql_query_entries = "SELECT entries.id, entries.food, entries.file_ext, tags.tag FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE tag_id = :tag_id";
    $filter_tag_param = array(":tag_id" => $filter_tag);
    };
}

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
    <h2>Our Signature Items</h2>
    <h3><?php $tag_name = $filter_tag_ ? $tag_name
    echo $tags_name ?></h3>

    <?php
    $records_entries = exec_sql_query($db, $sql_query_entries, $filter_tag_param)->fetchAll();
    ?>

    <section class="gallery">
      <?php
      // query the database for the grade records
      $records = exec_sql_query(
        $db,
        "SELECT * FROM entries ORDER BY id ASC;"
      )->fetchAll();

      // Only show the entries gallery if we have records to display.
      if (count($records) > 0) { ?>
        <ul>
          <?php
          foreach ($records as $record) { ?>
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
      <?php } ?>
    </section>
    <?php
    // if user is logged in
    if ($is_admin) { ?>
      <section>
        <form id="employee-form" action="/employee" method="post" novalidate>

          <p id="type_feedback" class="feedback <?php echo $type_feedback_class; ?>">*Please select a type for your new food entry.</p>
          <div class="label-input-pair">
            <label for="insert_type">FOOD TYPE:</label>
            <select id="insert_type" name="insert_type" required>
              <option value="" disabled <?php echo empty($sticky_type) ? 'selected' : ''; ?>>Choose Food Type</option>
              <?php
              foreach ($types as $type) {
                if ($sticky_type == $type) {
                  $type_selected_attr = 'selected';
                } else {
                  $type_selected_attr = '';
                }
                echo "<option " . $type_selected_attr . " value=\"" . htmlspecialchars($type) . "\">" . htmlspecialchars($type) . "</option>";
              } ?>
            </select>
          </div>

          <p id="food_feedback" class="feedback <?php echo $food_feedback_class; ?>">*Please enter the name for new item.</p>

          <div class="label-input-pair">
            <label for="insert_food">FOOD NAME:</label>
            <input id="insert_food" type="text" name="insert_food" required value="<?php echo htmlspecialchars($sticky_food); ?>"/>
          </div>

          <p id="price_feedback" class="feedback <?php echo $price_feedback_class; ?>">*Please enter the price for new item.</p>
          <div class="label-input-pair">
            <label for="insert_price">PRICE: $</label>
            <input id="insert_price" type="text" name="insert_price" required value="<?php echo htmlspecialchars($sticky_price); ?>"/>
          </div>

          <div class="label-input-pair">
            <label for="insert_description">DESCRIPTION:</label>
            <textarea cols="30" rows="4" id="insert_description" name="insert_description"><?php echo htmlspecialchars($sticky_description); ?></textarea>
          </div>

          <div>
            <button type="submit" name="submit" id="submit">Submit</button>
          </div>

        </form>
      </section>
    <?php } ?>

  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
