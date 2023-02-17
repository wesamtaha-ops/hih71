<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_countries", $Language->MenuPhrase("2", "MenuText"), "countrieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}countries'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_courses", $Language->MenuPhrase("3", "MenuText"), "courseslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}courses'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_currencies", $Language->MenuPhrase("4", "MenuText"), "currencieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}currencies'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_languages", $Language->MenuPhrase("6", "MenuText"), "languageslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}languages'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_languages_levels", $Language->MenuPhrase("7", "MenuText"), "languages_levelslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}languages_levels'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_levels", $Language->MenuPhrase("8", "MenuText"), "levelslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}levels'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(22, "mi_topics", $Language->MenuPhrase("22", "MenuText"), "topicslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}topics'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(24, "mi_users", $Language->MenuPhrase("24", "MenuText"), "userslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}users'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
