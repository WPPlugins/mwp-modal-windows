<?php
	global $wpdb;
	$table_modal = $wpdb->prefix . "mwp_modal_free";
	$info = (isset($_REQUEST["info"])) ? $_REQUEST["info"] : '';
	if ($info == "saved") {
		echo "<div class='updated' id='message'><p><strong>".__("Record Added", "wmw")."</strong>.</p></div>";
	}
	if ($info == "update") {
		echo "<div class='updated' id='message'><p><strong>".__("Record Updated", "wmw")."</strong>.</p></div>";
	}
	if ($info == "del") {
		$delid = $_GET["did"];
		$wpdb->query("delete from " . $table_modal . " where id=" . $delid);
		echo "<div class='updated' id='message'><p><strong>".__("Record Deleted", "wmw").".</strong>.</p></div>";
	}
	$resultat = $wpdb->get_results("SELECT * FROM " . $table_modal . " order by id asc");
	$count = count($resultat);
?>
<div class="wow">
	<h1><?php echo WOW_WMW_NAME; ?> <a href='https://www.facebook.com/wowaffect/' target="_blank" title="Join us on Facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></h1>
	<ul class="wow-admin-menu">
		<li><a href='admin.php?page=<?php echo WOW_WMW_SLUG; ?>'><?php esc_attr_e("List", "wmw") ?></a></li>
		<li>
			<?php if($count<3){?>
				<a href='admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=add' ><?php esc_attr_e("Add new", "wmw") ?></a>
			<?php } ?>
		</li>
		<li><a href='admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=discount'><b><?php esc_attr_e("Pro version", "wmw") ?></b></a></li>
		<li><a href='admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=items'><b><?php esc_attr_e("Free Plugins", "wmw") ?></b></a></li>
		<li><a href='admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=faq'><b><?php esc_attr_e("FAQ", "wmw") ?></b></a></li>
		
	</ul>	