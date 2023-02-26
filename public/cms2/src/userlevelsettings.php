<?php
/**
 * PHPMaker 2023 user level settings
 */
namespace PHPMaker2023\hih71;

// User level info
$USER_LEVELS = [["-2","Anonymous"]];
// User level priv info
$USER_LEVEL_PRIVS = [["{D43A73A4-5F37-4161-A00D-2E65107145C9}conversations","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}countries","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}curriculums","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}currencies","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}failed_jobs","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}languages","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}languages_levels","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}levels","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}messages","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}migrations","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}oauth_refresh_tokens","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}orders","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}students","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teacher_availablities","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_certificates","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_curriculums","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_experiences","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_levels","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_packages","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_topics","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}teachers_trains","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}topics","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}transfers","-2","0"],
    ["{D43A73A4-5F37-4161-A00D-2E65107145C9}users","-2","0"]];
// User level table info
$USER_LEVEL_TABLES = [["conversations","conversations","conversations",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["countries","countries","Countries",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","CountriesList"],
    ["curriculums","curriculums","Curriculums",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","CurriculumsList"],
    ["currencies","currencies","Currencies",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","CurrenciesList"],
    ["failed_jobs","failed_jobs","failed jobs",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["languages","languages","Languages",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","LanguagesList"],
    ["languages_levels","languages_levels","languages levels",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","LanguagesLevelsList"],
    ["levels","levels","Education Levels",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","LevelsList"],
    ["messages","messages","messages",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["migrations","migrations","migrations",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["oauth_refresh_tokens","oauth_refresh_tokens","oauth refresh tokens",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["orders","orders","Orders",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","OrdersList"],
    ["students","students","Students",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teacher_availablities","teacher_availablities","Teacher availablities",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers","teachers","Teachers",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_certificates","teachers_certificates","Certificates",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_curriculums","teachers_curriculums","Courses",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_experiences","teachers_experiences","Experiences",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_levels","teachers_levels","teachers levels",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_packages","teachers_packages","Packages",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_topics","teachers_topics","Topics",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["teachers_trains","teachers_trains","Trainings",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}",""],
    ["topics","topics","Education Topics",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","TopicsList"],
    ["transfers","transfers","Transfers",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","TransfersList"],
    ["users","users","Registred Users",true,"{D43A73A4-5F37-4161-A00D-2E65107145C9}","UsersList"]];
