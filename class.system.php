<?php
	/*
	 *	DEXS NTREE SYSTEM CLASS
	 *
	 *	@since	1.2.0
	 */
	class dexs_ntreeSystem{
		/*
		 *	DEFAULT SETTINGS
		 */
		public $defaultC = array(
			"toc_type"					=> "h",
			"toc_post_title"			=> true,
			"toc_post_suborder"			=> false,
			"toc_box_title"				=> "Table of Contents",
			"toc_box_alignment"			=> "right",
			"toc_box_border_width"		=> 1,
			"toc_box_border_style"		=> "solid",
			"toc_box_border_color"		=> "#d0d0d0",
			"toc_box_background"		=> "transparent",
			"toc_list_tag"				=> "ul",
			"toc_list_design"			=> "level_num",
			"toc_font_color"			=> "default",
			"toc_link_color"			=> "default",
			"toc_link_hover_color"		=> "default",
			"anchor_linking"			=> true,
			"additional_css"			=> ".dexs-toc>.dexs-toc-container .dexs-toc-title{\n\tborder-bottom:1px solid #d0d0d0;\n\tbackground-color:#f0f0f0;\n\ttext-transform:uppercase;\n}"
		);
		
		
		/*
		 *	CONSTRUCTOR
		 *
		 *	@since	1.2.0
		 *	@update	1.2.1	-	Remove the_content anchor filter hook
		 */
		public function  __construct(){
			add_filter("plugin_row_meta", array($this, "_rowMetaFilter"), 10, 2);
			add_filter("plugin_action_links", array($this, "_actionFilter"), 10, 2);
			
			add_action("admin_init", array($this, "_adminConfig"));
			add_action("admin_enqueue_scripts", array($this, "_adminScripts"));
			add_action("admin_menu", array($this, "_admin"));
			add_action("wp_enqueue_scripts", array($this, "_scripts"));
			
			add_action("widgets_init", array($this, "_widget"));
			add_shortcode("dexs_toc", array($this, "_shortcode"));
		}
		
		/*
		 *	PLUGIN ROW META FILTER
		 *
		 *	@since	1.2.0
		 *	@update	1.2.2
		 */
		public function _rowMetaFilter($links, $file){
			if($file == dexsNTREE_PLUGIN){
				unset($links[0]);
				return array_merge(array("Version: ".dexsNTREE_VERSION, "Version-Code: ".dexsNTREE_VERCODE), $links);
			}
			return $links;
		}
		
		/*
		 *	PLUGIN ACTION LINK FILTER
		 *
		 *	@since	1.2.0
		 */
		public function _actionFilter($links, $file){
			$link = "<a href='".admin_url("options-general.php?page=dexs_ntree_config")."' title='".__("Configure this plugin", "dexs-ntree")."'>".__("Settings", "dexs-ntree")."</a>";
		
			if($file == dexsNTREE_PLUGIN){
				return array_merge(array("settings" => $link), $links);
			}
			return $links;
		}
		
		/*
		 *	ENQUEUE ADMIN SCRIPTS AND STYLES
		 *
		 *	@since	1.2.0
		 */
		public function _adminScripts(){
			wp_enqueue_style("dexs-ntree-admin", plugins_url("css/admin.ntree.css", __FILE__), array(), dexsNTREE_VERSION);
			wp_enqueue_script("iris");
			wp_enqueue_script("dexs-ntree-admin", plugins_url("js/admin.ntree.js", __FILE__), array("jquery", "iris"), dexsNTREE_VERSION, true);
		}
		
		/*
		 *	ADD ADMINISTRATION PAGE
		 *
		 *	@since	1.2.0
		 */
		public function _admin(){
			add_submenu_page("options-general.php", "Dexs Navigation Tree", "Dexs Navigation Tree", "manage_options", "dexs_ntree_config", array($this, "_adminPage"));
		}
		
		/*
		 *	ADMINISTRATION PAGE
		 *
		 *	@since	1.2.0
		 */
		public function _adminPage(){
			$config = $this->_getAdminConfig();
			
			?><div class="wrap"><?php
			require_once("admin.ntree.php");
			?></div><?php 
		}
		
		/*
		 *	GET ADMIN SETTINGS
		 *
		 *	@since	1.2.0
		 */
		public function _getAdminConfig(){
			$return = $this->defaultC;
			if(($config = get_option("dexs_ntree_default")) !== false){
				$return = array_merge($return, $config);
			}
			
			return $return;
		}
		
		/*
		 *	ADMINISTRATION SETTINGS
		 *
		 *	@since	1.2.0
		 */
		public function _adminConfig(){
			if(!isset($_POST["dexs_ntree_nonce"])){
				return;
			}
			if(!wp_verify_nonce($_POST["dexs_ntree_nonce"], "dexs_ntree_settings")){
				return;
			}
			if(!isset($_POST["dexs_ntree_action"]) || !in_array($_POST["dexs_ntree_action"], array("reset", "save"))){
				return;
			}
			
			if($_POST["dexs_ntree_action"] == "reset"){
				if(get_option("dexs_ntree_default") !== false){
					delete_option("dexs_ntree_default");
				}
				return true;
			}
		
			if($_POST["dexs_ntree_action"] == "save"){
				$new = array();
				
				foreach($this->defaultC AS $key => $value){
					if(is_bool($value)){
						if(array_key_exists($key, $_POST) && $_POST[$key] === "true"){
							$new[$key] = true;
						} else {
							$new[$key] = false;
						}
						continue;
					}
					
					if(is_numeric($value)){
						if(array_key_exists($key, $_POST)){
							$new[$key] = (int) $_POST[$key];
						} else {
							$new[$key] = 0;
						}
					}
					
					if(is_string($value)){
						if(array_key_exists($key, $_POST)){
							$new[$key] = $_POST[$key];
						} else {
							$new[$key] = $value;
						}
						continue;
					}
				}
				
				if(($old = get_option("dexs_ntree_default")) !== false){
					if($old === $new){
						return true;
					}
					
					if(update_option("dexs_ntree_default", $new)){
						return true;
					}
				} else {
					if(add_option("dexs_ntree_default", $new, "", "no")){
						return true;
					}
				}
			}
			
			return false;
		}
		
		/*
		 *	ENQUEUE FRONT-END SCRIPTS AND STYLES
		 *
		 *	@since	1.0.0
		 *	@update	1.2.0
		 *	@update	1.2.2
		 */
		public function _scripts(){
			if(!is_admin()){
				if(version_compare(get_bloginfo("version"), "3.8", "<")){
					wp_register_style("dashicons", plugins_url("css/dashicons.css", __FILE__), array(), "1.0.3");
				}
				if(version_compare(get_bloginfo("version"), "4.0", "<")){
					wp_deregister_style("dashicons");
					wp_register_style("dashicons", plugins_url("css/dashicons.css", __FILE__), array(), "1.0.3");
				}
				
				wp_enqueue_style("dashicons");
				wp_enqueue_style("dexs-ntree", plugins_url("css/ntree.css", __FILE__), array("dashicons"), dexsNTREE_VERSION);
			}
		}
		
		/*
		 *	REGISTER WIDGET
		 *
		 *	@since	1.1.0
		 */
		public function _widget(){
			register_widget("_dexs_ntreeWidget");
		}
	
		/*
		 *	SHORTCODE FUNCTION
		 *
		 *	@since	1.1.0
		 *	@update	1.2.0
		 *	@update	1.2.1	-	Add new dexsTOC function
		 *	@update	1.2.2
		 */
		public function _shortcode($atts){
			$default = $this->_getAdminConfig();
		
			$config = shortcode_atts(array(
				/* OLD CODES */
				"title"			=>	$default["toc_box_title"],
				"align"			=>	$default["toc_box_alignment"],
				"anchor"		=>	$default["anchor_linking"],
				"tag"			=>	$default["toc_list_tag"],
				"design"		=>	$default["toc_list_design"],
				"border"		=>	$default["toc_box_border_width"]."px ".$default["toc_box_border_style"]." ".$default["toc_box_border_color"],
				"background"	=>	$default["toc_box_background"],
				
				/* NEW CODES (SINCE 1.2.0) */
				"type"			=>	$default["toc_type"],
				"post_title"	=>	$default["toc_post_title"],
				"post_sub"		=>	$default["toc_post_suborder"],
				"colors"		=>	$default["toc_font_color"].",".$default["toc_link_color"].",".$default["toc_link_hover_color"],
				"css"			=>	$default["additional_css"],
				
				/* DEPRECATED (SINCE 1.2.0) */
				"anchor_above"	=>	NULL
			), $atts);
			
			if($config["design"] == "numeric"){ $config["design"] = "num"; }
			if($config["design"] == "costum"){ $config["design"] = "level_num"; }
			
			if($config["anchor"] === "true" || $config["anchor"] === true){
				$config["anchor"] = (bool) true;
			} else {
				$config["anchor"] = (bool) false;
			}
			if($config["post_title"] === "true" || $config["post_title"] === true){
				$config["post_title"] = (bool) true;
			} else {
				$config["post_title"] = (bool) false;
			}
			
			return dexsTOC($config, false);
			
			return;
		}
	}
	$dexs_ntree = new dexs_ntreeSystem();
	
	/*
	 *	FRONT-END SIDBAR WIDGET
	 *
	 *	@since	1.1.0
	 *	@update	1.2.0
	 */
	class _dexs_ntreeWidget extends WP_Widget{
		/* 
		 *	CONSTRUCTOR
		 *
		 *	@since	1.1.0
		 *	@update	1.2.0
		 */
		public function __construct(){
			$title = __("Table of Contents", "dexs-ntree");
			$meta = array(
				"description"	=> __("Show a Table of Contents Widget on each post, page and/or costum-post-type.", "dexs-ntree")." (Plugin: Dexs Navigation Tree)",
				"classname"		=> "dexs-ntree-widget-config"
			);
			
			parent::__construct("dexs-ntree-widget", $title, $meta);
		}
		
	
		/*
		 *	WIDGET OUTPUT
		 *
		 *	@since	1.1.0
		 *	@update	1.2.0
		 *	@update	1.2.1	-	Add new dexsTOC function
		 */
		public function widget($args, $instance){
			global $dexs_ntree, $wl_options;
			
			if($wl_options === NULL && (!is_page() && !is_single())){
				return;
			}
			
			$default = $dexs_ntree->_getAdminConfig();
			if($instance["widget_settings"] !== "default"){
				$default = array_merge($default, array_merge($dexs_ntree->defaultC, (array) $instance));
			}
			
			$config = array(
				/* OLD CODES */
				"title"			=>	$default["toc_box_title"],
				"align"			=>	$default["toc_box_alignment"],
				"anchor"		=>	$default["anchor_linking"],
				"tag"			=>	$default["toc_list_tag"],
				"design"		=>	$default["toc_list_design"],
				"border"		=>	$default["toc_box_border_width"]."px ".$default["toc_box_border_style"]." ".$default["toc_box_border_color"],
				"background"	=>	$default["toc_box_background"],
				
				/* NEW CODES (1.2.0) */
				"type"			=>	$default["toc_type"],
				"post_title"	=>	$default["toc_post_title"],
				"post_sub"		=>	$default["toc_post_suborder"],
				"colors"		=>	$default["toc_font_color"].",".$default["toc_link_color"].",".$default["toc_link_hover_color"],
				"css"			=>	$default["additional_css"],
				
				/* DEPRECATED (SINCE 1.2.0) */
				"anchor_above"	=>	NULL
			);
			
			echo $args["before_widget"];
			if(!empty($config["title"])){
				echo $args["before_title"].$config["title"].$args["after_title"];
			}
			
			echo str_replace("\r\n", "", dexsTOC($config, true));
			
			echo $args["after_widget"];
		}
		
		/*
		 *	UPDATE WIDGET SETTINGS
		 *
		 *	@since	1.1.0
		 *	@update	1.2.0
		 */
		public function update($new, $old){
			global $dexs_ntree;
			
			$instance = array();
			$default = $dexs_ntree->defaultC;
			
			$default = array_merge($default, array("widget_settings" => "default"));
			
			foreach($default AS $key => $value){
				if(is_bool($value)){
					if(array_key_exists($key, $new) && $new[$key] === "true"){
						$instance[$key] = true;
					} else {
						$instance[$key] = false;
					}
					continue;
				}
				
				if(is_numeric($value)){
					if(array_key_exists($key, $new)){
						$instance[$key] = (int) $new[$key];
					} else {
						$instance[$key] = 0;
					}
				}
				
				if(is_string($value)){
					if(array_key_exists($key, $new)){
						$instance[$key] = $new[$key];
					} else {
						$instance[$key] = $value;
					}
					continue;
				}
			}
			
			return $instance;
		}
		
		/* 
		 *	WIDGET SETTINGS
		 *
		 *	@since	1.1.0
		 *	@update	1.2.0
		 */
		public function form($instance){
			global $dexs_ntree;
			
			$default = $dexs_ntree->_getAdminConfig();
			$default = array_merge($default, array("widget_settings" => "default"));
			
			$config = array_merge($default, (array) $instance);
		?>
			<div class="dexs-ntree-widget">
				<section>
					<select <?php $this->in("widget_settings"); ?> class="widefat">
						<option value="default" <?php selected($config["widget_settings"], "default"); ?>><?php _e("Use default settings", "dexs-ntree"); ?></option>
						<option value="costum" <?php selected($config["widget_settings"], "costum"); ?>><?php _e("Use costum settings below", "dexs-ntree"); ?></option>
					</select>
				</section>
				
				<p class="description">
					<?php printf(__("Change the default settings <a href='%s'>here</a>.", "dexs-ntree"), admin_url("options-general.php?page=dexs_ntree_config")); ?>
				</p>
				
				<section>
					<label for="<?php $this->i("toc_box_title"); ?>" class="head"><?php _e("Widget Title", "dexs-ntree"); ?></label>
					<input type="text" <?php $this->in("toc_box_title"); ?> class="widefat" value="<?php echo $config["toc_box_title"]; ?>" />
				</section>
				
				<section>
					<label for="<?php $this->i("toc_type"); ?>" class="head"><?php _e("TOC Type", "dexs-ntree"); ?></label>
					<select <?php $this->in("toc_type"); ?> class="widefat">
						<option value="c" <?php selected($config["toc_type"], "c"); ?>><?php _e("Class Names", "dexs-ntree"); ?></option>
						<option value="h" <?php selected($config["toc_type"], "h"); ?>><?php _e("Heading Elements", "dexs-ntree"); ?></option>
					</select><br />
					<label><input type="checkbox" value="true" <?php $this->in("toc_post_title"); ?> <?php checked($config["toc_post_title"], true); ?> /> 
						<?php _e("Use the post title as first TOC item", "dexs-ntree"); ?>
					</label><br />
					<label><input type="checkbox" value="true" <?php $this->in("toc_post_suborder"); ?> <?php checked($config["toc_post_suborder"], true); ?> /> 
						<?php _e("Suborder all toc items under the post title", "dexs-ntree"); ?>
					</label>
				</section>
				
				<section>
					<label for="<?php $this->i("toc_box_border_style"); ?>" class="head"><?php _e("TOC Box Border", "dexs-ntree"); ?></label>
					<div class="widefat">
						<div class="ntree_border_input border">
							<input type="text" <?php $this->in("toc_box_border_width"); ?> value="<?php echo $config["toc_box_border_width"]; ?>" />
							<select <?php $this->in("toc_box_border_style"); ?>>
								<option value="solid" <?php selected($config["toc_box_border_style"], "solid"); ?>>Solid</option>
								<option value="dotted" <?php selected($config["toc_box_border_style"], "dotted"); ?>>Dotted</option>
								<option value="dashed" <?php selected($config["toc_box_border_style"], "dashed"); ?>>Dashed</option>
								<option value="double" <?php selected($config["toc_box_border_style"], "double"); ?>>Double</option>
								<option value="groove" <?php selected($config["toc_box_border_style"], "groove"); ?>>Groove</option>
								<option value="ridge" <?php selected($config["toc_box_border_style"], "ridge"); ?>>Ridge</option>
								<option value="inset" <?php selected($config["toc_box_border_style"], "inset"); ?>>Inset</option>
								<option value="outset" <?php selected($config["toc_box_border_style"], "outset"); ?>>Outset</option>
							</select>
							<input type="text" <?php $this->in("toc_box_border_color"); ?> class="ntree_border_color" value="<?php echo $config["toc_box_border_color"]; ?>" />
						</div>
					</div>
				</section>
				
				<section>
					<label for="<?php $this->i("toc_box_background"); ?>" class="head"><?php _e("TOC Box Background", "dexs-ntree"); ?></label>
					<div class="widefat">
						<div class="ntree_border_input">
							<input type="text" <?php $this->in("toc_box_background"); ?> class="widefat ntree_background_color" value="<?php echo $config["toc_box_background"]; ?>" />
						</div>
					</div>
				</section>
				
				<section>
					<label for="<?php $this->i("toc_list_tag"); ?>" class="head"><?php _e("TOC List Tag", "dexs-ntree"); ?></label>
					<select <?php $this->in("toc_list_tag"); ?> class="widefat">
						<option value="ul" <?php selected($config["toc_list_tag"], "ul"); ?>><?php _e("UL", "dexs-ntree"); ?></option>
						<option value="ol" <?php selected($config["toc_list_tag"], "ol"); ?>><?php _e("OL", "dexs-ntree"); ?></option>
					</select>
				</section>
				
				<section>
					<label for="<?php $this->i("toc_list_design"); ?>" class="head"><?php _e("TOC List Design", "dexs-ntree"); ?></label>
					<select <?php $this->in("toc_list_design"); ?> class="widefat">
						<option value="num" <?php selected($config["toc_list_design"], "num"); ?>><?php _e("Numeric", "dexs-ntree"); ?></option>
						<option value="level_num" <?php selected($config["toc_list_design"], "level_num"); ?>><?php _e("Level Numeric", "dexs-ntree"); ?></option>
						<option value="folder" <?php selected($config["toc_list_design"], "folder"); ?>><?php _e("Folder and Files", "dexs-ntree"); ?></option>
						<option value="folder_num" <?php selected($config["toc_list_design"], "folder_num"); ?>><?php _e("Folder and Numeric", "dexs-ntree"); ?></option>
					</select>
				</section>
				
				<section>
					<label class="head"><?php _e("TOC List Color", "dexs-ntree"); ?></label>
					<div class="widefat">
						<div class="ntree_border_input color">
							<input type="text" <?php $this->in("toc_font_color"); ?> class="ntree_font_color" value="<?php echo $config["toc_font_color"]; ?>" />
							<input type="text" <?php $this->in("toc_link_color"); ?> class="ntree_link_color" value="<?php echo $config["toc_link_color"]; ?>" />
							<input type="text" <?php $this->in("toc_link_hover_color"); ?> class="ntree_link_hover_color" value="<?php echo $config["toc_link_hover_color"]; ?>" />
						</div>
					</div>
				</section>
				
				<section>
					<label for="<?php $this->i("anchor_linking"); ?>" class="head"><?php _e("Anchor Linking", "dexs-ntree"); ?></label>
					<select <?php $this->in("anchor_linking"); ?> class="widefat">
						<option value="true" <?php selected($config["anchor_linking"], true); ?>><?php _e("Enable", "dexs-ntree"); ?></option>
						<option value="false" <?php selected($config["anchor_linking"], false); ?>><?php _e("Disable", "dexs-ntree"); ?></option>
					</select>
				</section>
				
				<section>
					<label for="<?php $this->i("additional_css"); ?>" class="head"><?php _e("Additional CSS", "dexs-ntree"); ?></label>
					<textarea <?php $this->in("additional_css"); ?> class="widefat" rows="8"><?php echo $config["additional_css"]; ?></textarea>
				</section>
			</div>
		<?php
		}
		
		/* 
		 *	SHORTCODE FUNCTION
		 *
		 *	@since	1.2.0
		 */
		private function i($string){
			echo $this->get_field_id($string);
		}
		
		/* 
		 *	SHORTCODE FUNCTION
		 *
		 *	@since	1.2.0
		 */
		private function n($string){
			echo $this->get_field_name($string);
		}
		
		/* 
		 *	SHORTCODE FUNCTION
		 *
		 *	@since	1.2.0
		 */
		private function in($string){
			echo "id='".$this->get_field_id($string)."' name='".$this->get_field_name($string)."'";
		}
	}

?>