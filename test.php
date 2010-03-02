<?php
include('readme_parser_class.php');
$wp_profiles = new wp_readme_parser($_GET['plugin']);
//echo $wp_profiles->getPlug_name();
//echo "^" . $wp_profiles->getStable() . "^";
echo $wp_profiles->getUrl();
echo "<br />" . $wp_profiles->getStable();
echo "<br />" . $wp_profiles->getTags();
echo "<br />" . $wp_profiles->getRequire();
echo "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
echo "<br />" . $wp_profiles->getData();
echo "\n<br />Mem : " . memory_get_usage();
?>