<?php

// This is the ADMIN TOOLS page
// Only the Admin user is allowed to see its contents
// From here, the Admin can change many aspects of the site
// Including users, lists, toys and see dashboard information

// execute the header script:
require_once "header.php";

// some styling for the tables
echo <<<_END
<style>
 
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    
    padding: 4px;
}
</style>
_END;


if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin')) {

	// USER logged in is the ADMIN - show the options
	echo <<<_END
        
        <div><fieldset><legend><h2>Admin Tools</h2></legend><table id="admin_page_table_style">
        <tr><td align="center" width="90"><a href="admin_users.php"><img width="59" src="Images/boy.png"></a></td><td align="left"> <a href="admin_users.php"><p class="section_title">USERS</p></a></td></tr>
        <tr><td align="center" width="90"><a href="response.php"><img width="59" src="Images/responsive.png"></a></td><td align="left"><a href="response.php"><p class="section_title">Repsonse</p></a></td></tr>
        </table></fieldset></div>
_END;
}

else {
	echo "Sorry, you must be an administrator to access this resource";
}

// finish of the HTML for this page:
require_once "footer.php";

?>