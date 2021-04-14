<?php
// include("includes/init.php");

// open connection to foods database
include_once("includes/db.php");
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// list of "valid" types for food
$types = array("Rice", "Noodle", "Appetizers", "Drink", "Dessert", "Sauce");

// feedback message CSS classes
$type_feedback_class = 'hidden';
$food_feedback_class = 'hidden';
$price_feedback_class = 'hidden';
$description_feedback_class = 'hidden';

// additional validation constraints
$food_inserted = False;
$food_insert_failed = False;

// form values
$insert_type = NULL;
$insert_food = NULL;
$insert_price = NULL;
$insert_description = NULL;

// sticky values
$sticky_type = NULL; // type is a dropdown select.
$sticky_food = '';
$sticky_price = '';
$sticky_description = '';

// new food item submitted
if (isset($_POST['submit'])) {
  // trim leading and trailing spaces on http parameters.
  $insert_type = trim($_POST['insert_type']); // untrusted
  $insert_food = trim($_POST['insert_food']); // untrusted
  $insert_price = trim($_POST['insert_price']); // untrusted
  $insert_description = trim($_POST['insert_description']); // untrusted

  $form_valid = True;

  // type must be a valid food type
  if (!in_array($insert_type, $types)) {
    $form_valid = False;
    $type_feedback_class = '';
    $insert_type = NULL;
  }

  // insert_food is required
  if (empty($insert_food)) {
    $form_valid = False;
    $food_feedback_class = '';
  }

  // insert_price is required and has to be a float
  if (empty($insert_price) || is_float($insert_price)) {
    $form_valid = False;
    $price_feedback_class = '';
  }

  // description is optional, check if it's the empty string.
  if (empty($insert_description)) {
    $insert_description = NULL;
  }

  if ($form_valid) {
    $result = exec_sql_query(
      $db,
      "INSERT INTO foods (food_type, food_name, description, price) VALUES (:food_type, :food_name, :description, :price);",
      array(
        ':food_type' => $insert_type, // tainted
        ':food_name' => $insert_food, // tainted
        ':description' => $insert_description, // tainted
        ':price' => $insert_price // tainted
      )
    );
    $records = $result->fetchAll();

    // check if insert query was successful
    if ($result) {
      $food_inserted = True;
    } else {
      $food_insert_failed = True;
    }
  } else {
    // form is invalid, set sticky values
    $sticky_type = $insert_type; // tainted
    $sticky_food = $insert_food; // tainted
    $sticky_price = $insert_price; // tainted
    $sticky_description = $insert_description; // tainted
  }
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

  <a href="https://www.kikkoman.eu/fileadmin/_processed_/1/5/csm_WEB_Ramen_with_ham_and_marinated_egg_1df8e80f20.jpg">Source</a>

  <?php include("includes/nav.php"); ?>

  <h2>Enter New Item to Menu</h2>

  <?php if ($food_inserted) { ?>
      <p class="confirmation"><strong>Your new food item was successfully added to the menu.</strong></p>
  <?php } ?>

  <?php if ($food_insert_failed) { ?>
      <p><strong>Something went wrong recording your new food item. Please try again.</strong></p>
  <?php } ?>

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

  <section class="table">
  <?php
      if ($food_inserted) { ?>
        <h2>Updated Menu</h2>

    <?php
      // search query. "wildcard" search DB for product_name and comment. Replace NULL with records from query.
      $records = exec_sql_query(
        $db,
        "SELECT * FROM foods"
      )->fetchAll();

    } else {
        // No search, so return everything!
    ?>

  <h2>Menu</h2>
    <?php
      // query ALL reviews. Replace NULL with records from query.
      $records = exec_sql_query(
        $db,
        "SELECT * FROM foods"
      )->fetchAll();
    } ?>

    <?php
    // check if we have records to display
    if (count($records) > 0) { ?>
      <table>
        <tr>
            <th>Food Type</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        <?php
        foreach($records as $record) {
          echo '<tr>'.
          '<td>' . $record['food_type'] . '</td>'.
          '<td>' . $record['food_name'] . '</td>'.
          '<td>' . $record['description'] . '</td>'.
          '<td>' . $record['price'] . '</td>'.
          '</tr>';
        } ?>
      </table>
    <?php } else { ?>
      <p>No menu found.</p>
    <?php } ?>
  </section>

  <?php include("includes/footer.php"); ?>
</body>

</html>
