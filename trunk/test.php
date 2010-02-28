<?php
include('readme_parser_class.php');
$wp_profiles = new wp_readme_parser($_GET['plugin']);
//echo $wp_profiles->getPlug_name();
//echo "^" . $wp_profiles->getStable() . "^";
//echo $wp_profiles->getUrl();
echo $wp_profiles->getTags();
echo "\n<br />Mem : " . memory_get_usage();
?>