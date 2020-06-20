<?php
    $currentPage = $_SERVER['REQUEST_URI'];

    $routes = [
        ['label'=>'Home','route'=>'/'],
        ['label'=>'Learn','route'=>'/learn.php'],
        ['label'=>'Share','route'=>'/share.php'],
        ['label'=>'Leaderboard','route'=>'/leaderboard.php'],
        ['label'=>'About','route'=>'/about.php'],
    ];
    ?>
<header>
    <h2 class="nav-banner audiowide">DownloadMoreSpeed.com</h2>
    <nav class="nav-links">
        <ul>
            <?php
                foreach($routes as $route){
                    $selected = ( $currentPage == $route['route'] ? true : false);
                    $label = ($selected ? '<b><u>' : '').$route['label'].($selected ? '</u></b>' : '');
                    echo '<li><a class="audiowide-md" href="'.$route['route'].'">'.$label.'</a></li>';
                }
            ?>
        </ul>
    </nav>
    <button class="nav-profile-btn">Profile</button>
</header>