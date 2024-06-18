<?php 
$active = '';
if(isset($_GET['menu'])) $active  = $_GET['menu'];
?>
<header class="header">
    <div class="container">
        <nav class="navbar navbar-inverse navbar-toggleable-md">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Hawlkar" aria-controls="Hawlkar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center" id="Hawlkar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link color-green-hover <?php if($active == '') echo 'active';?>" href="./">Home</a>
                    </li>
                    <?php 
                        echo navbar();
                    ?>
                    
                </ul>
            </div>
        </nav>
    </div><!-- end container -->
</header>