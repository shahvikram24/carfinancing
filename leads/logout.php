<?php
	require_once("../include/files.php");

	session_destroy();
  header('Location:index.php?'.$Encrypt->encrypt("Success=True&Message=You have successfully logged out from the system."));
      exit();
?>
