<?php
	
function skin_LayoutAdminPage_Default (){
	global $rub;
	global $adm_login;
	global $adm_pass;
	global $conf_session_expir_minute;
	global $pro_mysql_config_table;
	global $conf_skin;
	global $lang;
	global $txt_virtual_admin_list;
	global $txt_root_adm_title;
	global $txt_dtc_configuration;
	global $top_commands;
	global $txt_generate_buttons_title;
	global $txt_iframe_ds;
	global $txt_product_manager;
	global $txt_customer_bw_consumption;
	global $txt_client_addr_title;
	global $txt_client_list_title;

	$anotherTopBanner = anotherTopBanner("DTC","yes");

	///////////////////////
	// Make All the page //
	///////////////////////
	switch($rub){
	case "crm": // CRM TOOL
		$rightFrameCells[] = skin($conf_skin,DTCRMeditClients(),$txt_client_addr_title[$lang]);
			if(isset($_REQUEST["id"]) && $_REQUEST["id"] != "" && $_REQUEST["id"] != 0){
			$rightFrameCells[] = skin($conf_skin,DTCRMclientAdmins(),$txt_client_admins_title[$lang]);
			$rightFrameCells[] = skin($conf_skin,DTCRMshowClientCommands($_REQUEST["id"]),$txt_client_commands_title[$lang]);
		}
		$rightFrame = makeVerticalFrame($rightFrameCells);
		$leftFrameCells[] = skin($conf_skin,DTCRMlistClients(),$txt_client_list_title[$lang]);
		$leftFrame = makeVerticalFrame($leftFrameCells);
		$zemain_content = anotherLeftFrame($leftFrame,$rightFrame);
		break;
	case "renewal":
		$out = drawRenewalTables();
		$zemain_content = skin($conf_skin,$out,"Customer Renewals");
		break;
	case "monitor": // Monitor button
		$out = drawAdminMonitor();
		$zemain_content = skin($conf_skin,$out,$txt_customer_bw_consumption[$lang]);
		break;
	case "graph":
		$zemain_content = skin($conf_skin,drawRrdtoolGraphs (),"Server statistic graphs");
		break;
	case "generate": // Gen Config Files
		$mainFrameCells[] = skin($conf_skin,$top_commands,$txt_generate_buttons_title[$lang]);
		$the_iframe = "<br><IFRAME src=\"deamons_state.php\" width=\"100%\" height=\"135\"></iframe>";
		$mainFrameCells[] = skin($conf_skin,$the_iframe,$txt_iframe_ds[$lang]); // fixed bug by seeb
		// The console
		$mainFrameCells[] = skinConsole();
		$zemain_content = makeVerticalFrame($mainFrameCells);
		break;
	case "config": // Global Config
		$chooser_menu = drawDTCConfigMenu();
		$leftFrameCells[] = skin($conf_skin,$chooser_menu,"Menu");
		$leftFrame = makeVerticalFrame($leftFrameCells);
		$rightFrameCells[] = skin($conf_skin,drawDTCConfigForm(),$txt_dtc_configuration[$lang]);
		$rightFrame = makeVerticalFrame($rightFrameCells);

		$zemain_content = anotherLeftFrame($leftFrame,$rightFrame);
		break;
	case "product":
		$bla = productManager();
		$zemain_content = skin($conf_skin,$bla,$txt_product_manager[$lang]);
		break;
	case "user": // User Config
	case "domain_config":
	case "adminedit":
	default: // No rub selected
		// A virtual admin edition
		// We have to call it first, in case it will generate a random pass (edition of an admin with inclusion of user's panel)
		$rightFrameCells[] = userEditForms($adm_login,$adm_pass);
		$rightFrameCells[] = skinConsole();
		$rightFrame = makeVerticalFrame($rightFrameCells);

		// Our list of admins
		// If random password was not set before this, we have to calculate it now!
		if(isset($adm_random_pass)){
			$leftFrameCells[] = skin($conf_skin,adminList($adm_pass),$txt_virtual_admin_list[$lang]);
		}else{
			$rand = getRandomValue();
			$expirationTIME = mktime() + (60 * $conf_session_expir_minute);
			$q = "UPDATE $pro_mysql_config_table SET root_admin_random_pass='$rand', pass_expire='$expirationTIME';";
			$r = mysql_query($q)or die("Cannot execute query \"$q\" !");
			$leftFrameCells[] = skin($conf_skin,adminList($rand),$txt_virtual_admin_list[$lang]);
		}
		// Make the frame
		$leftFrame = makeVerticalFrame($leftFrameCells);

		$zemain_content = anotherLeftFrame($leftFrame,$rightFrame);
		break;
	}
	if(function_exists("skin_Navbar")){
		$dtc_main_menu = skin_Navbar();
	}else{
		$dtc_main_menu = skin_Navbar_Default();
	}

	$the_page[] = skin($conf_skin,$dtc_main_menu,$txt_root_adm_title[$lang]);

	$the_page[] = $zemain_content;
	$pageContent = makeVerticalFrame($the_page);
	$anotherFooter = anotherFooter("Footer content<br><br>");

	if(!isset($anotherHilight))	$anotherHilight = "";
	if(!isset($anotherMenu))	$anotherMenu = "";

	echo anotherPage("admin:","",$anotherHilight,makePreloads(),$anotherTopBanner,$anotherMenu,$pageContent,$anotherFooter);
}

function skin_Navbar_Default() {
	global $rub;

	global $adm_login;
	global $adm_pass;

	global $pro_mysql_admin_table;

	global $txt_mainmenu_title_client_management;
	global $txt_mainmenu_title_bandwidth_monitor;
	global $txt_mainmenu_title_server_monitor;
	global $txt_product_manager;
	global $txt_mainmenu_title_deamonfile_generation;
	global $txt_mainmenu_title_dtc_config;
	global $txt_mainmenu_title_useradmin;
	global $lang;

	if(isset($adm_login) && isset($adm_pass)){
		$added_logpass = "&adm_login=$adm_login&adm_pass=$adm_pass";
	}else{
		$added_logpass = "";
	}

	$menu = "";
	// User management icon
	if(isset($_REQUEST["rub"]) && $_REQUEST["rub"] != "" && $_REQUEST["rub"] != "user" && $_REQUEST["rub"] != "domain_config" && $_REQUEST["rub"] != "adminedit"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=user$added_logpass\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/admins.png\"><br>".
		$txt_mainmenu_title_useradmin[$lang];
	if(isset($_REQUEST["rub"]) && $_REQUEST["rub"] == "" && $_REQUEST["rub"] != "user"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";

	// CRM Button
	if(!isset($rub) || $rub != "crm"){
		$query = "SELECT * FROM $pro_mysql_admin_table WHERE adm_login='$adm_login' AND adm_pass='$adm_pass';";
		$result = mysql_query($query)or die("Cannot query \"$query\" !!!".mysql_error());
		if(mysql_num_rows($result) == 1){
			$row = mysql_fetch_array($result);
			$url_addon = "&id=".$row["id_client"];
		}else{
			$url_addon = "";
		}
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=crm&admlist_type=Names".$url_addon."\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/crm.png\"><br>".
		$txt_mainmenu_title_client_management[$lang];
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "crm"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";
	// Monitor button
	if(!isset($rub) || $rub != "monitor"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=monitor\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/bw_icon.png\"><br>".
		$txt_mainmenu_title_bandwidth_monitor[$lang];
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "monitor"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";

	// The graph button
	if(!isset($rub) || $rub != "graph"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=graph\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/bw_icon.png\"><br>".
		$txt_mainmenu_title_server_monitor[$lang];
	if(!isset($rub) || $rub != "graph"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";

	if(!isset($rub) || $rub != "renewal"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=renewal\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/renewals.png\"><br>"."Renewals";

	if(!isset($rub) || $rub != "renewal"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";

	if(file_exists("dtcrm")){
		// Product manager
		if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "product"){
			$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=product\">";
		}
		$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/product_manager.png\"><br>
	".$txt_product_manager[$lang];
		if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "product"){
			$menu .= "</a>";
		}
		$html_array[] = $menu;
		$menu = "";
	}

	// Generate daemon files icon
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "generate"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=generate\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/daemons.png\"><br>".
		$txt_mainmenu_title_deamonfile_generation[$lang];
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "generate"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$menu = "";

	// Main config panel icon
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "config"){
		$menu .= "<a href=\"".$_SERVER["PHP_SELF"]."?rub=config\">";
	}
	$menu .= "<img border=\"0\" alt=\"*\" src=\"gfx/menu/config_panel.png\"><br>".
		$txt_mainmenu_title_dtc_config[$lang];
	if(!isset($_REQUEST["rub"]) || $_REQUEST["rub"] != "config"){
		$menu .= "</a>";
	}
	$html_array[] = $menu;
	$dtc_main_menu = make_table_valign_top($html_array,sizeof($html_array));
	return $dtc_main_menu;
}

function userEditForms($adm_login,$adm_pass){
	global $txt_general_virtual_admin_edition;
	global $txt_domains_configuration_title;
	global $txt_add_user_title;

	global $txt_client_interface;
	global $txt_domain_config;
	global $txt_admin_editor;
	global $lang;
	// added by seeb
	global $txt_user_administration;
	global $txt_user_administration_domains_for;

	global $adm_random_pass;

	// end added
	global $conf_skin;
	global $lang;
	global $addrlink;
	global $rub;

	$ret["err"] = 0;
	$ret["mesg"] = "No error";

	if(isset($adm_login) && $adm_login != "" && isset($adm_pass) && $adm_pass != ""){
		// Fetch all the selected user informations, Print a nice error message if failure.
		$admin = fetchAdmin($adm_login,$adm_pass);

		if(isset($adm_random_pass)){
			$pass = $adm_random_pass;
		}else{
			$pass = $adm_pass;
		}

		if(($error = $admin["err"]) != 0){
			// now print out all the stuff from our HTTP headers
			//$input = array_merge($_GET,    $_POST,
                        //     $_COOKIE, $_SERVER,
                        //     $_ENV,    $_FILES,
                        //     isset($_SESSION) ? $_SESSION : array()); 
			//foreach ($input as $k => $v) { 
			//	echo "$k - $input[$k]\n";	
			//}
			echo("Error fetching admin : $error");
			$ret["err"] = $admin["err"];
			$ret["mesg"] = $admin["mesg"];
			return $ret;
		}

		//fix up the $adm_login in case it changed because of session vars:
		//in case users play silly bugger with the "GET" variables
		$adm_login = $admin["info"]["adm_login"];

		// Draw the html forms
		if(isset($rub) && $rub == "adminedit"){
			$HTML_admin_edit_info = drawEditAdmin($admin);
			$user_config = skin($conf_skin,$HTML_admin_edit_info,$txt_general_virtual_admin_edition[$lang]);
//			return $user_config;
		}else if(isset($rub) && $rub == "domain_config"){
			$HTML_admin_domain_config = drawDomainConfig($admin);
			$user_config = skin($conf_skin,$HTML_admin_domain_config,$txt_domains_configuration_title[$lang]);
		}else{
			$HTML_admin_edit_data = drawAdminTools($admin);
			$user_config = skin($conf_skin,$HTML_admin_edit_data,$txt_user_administration_domains_for[$lang]." ".$adm_login);
//			return $user_tools;
		}

		$iface_select = "<table height=\"1\" border=\"0\" width=\"100%\">";
		$iface_select .= "<tr><td width=\"33%\" valign=\"top\"><center>";
		if($rub != "user" && $rub != ""){
			$iface_select .= "<a href=\"?rub=user&adm_login=$adm_login&adm_pass=$pass\">";
		}
		$iface_select .= "<img src=\"gfx/menu/client-interface.png\" width=\"48\" height=\"48\" border=\"0\"><br>
".$txt_client_interface[$lang];
		if($rub != "user" && $rub != ""){
			$iface_select .= "</a>";
		}
		$iface_select .= "</center></td><td width=\"33%\" valign=\"top\"><center>";
		if($rub != "domain_config"){
			$iface_select .= "<a href=\"?rub=domain_config&adm_login=$adm_login&adm_pass=$pass\">";
		}
		$iface_select .= "<img src=\"gfx/menu/domain-config.png\" width=\"48\" height=\"48\" border=\"0\"><br>
".$txt_domain_config[$lang];
		if($rub != "domain_config"){
			$iface_select .= "</a>";
		}
		$iface_select .= "</center></td><td width=\"33%\" valign=\"top\"><center>";
		if($rub != "adminedit"){
			$iface_select .= "<a href=\"?rub=adminedit&adm_login=$adm_login&adm_pass=$pass\">";
		}
		$iface_select .= "<img src=\"gfx/menu/user-editor.png\" width=\"48\" height=\"48\" border=\"0\"><br>
".$txt_admin_editor[$lang];
		if($rub != "adminedit"){
			$iface_select .= "</a>";
		}
		$iface_select .= "</center></td></tr></table>";

		$iface_skined = skin($conf_skin,$iface_select,$txt_user_administration[$lang]);

		// All thoses tools in a simple table
		return "<table width=\"100%\" height=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
		<tr><td width=\"100%\">$iface_skined</td></tr>
		<tr><td width=\"100%\">$user_config</td></tr>
		<tr><td height=\"100%\">&nbsp;</td></tr>
	</tr>
</table>
";
	}else{
		// If no user is in edition, draw a tool for adding an admin
		$add_a_user = drawNewAdminForm();
		return skin($conf_skin,$add_a_user,$txt_add_user_title[$lang]);
	}
}

?>