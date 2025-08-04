<?php
/**
 * Copyright (C) 2019-2025 Paladin Business Solutions
 */
ob_start();
session_start();

require_once('includes/ringcentral-functions.inc');
require_once('includes/ringcentral-php-functions.inc');
require_once('includes/ringcentral-db-functions.inc');

//show_errors();

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
						echo "<p class='msg_bad, blink_me'>" . $message . "</strong></font>";
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
            <tr>
                <td class="addform_left_col">
                    <p style='display: inline;'>Opt In?:</p>
					<?php required_field(); ?>
                </td>
                <td class="addform_right_col_even"><input type="checkbox" name="opt_in" <?php
					if ($print_again) {
						if ($_POST['mobile_consent'] == "on") {
							echo 'CHECKED';
						}
					} ?> > <label for="opt_in"> Opt In</label>
                </td>
            </tr>
            <tr>
                <td class="addform_left_col">
                    <p style='display: inline;'>Opt Out?:</p>
					<?php required_field(); ?>
                </td>
                <td class="addform_right_col"><input type="checkbox" name="opt_out" <?php
					if ($print_again) {
						if ($_POST['mobile_consent'] == "on") {
							echo 'CHECKED';
						}
					} ?> > <label for="opt_out"> Opt Out</label>
                </td>
            </tr>
            <tr class="CustomTable">
                <td colspan="2" class="CustomTableFullCol">
                    <br/>
                    <input type="submit" class="submit_button" value=" Opt In / Opt Out the Number " name="add_opt_in_out">
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

	$mobile  = htmlspecialchars($_POST['mobile']);
	$opt_in  = htmlspecialchars($_POST['opt_in']) == "on" ? 1 : 0;
	$opt_out = htmlspecialchars($_POST['opt_out']) == "on" ? 1 : 0;

	if ($opt_in == 0 && $opt_out == 0) {
		$print_again = true;
		$message = "Please select one of the checkboxes - opt in or opt out.";
	}

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

        if ($opt_in == 1) {$process = "OptIn";} else {$process = "OptOut";}

		$success = set_opt_in_out($mobile, $process);
		if ($success) {
            $message = "The provided mobile number has been added to your selected $process List";
			show_form($message, true);
		} else {
			$message = "There was an error adding the provided mobile number to the $process List.";
            show_form($message, true);
        }

	}
}

/* ============= */
/*  --- MAIN --- */
/* ============= */
if (isset($_POST['add_opt_in_out'])) {
	check_form();
} else {
	$message = "Please provide the mobile number that you want to add to the Opt Out List";
	show_form($message);
}

ob_end_flush();
page_footer();
