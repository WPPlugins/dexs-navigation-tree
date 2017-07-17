<div class="ntree_header">
	<span class="ntree_headerIcon dashicons dashicons-editor-justify"></span>
	<span class="ntree_headerTitle">Dexs Navigation Tree</span>
	<span class="ntree_headerVersion"><?php echo dexsNTREE_VERSION; ?></span>
</div>

<form method="post" action="">
	<h3><?php _e("TOC-Box Design", "dexs-ntree"); ?></h3>
	<table class="ntree_table">
		<tr>
			<th><label for="toc_type"><?php _e("TOC Type", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<select id="toc_type" name="toc_type">
					<option value="c" <?php selected($config["toc_type"], "c"); ?>><?php _e("Class Names", "dexs-ntree"); ?></option>
					<option value="h" <?php selected($config["toc_type"], "h"); ?>><?php _e("Heading Elements", "dexs-ntree"); ?></option>
				</select><br />
				<label><input type="checkbox" value="true" id="toc_post_title" name="toc_post_title" <?php checked($config["toc_post_title"], true); ?> /> 
					<?php _e("Use the post title as first TOC item", "dexs-ntree"); ?>
				</label><br />
				<label><input type="checkbox" value="true" id="toc_post_suborder" name="toc_post_suborder" <?php checked($config["toc_post_suborder"], true); ?> /> 
					<?php _e("Suborder all toc items under the post title", "dexs-ntree"); ?>
				</label>
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_box_title"><?php _e("TOC Box Title", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<input type="text" id="toc_box_title" name="toc_box_title" value="<?php echo $config["toc_box_title"]; ?>" />
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_box_alignment"><?php _e("TOC Box Alignment", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<select id="toc_box_alignment" name="toc_box_alignment">
					<option value="none" <?php selected($config["toc_box_alignment"], "none"); ?>><?php _e("None", "dexs-ntree"); ?></option>
					<option value="left" <?php selected($config["toc_box_alignment"], "left"); ?>><?php _e("Left", "dexs-ntree"); ?></option>
					<option value="right" <?php selected($config["toc_box_alignment"], "right"); ?>><?php _e("Right", "dexs-ntree"); ?></option>
					<option value="center" <?php selected($config["toc_box_alignment"], "center"); ?>><?php _e("Center", "dexs-ntree"); ?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_box_border_style"><?php _e("TOC Box Border", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<div style="width: 250px;">
					<div class="ntree_border_input border">
						<input type="text" id="toc_box_border_width" name="toc_box_border_width" value="<?php echo $config["toc_box_border_width"]; ?>" />
						<select id="toc_box_border_style" name="toc_box_border_style">
							<option value="solid" <?php selected($config["toc_box_border_style"], "solid"); ?>>Solid</option>
							<option value="dotted" <?php selected($config["toc_box_border_style"], "dotted"); ?>>Dotted</option>
							<option value="dashed" <?php selected($config["toc_box_border_style"], "dashed"); ?>>Dashed</option>
							<option value="double" <?php selected($config["toc_box_border_style"], "double"); ?>>Double</option>
							<option value="groove" <?php selected($config["toc_box_border_style"], "groove"); ?>>Groove</option>
							<option value="ridge" <?php selected($config["toc_box_border_style"], "ridge"); ?>>Ridge</option>
							<option value="inset" <?php selected($config["toc_box_border_style"], "inset"); ?>>Inset</option>
							<option value="outset" <?php selected($config["toc_box_border_style"], "outset"); ?>>Outset</option>
						</select>
						<input type="text" id="toc_box_border_color" name="toc_box_border_color" class="ntree_border_color" value="<?php echo $config["toc_box_border_color"]; ?>" />
					</div>
				</div>
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_box_background"><?php _e("TOC Box Background", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<div style="width: 250px;">
					<div class="ntree_border_input">
						<input type="text" id="toc_box_background" name="toc_box_background" class="ntree_background_color" value="<?php echo $config["toc_box_background"]; ?>" />
					</div>
				</div>
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_list_tag"><?php _e("TOC List Tag", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<select id="toc_list_tag" name="toc_list_tag">
					<option value="ul" <?php selected($config["toc_list_tag"], "ul"); ?>><?php _e("UL", "dexs-ntree"); ?></option>
					<option value="ol" <?php selected($config["toc_list_tag"], "ol"); ?>><?php _e("OL", "dexs-ntree"); ?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th><label for="toc_list_design"><?php _e("TOC List Design", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<select id="toc_list_design" name="toc_list_design">
					<option value="num" <?php selected($config["toc_list_design"], "num"); ?>><?php _e("Numeric", "dexs-ntree"); ?></option>
					<option value="level_num" <?php selected($config["toc_list_design"], "level_num"); ?>><?php _e("Level Numeric", "dexs-ntree"); ?></option>
					<option value="folder" <?php selected($config["toc_list_design"], "folder"); ?>><?php _e("Folder and Files", "dexs-ntree"); ?></option>
					<option value="folder_num" <?php selected($config["toc_list_design"], "folder_num"); ?>><?php _e("Folder and Numeric", "dexs-ntree"); ?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th><?php _e("TOC List Color", "dexs-ntree"); ?></th>
			<td class="ntree_help"></td>
			<td>
				<div style="width: 250px;">
					<div class="ntree_border_input color">
						<input type="text" id="toc_font_color" name="toc_font_color" class="ntree_font_color" value="<?php echo $config["toc_font_color"]; ?>" />
						<input type="text" id="toc_link_color" name="toc_link_color" class="ntree_link_color" value="<?php echo $config["toc_link_color"]; ?>" />
						<input type="text" id="toc_link_hover_color" name="toc_link_hover_color" class="ntree_link_hover_color" value="<?php echo $config["toc_link_hover_color"]; ?>" />
					</div>
				</div>
			</td>
		</tr>
		
		<tr>
			<th><label for="anchor_linking"><?php _e("Anchor Linking", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<select id="anchor_linking" name="anchor_linking">
					<option value="true" <?php selected($config["anchor_linking"], true); ?>><?php _e("Enable", "dexs-ntree"); ?></option>
					<option value="false" <?php selected($config["anchor_linking"], false); ?>><?php _e("Disable", "dexs-ntree"); ?></option>
				</select>
			</td>
		</div>
		
		<tr>
			<th><label for="additional_css"><?php _e("Additional CSS", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<textarea id="additional_css" name="additional_css" class="widefat" rows="8"><?php echo $config["additional_css"]; ?></textarea>
			</td>
		</div>
		
		<tr class="shortcode_tr" style="display:none;">
			<th><label for="additional_css"><?php _e("Shortcode Output", "dexs-ntree"); ?></label></th>
			<td class="ntree_help"></td>
			<td>
				<textarea class="widefat shortcode_output" rows="8"></textarea>
			</td>
		</div>
	</table><br />
	<div>
		<?php wp_nonce_field("dexs_ntree_settings", "dexs_ntree_nonce"); ?>
		<button name="dexs_ntree_action" value="save" class="button-primary"><?php _e("Save as Default", "dexs-ntree"); ?></button>&nbsp;
		<button name="dexs_ntree_action" value="reset" class="button-secondary"><?php _e("Restore Default", "dexs-ntree"); ?></button>&nbsp;
		<span id="dexs-ntree_shortcode-gen" class="button-secondary"><?php _e("Generate Shortcode", "dexs-ntree"); ?></span>
	</div>
</form>