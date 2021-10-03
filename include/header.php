<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <h2>
                    <a href="<?php echo BASE_URL ?>">#ЯРОДИЛСЯ</a>
                </h2>
            </div>
            <?php
            if(isset($_SESSION['id']) == ''):
                ?>
            <div class="col-md-6 col-12">
                <nav class="">
                    <ul>
                        <li><a href="<?php echo BASE_URL ?>">MAIN</a></li>

                        <!-- <li><a href="#">LOL</a></li> -->
                        <li><a>
                                ABOUT ME
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . 'about.php' ?>">WHO I AM?</a></li>
                                <li><a href="<?php echo BASE_URL . 'contact.php' ?>">CONTACT ME!</a></li>
                            </ul>
                        </li>
                        <li>
                            <a>
                                <!-- profile icon -->
                                <i></i>
                                JOIN ME!
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . 'auth/auth_form.php'?>">LOGIN</a></li>
                                <li><a href="<?php echo BASE_URL . 'auth/reg_form.php'?>">SIGN-UP</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php else:?>
            <div class="col-md-6 col-12">
                <nav class="">
                    <ul>
                        <li><a href="<?php echo BASE_URL ?>">MAIN</a></li>
                        <li><a>
                                ABOUT ME
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . 'about.php' ?>">WHO I AM?</a></li>
                                <li><a href="<?php echo BASE_URL . 'contact.php' ?>">CONTACT ME!</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="">
                                <!-- profile icon -->
                                <i></i>
                                HI, <strong><?=$_SESSION['username']?></strong>
                            </a>
                            <ul>
                                <!--<li><a href="#">PROFILE</a></li>-->
                                <?php if ($_SESSION['admin']): ?>
                                    <li><a href="<?= BASE_URL . 'admin/articles/index.php';?>">ADM.CTRL.</a></li>
                                <?php endif; ?>
                                <li><a href="<?= BASE_URL . 'auth/logout.php';?>">LOGOUT</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif;?>
        </div>
    </div>
</header>