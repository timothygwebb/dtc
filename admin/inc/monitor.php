<?php

function drawAdminMonitor (){
	global $pro_mysql_client_table;
	global $pro_mysql_admin_table;
	global $lang;
	global $txt_user;
	global $txt_transfer;
	global $txt_transfer_per_month;
	global $txt_disk_usage;
	global $txt_domain_tbl_config_quota;
	global $txt_server_total_bp;
	global $txt_bw_quota;

	$out = "";
	// For each clients
	$q = "SELECT * FROM $pro_mysql_client_table WHERE 1 ORDER BY familyname,christname";
	$r = mysql_query($q)or die("Cannot query: \"$q\" !".mysql_error()." line ".__LINE__." in file ".__FILE__);
	$nr = mysql_num_rows($r);
	$out .= '<br><table border="1" width="100%" height="1" cellpadding="1" cellspacing="1">';
	$out .=
"<tr><td><b>".$txt_user[$lang]."</b></td><td><b>".$txt_transfer[$lang]." / ".$txt_bw_quota[$lang]."</b></td><td><b>".$txt_transfer_per_month[$lang]."</b></td><td><b>".$txt_disk_usage[$lang]." / ".$txt_domain_tbl_config_quota[$lang]."</b></td></tr>";
	$total_box_transfer = 0;
	$total_box_hits = 0;
	for($i=0;$i<$nr;$i++){
		$ar = mysql_fetch_array($r);
		$transfer = 0;
		$total_hits = 0;
		$du = 0;
		// make sure we are selecting the correct DB
		// there is a condition where we have lost the link to the main DB
		// this may hide another bug, but at least it will show things to the user
                mysql_select_db($conf_mysql_db);
		// For each of it's admins
		$q2 = "SELECT * FROM $pro_mysql_admin_table WHERE id_client='".$ar["id"]."';";
		$r2 = mysql_query($q2)or die("Cannot query: \"$q2\" !".mysql_error()." line ".__LINE__." in file ".__FILE__);
		$nr2 = mysql_num_rows($r2);
		for($j=0;$j<$nr2;$j++){
			$ar2 = mysql_fetch_array($r2);

			$admin = fetchAdmin($ar2["adm_login"],$ar2["adm_pass"]);
			$admin_stats = fetchAdminStats($admin);
			if (isset($admin_stats["total_transfer"]))
			{
				$transfer += $admin_stats["total_transfer"];
			}
			$du += $admin_stats["total_du"];
			if (isset($admin_stats["total_hit"]))
			{
				$hits = $admin_stats["total_hit"];
				$total_hits += $hits;
			}
		}
		if($i % 2){
			$back = " bgcolor=\"#000000\" style=\"white-space:nowrap;color:#FFFFFF\" nowrap";
		}else{
			$back = " style=\"white-space:nowrap;\" nowrap";
		}
		$out .= "<tr><td$back><u>".$ar["company_name"].":</u><br>
".$ar["familyname"].", ".$ar["christname"]."</td>";
		$out .= "<td$back>".drawPercentBar($transfer,$ar["bw_quota_per_month_gb"]*1024*1024*1024,"no")."<br>
".smartByte($transfer)." / ".smartByte($ar["bw_quota_per_month_gb"]*1024*1024*1024)." ($total_hits hits)</td>";
		$out .= "<td$back><img width=\"120\" height=\"48\" src=\"bw_per_month.php?cid=".$ar["id"]."\"></td>";
		$out .= "<td$back>".drawPercentBar($du,$ar["disk_quota_mb"]*1024*1024,"no")."<br>
".smartByte($du)." / ".smartByte($ar["disk_quota_mb"]*1024*1024)."</td>";
		$total_box_transfer += $transfer;
		$total_box_hits += $total_hits;
//fetchAdminStats($admin)
	}
	$out .= "</table>";
	$out .= $txt_server_total_bp[$lang].smartByte($total_box_transfer)." ($total_box_hits hits)";
	return $out;
}

?>