<?php
	/*
	 *	DEXS TOC 
	 *
	 *	@since	1.1.0
	 *	@update	1.2.0
	 *	@update	1.2.2
	 *
	 *	@info	The class is now independent and is called through the dexsTOC function (see below).
	 */
	class _dexs_TOC{
		/*
		 *	CHECK VARIABLES
		 */
		private $ulCounter = 0;		// HOW MANY UL's ARE OPEN
		private $liCounter = 0;		// HOW MANY LI's ARE OPEN
		
		/*
		 *	RENDER VARIABLES
		 */
		private $items = array();	// THE TOC-LIST
		private $itemCount = 0;		// HOW MANY ITEMS ARE IN THE LIST
		private $itemCounter = 0;	// WHICH ITEM IS IN RENDER-PROCRESS
		private $nextItem = false;	// LOAD THE NEXT ITEM
		
		private $curDepth = 0;			// PREVIOUS DEPTH
		private $depthStart = false;	// WITH WHICH DEPTH STARTS THE CONTENT?
		
		/*
		 *	TOC-BOX CONFIGURATION VARIABLES
		 */
		private $config = array();	// THE TOC-LIST CONFIGURATION
		private $content = "";		// THE POST CONTENT
		private $isWidget = false;	// INSIDE A WIDGET?
		
		/*
		 *	ADD ANCHOR VARIABLES
		 */
		static private $anchor = false;
		
		/*
		 *	CONSTRUCTOR
		 *	
		 *	@since	1.0.0
		 *	@update	1.2.0
		 *	@update	1.2.1	-	Add the_content filter hook
		 *	@update 1.2.2	-	Remove costum add_toc_container filter
		 */
		public function __construct(){
			add_filter("the_content", array("_dexs_TOC", "_add_anchor"), 11);
				
			remove_filter("the_content", "wpautop" );
			add_filter("the_content", "wpautop" , 12);
			add_filter("the_content", "shortcode_unautop", 13);
		}
		
		/*
		 *	ADD TOC ANCHORS
		 *
		 *	@since	1.2.0
		 *	@update	1.2.1
		 *	@update	1.2.2	-	Remove stupid codes
		 *
		 *	@return	string	The modified post content!
		 */
		static public function _add_anchor($content){
			if(self::$anchor == true){
				return;
			}
			remove_filter("the_content", array("_dexs_TOC", "_add_anchor"), 11);
			remove_filter("the_content", "do_shortcode", 11);
			$new_content = apply_filters("the_content", get_the_content());
			add_filter("the_content", "do_shortcode", 11);
			
			$lines = array(); $count = 0;
			
			if(preg_match("#\<[a-zA-Z]* class\=\"anchor-[1-6]\"\>#", $new_content)){
				$new_content = explode("\n", $new_content);
				$new_counter = count($new_content); $i = 0;
				
				$check = "#\<[a-zA-Z]* class\=\"anchor-[1-6]\"\>#";
				$textRep = "#\<[a-zA-Z]* class\=\"anchor-[1-6]\"\>(.*)\<\/[a-zA-Z]*\>#";
				
				foreach($new_content AS $line){
					if(preg_match($check, $line)){
						$text = preg_replace($textRep, "$1", strip_tags($line));
						$link = str_replace(" ", "_", strtolower($text));
						
						$class = "dexs-ntree-anchor";
						$lines[] = "<span id='".trim($link)."' class='".$class."'></span>";
						
						$count++;
					} else {
						$lines[] = wpautop($line);
					}
					$i++;
				}
			
			} else if(preg_match("#\<h[1-6]\>(.*)<\/h[1-6]\>#", $new_content)){
				$new_content = explode("\n", $new_content);
				$new_counter = count($new_content); $i = 0;
				
				$check = "#\<h[1-6]\>(.*)<\/h[1-6]\>#";
				$numRep = "#\<h([1-6])\>(.*)\<\/h([1-6])\>#";
				$textRep = "#\<h[1-6]\>(.*)\<\/h[1-6]\>#";
				
				foreach($new_content AS $line){
					if(preg_match($check, $line)){
						$text = preg_replace($textRep, "$1", strip_tags($line));
						$link = str_replace(" ", "_", strtolower($text));
						$num = preg_replace($numRep, "$1", $line); $num = (int) trim($num);
						
						$class = "dexs-ntree-anchor";
						$lines[] = "<span id='".trim($link)."' class='".$class."'></span>".$line;
						
						$count++;
					} else {
						$lines[] = $line;
					}
					$i++;
				}
			}
			
			if(is_array($lines) && count($lines) > 0){
				self::$anchor = true;
				$new_content = implode("\n", $lines);
				
				return do_shortcode($new_content);
			}
			
			return $content;
		}
		
		/*
		 *	RENDER TOC BOX
		 *
		 *	@since	1.2.0
		 *	@update	1.2.1	-	Use intern post content.
		 *	@update	1.2.2	-	New "content-catch" function
		 *
		 *	@return	string	THE OUTPUT
		 */
		public function _renderTOC($config, $widget = false){
			$this->config = $config;
			
			remove_filter("the_content", array("_dexs_TOC", "_add_anchor"), 11);
			remove_filter("the_content", "do_shortcode", 11);
			$this->content = apply_filters("the_content", get_the_content());
			add_filter("the_content", "do_shortcode", 11);
			
			$this->isWidget = $widget;
			
			ob_start();
			$this->_start_toc($this->config["title"]);
			
			if(!$this->_get_items($this->config["type"], $this->content)){
				echo __("Error: The Plugin cannot create a list, please check your post-content!", "dexs-ntree");
			} else {
				for($this->itemCounter = 0; $this->itemCounter < $this->itemCount; $this->itemCounter++){
					if($this->itemCounter < ($this->itemCount-1)){
						$this->nextItem = $this->items[($this->itemCounter+1)];
					} else {
						$this->nextItem = false;
					}
					
					$item = $this->items[$this->itemCounter]["title"];
					$depth = $this->items[$this->itemCounter]["depth"];
					$link = $this->items[$this->itemCounter]["link"];
					$this->_render_item($item, $depth, $link);
				}
			}
			$this->_end_toc();
			$output = ob_get_contents();
			ob_get_clean();
			
			if($this->ulCounter !== 0 && $this->liCounter !== 0){
				$output = "";
				ob_start();
				
				$this->_start_toc($config["title"]);
				echo __("Error: An error occurred during the TOC-rendering.", "dexs-ntree");
				$this->_end_toc();
				
				$output = ob_get_contents();
				ob_get_clean();
				
				return trim($output);
			}
			
			return trim($output);
		}
		
		/*
		 *	GET LIST ITEMS
		 *
		 *	Creates the TOC-list ($this->list)
		 *
		 *	@since	1.2.0
		 *	@update	1.2.2
		 */
		private function _get_items($type, $content){
			$lines = array();
			$this->depthStart = false;
			
			if(strtolower($type) === "c"){
				$content = strip_tags($content, "<span><p><div><i><b><strong><section>");
				$content = explode("\n", $content);
				$counter = count($content);
				
				$check = "#\<[a-zA-Z]* class\=\"anchor-[1-6]\"\>#";
				$numRep = "#\<[a-zA-Z]* class\=\"anchor-([1-6])\"\>.*\<\/[a-zA-Z]*\>#";
				$textRep = "#\<[a-zA-Z]* class\=\"anchor-[1-6]\"\>(.*)\<\/[a-zA-Z]*\>#";
			}
			
			if(strtolower($type) === "h"){
				$content = strip_tags($content, "<h1><h2><h3><h4><h5><h6>");
				$content = explode("\n", $content);
				$counter = count($content);
				
				$check = "#\<h[1-6]\>#";
				$numRep = "#\<h([1-6])\>(.*)\<\/h([1-6])\>#";
				$textRep = "#\<h[1-6]\>(.*)\<\/h[1-6]\>#";
			}
			
			if(is_array($content) && $counter > 0){
				$this->itemCount = 0;
				for($i = 0; $i < $counter; $i++){
					if(preg_match($check, $content[$i])){
						$num = preg_replace($numRep, "$1", $content[$i]); $num = (int) trim($num);
						$text = preg_replace($textRep, "$1", $content[$i]);
						$text = trim(strip_tags($text));
						
						if($this->depthStart === false){
							$this->depthStart = $num;
							
							if($this->config["post_title"] === true){
								if($this->config["post_sub"] === true){
									$this->depthStart = $this->depthStart-1;
								}
								$link = str_replace(" ", "_", strtolower(get_the_title()));
								
								$lines[] = array("depth" => 0, "title" => get_the_title(), "link" => $link);
								$this->itemCount++;
							}
						}
						
						$num = ($num - $this->depthStart);
						$link = str_replace(" ", "_", strtolower($text));
						
						$lines[] = array("depth" => $num, "title" => $text, "link" => $link);
						$this->itemCount++;
					}
				}
			}
			
			if(is_array($lines) && count($lines) > 0){
				$this->items = $lines;
				return true;
			}
			
			return false;
		}
		
		/*
		 *	RENDER EACH ITEM
		 *
		 *	@since	1.2.0
		 */
		private function _render_item($item, $depth, $link){
			if($this->itemCounter == 0){
				$this->curDepth = $depth;
			}
			
			$parent = false;
			if($this->nextItem["depth"] > $depth){
				$parent = true;
			}
			
			if($this->itemCounter == 0 || $depth > $this->curDepth){
				$this->_start_ul($depth);
			}
			
			$this->_start_li($this->itemCounter, $parent);
			$this->_list_item($item, $link);
			
			if($this->nextItem !== false){
				if($depth >= $this->nextItem["depth"]){
					$step = (($depth+1) - $this->nextItem["depth"]);
					
					for($i = 0; $i < $step; $i++){
						$this->_end_li();
						if($i !== ($step-1)){ $this->_end_ul(); }
					}
				}
			} else if($this->itemCounter == ($this->itemCount-1)){
				if($this->liCounter == $this->ulCounter){
					$step = $this->ulCounter;
					
					for($i = 0; $i < $step; $i++){
						$this->_end_li();
						$this->_end_ul();
					}
				}
			}
			
			$this->curDepth = $depth;
		}
		
		/*
		 *	CREATE CSS
		 *
		 *	@since	1.2.0
		 */
		private function _create_css(){
			if(in_array($this->config["align"], array("left", "right", "none"))){
				$align = "display: inline;float: ".$this->config["align"].";";
				
				$margin = "margin: 0 0 5px 0;";
				if($this->config["align"] == "left"){
					$margin = "margin: 0 5px 5px 0;";
				}
				if($this->config["align"] == "right"){
					$margin = "margin: 0 0 5px 5px;";
				}
			} else {
				$align = "display: block;text-align: center;";
				$margin = "margin: 0 0 5px 0;";
			}
			
			$class = "";
			if($this->isWidget){
				$class = ".dexs-toc-widget";
			}
			
			$color = explode(",", $this->config["colors"]);
			$border = $this->config["border"];
			$background = $this->config["background"];
			
			ob_start();
			?>
			<?php if($this->isWidget){ ?>
			.dexs-toc.dexs-toc-widget{
				display: block;
				margin: 0;
				float: none;
				text-align: left;
			}
			<?php } else { ?>
			.dexs-toc{
				<?php echo $margin; ?>
				<?php echo $align; ?>
			}
			<?php } ?>
			<?php if($this->config["align"] == "center"){ ?>
			.dexs-toc>.dexs-toc-container{
				margin: 0 auto;
				display: inline-block;
			}
			<?php } ?>
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container{
				border: <?php echo $border; ?>;
				text-align: left;
				<?php if($background !== "default"){ echo "background: ".$background.";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li{
				<?php if($color[0] !== "default"){ echo "color: ".$color[0].";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li:before,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li:before{
				<?php if($color[0] !== "default"){ echo "color: ".$color[0].";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li:hover,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li:hover{
				<?php if($color[0] !== "default"){ echo "color: ".$color[0].";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li:hover:before,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li:hover:before{
				<?php if($color[0] !== "default"){ echo "color: ".$color[0].";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li a,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li a{
				<?php if($color[1] !== "default"){ echo "color: ".$color[1].";"; } ?>
			}
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ul li a:hover,
			.dexs-toc<?php echo $class; ?>>.dexs-toc-container ol li a:hover{
				<?php if($color[2] !== "default"){ echo "color: ".$color[2].";"; } ?>
			}
			<?php echo $this->config["css"]; ?>
			<?php
			$return = ob_get_contents();
			ob_end_clean();
			
			return $return;
		}
		
		/*
		 *	START TOC CONTAINER
		 *
		 *	@since	1.2.0
		 *	@update	1.2.2
		 */
		private function _start_toc($title){
			$class = "dexs-toc";
			if($this->isWidget){
				$class .= " dexs-toc-widget";
			}
			?><div><style type="text/css"><?php echo str_replace(array("\t","}"), array("", "}\n"), $this->_create_css()); ?></style></div>
				<div class="<?php echo $class; ?>">
					<div class="dexs-toc-container dexs-toc-style-<?php echo $this->config["design"]; ?>">
						<?php if(!$this->isWidget){ ?>
							<div class="dexs-toc-title"><?php echo $title; ?></div>
			<?php }
		}
		
		/*
		 *	START UL
		 *
		 *	@since	1.1.0
		 */
		private function _start_ul($depth){
			$class = "dexs-toc-list";
			$class .= " dexs-toc-list-depth-".$depth;
			?>
				<<?php echo $this->config["tag"]; ?> class="<?php echo $class; ?>">
			<?php
			$this->ulCounter++;
		}
		
		/*
		 *	START LI
		 *
		 *	@since	1.1.0
		 */
		private function _start_li($num, $parent){
			$id = "dexs-toc-item-".$num;
			$class = "dexs-toc-item";
			$class .= " dexs-toc-item-".$num;
			if($parent == true){
				$class .= " dexs-toc-item-has-parent";
			}
			?>
				<li id="<?php echo $id; ?>" class="<?php echo $class; ?>">
			<?php
			$this->liCounter++;
		}
		
		/*
		 *	LIST ITEM
		 *
		 *	@since	1.1.0
		 */
		private function _list_item($item, $link){
			if($this->config["anchor"] === true){
				?>
					<a href="#<?php echo $link; ?>"><?php echo $item; ?></a>
				<?php
			} else {
				?>
					<span><?php echo $item; ?></span>
				<?php
			}
		}
		
		/*
		 *	END LI
		 *
		 *	@since	1.1.0
		 */
		private function _end_li(){
			?>
				</li>
			<?php
			$this->liCounter--;
		}
		
		/*
		 *	END UL
		 *
		 *	@since	1.1.0
		 */
		private function _end_ul(){
			?>
				</<?php echo $this->config["tag"]; ?>>
			<?php
			$this->ulCounter--;
		}
		
		/*
		 *	END TOC CONTAINER
		 *
		 *	@since	1.2.0
		 */
		private function _end_toc(){
			?>
				</div>
			</div><?php
		}
	}
	$dexsTOC = new _dexs_TOC();
	
	/*
	 *	FUNCTION FOR DEXS_TOC CLASS
	 *
	 *	@since	1.2.0
	 *	@update	1.2.1	-	Merge config array.
	 *						2 params
	 *
	 *	@param	array	TOC CONFIGURATION SET
	 *	@param	boolean	INSIDE A WIDGET? (true = yes || false = no)
	 */
	function dexsTOC($config, $widget = false){
		global $dexs_ntree, $dexsTOC;
		
		$default = $dexs_ntree->_getAdminConfig();
		$config = array_merge((array) $default, (array) $config);
		
		return $dexsTOC->_renderTOC($config, $widget);
	}
	
?>