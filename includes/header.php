<header>
    <a name="top"></a>
    <a href="/" id="oishii"><h1>Oishii Bowl</h1></a>
    <p>The most delicious Asian cuisine you can find in Collegetown!</p>
    <a href="https://www.kikkoman.eu/fileadmin/_processed_/1/5/csm_WEB_Ramen_with_ham_and_marinated_egg_1df8e80f20.jpg">Source</a>
    <div class="button-flex-container">
    <?php if (!is_user_logged_in()) { ?>
      <a href="/login#forms" id="login" class="edit-button">Sign In</a>
      <?php } ?>
    <?php if (is_user_logged_in()) { ?>
      <a href="<?php echo logout_url(); ?>" id="logout" class="edit-button">Sign Out</a>
      <?php } ?>
    </div>
</header>
