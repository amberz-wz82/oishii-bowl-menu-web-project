<?php
// include("includes/init.php");

// open connection to foods database
include_once("includes/db.php");
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// list of "valid" types for food
$types = array("Rice", "Noodle", "Appetizers", "Drink", "Dessert", "Sauce");

$sql_select_query = "SELECT * FROM foods;";
$sql_select_params = array();

// search submitted
if (isset($_GET['q'])) {
  // trim spaces around http parameters
  $search_terms = trim($_GET['q']); // untrusted

  // set empty string to NULL
  if (empty($search_terms)) {
    $search_terms = NULL;
  }

  $sticky_search = $search_terms; // tainted

  // SQL query
  // search query. "wildcard" search DB for food_name and description.
  if ($search_terms) {
    $sql_select_params = array(":search" => $search_terms);
    $sql_select_query = "SELECT * FROM foods WHERE (food_name LIKE '%' || :search || '%') OR (description LIKE '%' || :search || '%')";
  }

}


// filter!!

$sticky_filters = array();

// SQL conditional expressions for filtering
$sql_filter_exprs = '';
$has_filtering = False;

// populate filters with food type parameter name
foreach ($types as $type) {
  // clean up the parameters for the URL
  $type_param = str_replace(' ', '-', strtolower($type));
  $should_filter = (bool)$_GET[$type_param]; // untrusted

  // sticky values
  $sticky_filters[$type_param] = ($should_filter ? 'checked' : '');

  // assemble the filter query
  if ($should_filter) {
    $has_filtering = True;
    $sql_filter_exprs = $sql_filter_exprs . (($sql_filter_exprs != '') ? 'OR' : '') . "(food_type = '" . $type . "')";
  }
}

if ($has_filtering) {
  // assign a SQL for filtering to $sql_select_query
  $sql_select_query = "SELECT * FROM foods WHERE " . $sql_filter_exprs ;
}


// sort!!

$sort = $_GET['sort']; // untrusted

$sort_css_classes = array(
  'low' => '',
  'high' => '',
);

// if we have a valid value to sort
if (in_array($sort, array('low', 'high'))) {

  $sql_select_query = "SELECT * FROM foods";

  if ($sort == 'low') {
    $sql_select_query = $sql_select_query . ' ORDER BY price ASC;';
    $sort_css_classes['low'] = 'active';
  } else if ($sort == 'high') {
    $sql_select_query = $sql_select_query . ' ORDER BY price DESC;';
    $sort_css_classes['high'] = 'active';
  }
} else {
  // just in case we have a untrusted value in $sort.
  $sort = NULL;
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

  <main class="food">

    <section class="table">

    <h2>Our Menu</h2>

      <div class="flex-row">

        <div class="side flex-column">
          <form id="searchForm" method="get" action="/" novalidate>
            <div class="label-input-pair">
              <label id="search-menu-label" for="search">Search Menu:</label>
              <input type="text" name="q" id="search" required value="<?php echo htmlspecialchars($sticky_search); ?>" />
              <button id="search-submit" type="submit">Go</button>
            </div>
          </form>

          <form class="filter flex-column" action="/" method="get" novalidate>
            <h3>Filter by Type</h3>
            <?php
            foreach ($types as $type) {
              // clean-up the parameters for the URL. No spaces + all lower case
              $type_param = str_replace(' ', '-', strtolower($type));
            ?>
              <label>
                <input type="checkbox" name="<?php echo htmlspecialchars($type_param); ?>" value="1" <?php echo $sticky_filters[$type_param]; ?> />
                <?php echo htmlspecialchars($type); ?>
              </label>
            <?php } ?>

            <button id="filter-submit" type="submit">Filter</button>
          </form>
        </div>

        <div class="menu">
          <div class="sort">
            <p>Sort by Price:
              <!-- query string parameters for sort -->
              <a class="<?php echo $sort_css_classes['low']; ?>" href="/?sort=low">Lowest</a> |
              <a class="<?php echo $sort_css_classes['high']; ?>" href="/?sort=high">Highest</a>
            </p>
          </div>

          <?php
          // query DB
          $records = exec_sql_query($db, $sql_select_query, $sql_select_params)->fetchAll();

          // check if we have records to display
          if (count($records) > 0) { ?>
            <table>
              <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
              </tr>
              <?php
              foreach($records as $record) {
                echo '<tr>'.
                '<td>' . $record['food'] . '</td>'.
                '<td>' . $record['description'] . '</td>'.
                '<td>' . $record['price'] . '</td>'.
                '</tr>';
              } ?>
            </table>
          <?php } else { ?>
            <p>No menu found.</p>
          <?php } ?>
        </div>

      </div>
    </section>


  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>
