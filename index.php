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
                <td colspan="3" class="EditTableFullCol">
					<?php
					if ($print_again == true) {
						echo "<p class='msg_bad'>" . $message . "</strong></font>";
					} else {
						echo "<p class='msg_good'>" . $message . "</p>";
					} ?>
                    <hr>
                </td>
            </tr>
            <tr class="CustomTable">
                <td class="CustomTableFullCol">
                    <a href="list_opt_ins_outs.php"> List Opt Ins / Outs </a>
                </td>
                <td class="CustomTableFullCol">
                    <a href="manage_opts.php"> Manage Opt In / Opt Out list </a>
                </td>
                <td class="CustomTableFullCol">
                    <a href="export_opts.php"> Export Opt In / Opt Out Data </a>
                </td>
            </tr>
        </table>
    </form>
	<?php
}

/* ============= */
/*  --- MAIN --- */
/* ============= */
if (isset($_POST['add_reminder'])) {
	check_form();
} else {
	$message = "Please your desired action from the links below.";
	show_form($message);
}

ob_end_flush();
page_footer();
