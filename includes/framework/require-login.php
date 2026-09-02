<?php

// Real authorization check, unlike login-check.php (which is currently a
// no-op -- see that file's comment). Use this in any endpoint that causes
// a side effect (sending email, changing data) rather than just rendering
// a page, so it doesn't rely solely on index.php's front-controller auth
// having run first for this exact request.
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	http_response_code(403);
	die("Not authorized.");
}

?>
