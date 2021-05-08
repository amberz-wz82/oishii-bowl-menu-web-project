<?php
include("includes/init.php");

// Handle user sign up
process_signup_params($db);
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

    <?php if (!is_user_logged_in()) { ?>
      <section id="login-forms">
        <div class="sign-in">

          <h2>Sign In</h2>

          <?php echo_login_form('/', $session_messages); ?>

          <div class="pw">
            <h4>Employee:</h4>
            <p>Username: <em>andreas</em></p>
            <p>Password: <em>monkey</em></p>
          </div>

        </div>

        <!-- <div class="sign-up">
          <h2>Sign up</h2>
          <?php
            echo_signup_form('/', $session_messages);
          } ?>
        </div> -->
      </section>

  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>
