<?php 



define('PATH_APP', str_replace("App\Core\Config", "", __DIR__));



define('ROOT_URL', str_replace(" ", "%20", str_replace('/Public/index.php', '', $_SERVER['PHP_SELF'])));



define('URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ROOT_URL);



define('FETCH_DEFAULT', 20);



define('FETCH_ALL', 24);

