<?php

include("includes/init.php");

$sql_query_entries = "SELECT * FROM entries";
$sql_query_tags = "SELECT * FROM tags";
$filter_tag_param = array();

if (isset($_GET["tag_id"])) {
  $filter_tag = trim($_GET["tag_id"]);
//   if ($filter_tag) {
    // $sql_query_entries = "SELECT entries.id, entries.food, entries.file_ext, tags.tag FROM entries LEFT OUTER JOIN entry_tags on entry_tags.entry_id = entries.id LEFT OUTER JOIN tags on entry_tags.tag_id = tags.id WHERE tag_id = :tag_id";
    // $filter_tag_param = array(":tag_id" => $filter_tag);
  // };
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

    <?php
    // $records_entries = exec_sql_query($db, $sql_query_entries, $filter_tag_param)->fetchAll();
    $records_tags = exec_sql_query($db, $sql_query_tags, $filter_tag_param)->fetchAll();
    ?>
    <div class="signature-page">
      <div class="tags-bar">
        <?php foreach ($records_tags as $tag) {
          $tag_param = str_replace(' ', '-', strtolower($tag['tag']));
          ?>
          <a href="/?tag=<?php echo $tag_param ?>"><?php echo $tag['tag'] ?></a>
        <?php } ?>
      </div>

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

    </div>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
