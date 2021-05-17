<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Page Not Found</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/theme.css" media="all"/>
</head>

<body>

  <?php include("includes/header.php"); ?>

  <?php include("includes/nav.php"); ?>

  <main>
    <h2 class="oops-h2">404: Page Not Found</h2>

    <p class="oops">Oops! The page you are looking for does not exist. Maybe take a ramen break and try again? :)</p>

    <!-- source: https://www.flaticon.com/free-icon/ramen_644695 -->
    <a href="https://www.flaticon.com/free-icon/ramen_644695" id="ramen-break"><img src="/public/images/ramen.svg" alt="Ramen Break"></a>
  </main>

  <?php include("includes/footer.php"); ?>

</body>

</html>
