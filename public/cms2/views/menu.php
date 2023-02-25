<?php

namespace PHPMaker2023\hih71;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(2, "mi_countries", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "CountriesList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}countries'), false, false, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_curriculums", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "CurriculumsList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}curriculums'), false, false, "", "", false, true);
$sideMenu->addMenuItem(4, "mi_currencies", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "CurrenciesList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}currencies'), false, false, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_languages", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "LanguagesList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}languages'), false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_languages_levels", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "LanguagesLevelsList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}languages_levels'), false, false, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_levels", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "LevelsList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}levels'), false, false, "", "", false, true);
$sideMenu->addMenuItem(22, "mi_topics", $MenuLanguage->MenuPhrase("22", "MenuText"), $MenuRelativePath . "TopicsList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}topics'), false, false, "", "", false, true);
$sideMenu->addMenuItem(24, "mi_users", $MenuLanguage->MenuPhrase("24", "MenuText"), $MenuRelativePath . "UsersList", -1, "", IsLoggedIn() || AllowListMenu('{D43A73A4-5F37-4161-A00D-2E65107145C9}users'), false, false, "", "", false, true);
echo $sideMenu->toScript();
