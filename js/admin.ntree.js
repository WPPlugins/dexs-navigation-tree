jQuery(document).ready(function($){

	var ntree_obj = ["border_color", "background_color", "font_color", "link_color", "link_hover_color"];
	
	for(var i = 0; i < ntree_obj.length; i++){
		if($(".ntree_" + ntree_obj[i]).length > 0){
			$(".ntree_" + ntree_obj[i]).iris({
				width: 210
			});
		};
	};
	
	$(document).click(function(event){
		for(var i = 0; i < ntree_obj.length; i++){
			if($(".ntree_" + ntree_obj[i]).length > 0){
				if(!$(".ntree_" + ntree_obj[i]).is(event.target) && !$(".ntree_" + ntree_obj[i]).next("div").is(event.target)){
					$(".ntree_" + ntree_obj[i]).iris("hide");
				} else {
					$(".ntree_" + ntree_obj[i]).iris("show");
				};
			};
		};
	});
	
	$("#dexs-ntree_shortcode-gen").click(function(){
		var output = "";
		
		var postTitle, postSub = false;
		if($("input#toc_post_title:checked").length > 0){
			var postTitle = true;
		};
		if($("input#toc_post_suborder:checked").length > 0){
			var postSub = true;
		};
		
		var data = {
			"title":		$("input#toc_box_title").val(),
			"align": 		$("select#toc_box_alignment option:selected").val(),
			"anchor": 		$("select#anchor_linking option:selected").val(),
			"tag": 			$("select#toc_list_tag option:selected").val(),
			"design": 		$("select#toc_list_design option:selected").val(),
			"border": 		$("input#toc_box_border_width").val() + "px " + $("select#toc_box_border_style option:selected").val() + " " + $("input#toc_box_border_color").val(),
			"background": 	$("input#toc_box_background").val(),
			"type": 		$("select#toc_type option:selected").val(),
			"post_title": 	postTitle,
			"post_sub": 	postSub,
			"colors": 		$("input#toc_font_color").val() + "," + $("input#toc_link_color").val() + "," + $("input#toc_link_hover_color").val(),
			"css": 			$("textarea#additional_css").val().replace(/\n/g, "").replace(/\t/g, "")
		};
		
		output = "[dexs_toc";
		for(var i in data){
			output += " " + i + "=\"" + data[i] + "\"";
		};
		output += "]";
		
		$(".shortcode_tr").css("display", "table-row");
		$(".shortcode_output").text(output);
	});
	
});