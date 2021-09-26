
<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h2>
                    <a href="<?=BASE_URL;?>">MY BLOG</a>
                </h2>
            </div>
            <nav class="col-8">
                <ul>
                    <li><a href="<?=BASE_URL;?>">MAIN</a></li>
                    <li>
                        <a href="">
                            <!-- profile icon -->
                            <i></i>
                            HI, <strong><?=$_SESSION['username']?></strong>
                        </a>
                        <ul>
                            <!--<li><a href="#">PROFILE</a></li>-->
                            <li><a href="<?=BASE_URL . 'auth/logout.php';?>">LOGOUT</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
