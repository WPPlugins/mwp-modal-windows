<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<table>
    <thead>
		<tr>
			<th><u><?php esc_attr_e("Order", "wmw") ?></u></th>
			<th><u><?php esc_attr_e("Name", "wmw") ?></u></th> 
			<th><u><?php esc_attr_e("Shortcode", "wmw") ?></u></th>
			<th><u><?php esc_attr_e("ID", "wmw") ?></u></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
    <tbody>
		<?php
			if ($resultat) {
				$i = 0;
				foreach ($resultat as $key => $value) {
					$i++;			   
					$id = $value->id;
					$title = $value->title;        
				?>
				<tr>
					<td><?php echo "$i"; ?></td>
					<td><?php echo $title; ?></td>
					<td><?php echo "[Wow-Modal-Windows id=$id]"; ?></td>
					<td><?php echo "$id"; ?></td>         
					<td><u><a href="admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=add&act=update&id=<?php echo $id; ?>"><?php esc_attr_e("Edit", "wmw") ?></a></u></td>
					<td><u><a href="admin.php?page=<?php echo WOW_WMW_SLUG; ?>&info=del&did=<?php echo $id; ?>"><?php esc_attr_e("Delete", "wmw") ?></a></u></td>
					<td><?php if($count<3){; ?><u><a href="admin.php?page=<?php echo WOW_WMW_SLUG; ?>&wow=add&act=duplicate&id=<?php echo $id; ?>"><?php esc_attr_e("Duplicate", "wmw") ?></a></u><?php } ?></td>        
				</tr>
				<?php
					if($i>3) break;
				}
			} 
		?>
		
	</tbody>
</table>
