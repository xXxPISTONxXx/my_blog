<ul class="pagination">
    <?php if ($page > 1): ?>
        <li class="prev"><a href="?page=<?php echo $page-1 ?>">Prev</a></li>
    <?php endif; ?>

    <?php if ($page > 3): ?>
        <li class="start"><a href="?page=1">1</a></li>
        <li class="dots">...</li>
    <?php endif; ?>

    <?php if ($page-2 > 0): ?><li class="page"><a href="?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
    <?php if ($page-1 > 0): ?><li class="page"><a href="?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

    <li class="currentpage"><a href="?page=<?php echo $page ?>"><?php echo $page ?></a></li>

    <?php if ($page+1 < $total_pages+1): ?><li class="page"><a href="?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
    <?php if ($page+2 < $total_pages+1): ?><li class="page"><a href="?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

    <?php if ($page < $total_pages-2): ?>
        <li class="dots">...</li>
        <li class="end"><a href="?page=<?php echo $total_pages ?>"><?php echo $total_pages ?></a></li>
    <?php endif; ?>

    <?php if ($page < $total_pages): ?>
        <li class="next"><a href="?page=<?php echo $page+1 ?>">Next</a></li>
    <?php endif; ?>
</ul>

<style>
    .pagination {
        list-style-type: none;
        padding: 10px 0;
        display: inline-flex;
        justify-content: space-between;
        box-sizing: border-box;
    }
    .pagination li {
        box-sizing: border-box;
        padding-right: 10px;
    }
    .pagination li a {
        box-sizing: border-box;
        background-color: #e2e6e6;
        padding: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        color: #616872;
        border-radius: 4px;
    }
    .pagination li a:hover {
        background-color: #d4dada;
    }
    .pagination .next a, .pagination .prev a {
        text-transform: uppercase;
        font-size: 12px;
    }
    .pagination .currentpage a {
        background-color: #616872;
        color: #fff;
    }
    .pagination .currentpage a:hover {
        background-color: black;
    }

</style>