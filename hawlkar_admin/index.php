    <?php require('./components/header.php'); ?>
    <?php if(!$_SESSION['isLogged']) header("Location: ./login"); ?>
        <main class="app flex ">
            <?php require('./components/topbar.php'); ?>

            <?php require('./components/sidebar.php'); ?>

            <div class="app-content mcon">
                <?php load(); ?>
            </div> 
        </main>

    <?php require('./components/footer.php'); ?>