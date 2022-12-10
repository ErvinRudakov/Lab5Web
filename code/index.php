<?php
require_once 'dictionary.php';
require_once 'functions.php';

$database = connectDatabase(DB_CONNECTION_DATA);

if (hasNeededParametersToAddAd($_POST))
{
    addAd($database, $_POST);
    header('Location: index.php');
}

printForm(CATEGORIES);

$ads = getAds($database);
if (count($ads) > 0)
{
    printAds($ads);
}