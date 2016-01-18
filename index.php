<?php
  ini_set('display_errors',1);
  ini_set('error_reporting', E_ALL);

  // -------------------------------
  //
  // OAUTH CLASSES
  //
  // -------------------------------
  require_once("inc/OAuth.php");
  require_once("inc/twitteroauth.php");


  // -------------------------------
  //
  // MODEL & CONTROLLER
  //
  // -------------------------------
	require_once("inc/_functions.php");
  require_once("inc/_controller.php");


  // -------------------------------
  //
  // VIEW + INCLUDES
  //
  // -------------------------------
	require_once("inc/header.inc");

  if (isset($_GET["expert"])) { include("inc/expert_profile.php"); } else { include("inc/expert_list.php"); }

	require_once("inc/footer.inc");

?>
