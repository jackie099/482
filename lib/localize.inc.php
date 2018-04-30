<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Recommendation\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setRoot('/~duzengze/recommendation');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=duzengze',
        'duzengze',       // Database user
        'Jeremy603',     // Database password
        '482_');            // Table prefix
};

