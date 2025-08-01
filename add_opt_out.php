<?php
/**
 * Copyright (C) 2019-2025 Paladin Business Solutions
 */
ob_start();
session_start();

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');
require_once('includes/ringcentral-db-functions.inc');

show_errors();

function show_form($message, $print_again = false) {
	page_header();
	?>
    <form action="" method="post" enctype="multipart/form-data">
        <table class="EditTable">
			<?php place_logo(); ?>
            <tr>
                <td colspan="2" class="EditTableFullCol">
					<?php
					if ($print_again == true) {
						echo "<p class='msg_bad'>" . $message . "</strong></font>";
					} else {
						echo "<p class='msg_good'>" . $message . "</p>";
					} ?>
                    <hr>
                </td>
            </tr>
			<tr>
                <td class="addform_left_col">
                    <p style='display: inline;'>Mobile #:</p>
					<?php required_field(); ?>
                </td>
                <td class="addform_right_col"><input type="text" name="mobile" value="<?php
					if ($print_again) {
						echo strip_tags($_POST['mobile']);
					}
					?>" placeholder="Format: +19991234567">
                </td>
            </tr>

            <tr class="CustomTable">
                <td colspan="2" class="CustomTableFullCol">
                    <br/>
                    <input type="submit" class="submit_button" value=" Add a to Opt Out List " name="add_opt_out">
                </td>
            </tr>
            <tr class="CustomTable">
                <td colspan="2" class="CustomTableFullCol">
                    <hr>
                </td>
            </tr>
            <tr class="CustomTable">
                <td colspan="2" class="CustomTableFullCol">
                    <a href="index.php"> Home </a>
                </td>
            </tr>
        </table>
    </form>
	<?php
}

function check_form() {
	$print_again = false;
	$message = "";

	$mobile = htmlspecialchars($_POST['mobile']);

	if ($mobile == "") {
		$print_again = true;
		$message = "The mobile number cannot be blank.";
	}
	// check the formatting of the mobile # == +19991234567
	$pattern = '/^\+\d{11}$/'; // Assumes 11 digits after the '+'
	if (!preg_match($pattern, $mobile)) {
		$print_again = true;
		$message = "The mobile number is not in the correct format of +19991234567";
	}

	if ($print_again) {
		show_form($message, true);
	} else {
		set_opt_out($mobile);
		$message = "The provided mobile number has been added to your Opt Out List";
		show_form($message, true);
	}
}

/* ============= */
/*  --- MAIN --- */
/* ============= */
if (isset($_POST['add_opt_out'])) {
	check_form();
} else {
	$message = "Please provide the mobile number that you want to add to the Opt Out List";
	show_form($message);
}

ob_end_flush();
page_footer();
