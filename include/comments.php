<?php
include (SITE_ROOT . "/logic/controllers/commentaries.php");
?>

<div class="comments col-md-7 col-12">
    <?php if (count($comments) > 0): ?>
        <div class="row all-comments">
        <h3 class="col-12">Comments (<?=count($comments);?>):</h3>
        <?php foreach ($comments as $comment): ?>
            <div class="one-comment col-12">
                <span><i class="far fa-comments"></i><?=$comment['username']; ?></span><br>
                <span><i class="far fa-calendar-alt"></i><?=$comment['pubdate']; ?></span>
                <div class="col-12 text">
                    <?=$comment['comment']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <h3 class="col-12">Empty... Be the first to comment this!</h3>
        </div>
    <?php endif; ?>
    <div class="col-md-7 col-12">
    </div>
        <?php
        if(isset($_SESSION['id']) == ''): ?>
            <div class="comment-allow">
            <p>Please, <a href="<?php echo BASE_URL . 'auth/auth_form.php'?>">login</a>
                or <a href="<?php echo BASE_URL . 'auth/reg_form.php'?>">sign-up</a> for
                permission to write comments!</p>
            </div>
        <?php else: ?>
        <form action="<?=BASE_URL . "single.php?article=$page"?>" method="post">
            <input type="hidden" name="page" value="<?=$page; ?>">
            <div class="mb-3 col-md-6 col-12">
                <label for="exampleFormControlTextarea1" class="form-label-comment"></label>
                <textarea class="form-control" name="comment" id="exampleFormControlTextarea1"
                          placeholder="e.g. What a wonderful pic!..." rows="3"></textarea>
            </div>
            <div class="mb-3 col-12">
                <button type="submit" name="goComment" class="btn btn-primary">Send</button>
            </div>
        </form>
        <?php endif;?>
    </div>

    <!--Comments with foreach-->

</div>