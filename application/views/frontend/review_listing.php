<?php foreach ($reviews as $review) { ?>
<div id="review-<?php echo $review->id ?>">
	<div class="row single-comment" >
		<div class="large-1 columns user-avatar">
			<img src="<?php echo base_url()?>static/frontend/img/unnamed.png"
				alt="slide 1" /> 
		</div>
		<div class="large-11 columns user-comments">
			<div class="row">
				<div class="large-12">
					<div class="large-6 columns" style="padding-left:0px">
						<a href=""><?php echo($review->user_info['username']); ?></a>
						<span style="font-size:12px"><i>Posted on: (<?php echo($review->publish_time); ?>)</i></span>
					</div>
					<div class="large-6 columns">
						<?php if($this->session->userdata('id') == $review->user_id) { ?>
							<span style="font-size:12px;float:right;margin-right:0px">
								<a href="#review-form-link" onclick="open_edit_form(<?php echo $review->id ?>,
																					'<?php echo $review->title ?>', 
																					'<?php echo $review->content ?>', 
																					'<?php echo $review->rating; ?>')" >
									Edit</a> 
								|
								<a class="delete-review-link" id="delete-review-<?php echo $review->id; ?>">Delete</a>
							</span>
						<?php } else { ?>
							&nbsp
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="large-8 columns">
						<h5 class="review-title"><?php echo($review->title); ?></h5>
					</div>
					<div class="large-2 columns">
			        	<div class="row" style="position:relative; right:0px">
			        		<?php if($review->rating == 1) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
				        	<?php if($review->rating == 2) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 3) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 4) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 5) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        	</div>
					</div>
				</div>
				<div class="large-12">
					<span class="review-content"><?php echo(strip_tags($review->content));?></span>
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>

<?php } ?>
<?php if(isset($offset)) { ?> 
	<a id="next-reviews">Read more...</a>
	<p id="next-offset" style="display:none"><?php echo( $offset ); ?></p>
<?php } ?>

<script type="text/javascript">
	function delete_review(id) {
		var confirmed = confirm("Delete this review?");
		if(confirmed) {
			$.ajax({
	  			type : "POST",
	  			url : "<?php echo base_url()?>index.php/restaurant/user_delete_review/",
	  			data: "review_id=" + id,
	  			success: function(result) {
	  				if(result == "success") {
	  					// refresh comments
  						// $("#review-" + id).remove();	// temporal solutioin
  						// $("span#number-of-reviews").html(parseInt($("span#number-of-reviews").html())-1); 
						$('.comment-container').slideUp(1500);
						var dest = '<?php echo base_url("/index.php/restaurant/show_restaurant/" . $restaurant->id); ?>';
						jQuery.get(dest, function(html){
							jQuery(".comment-container").slideDown(1500);
							var new_html = $(html).find(".comments").html();
							jQuery("#comments-listing").html(new_html);
							jQuery("#comments-listing .star").rating(); 
							SELF.reviewSubmit();
						});

  				// 		<?php if( isset($offset) && isset($review_per_load) ) { ?>
						// 	var newOffset = parseInt($("p#next-offset").html()) - 1;
				  // 			$("p#next-offset").html(newOffset);
				  // 			console.log(newOffset);
				  // 			$('a#next-reviews').attr('onclick','').unbind('click');
	  			// 			$("a#next-reviews").on("click", function() {
					 //  			load_review( newOffset, <?php echo $review_per_load ?>);
					 //  		});
						// <?php } ?>
	  				
	  				}	
	  				else {
	  					console.log("Something went wrong! Cannot delete review");
	  				}
	  			}
	  		});
		}
	}	

	function open_edit_form(id, title, content, rating) {
		$("#review-form").show();
		$("#review-form input[name=review-id]").val(id);
		$("#review-form input[name=title]").val(title);
		$("#review-form textarea[name=content]").text(content);
		$("#review-form input.star:nth-child(" + (parseInt(rating)+1).toString() + ")" ).click();
	}

	function clear_edit_form() {
		$("#review-form input[name=review-id]").val();
		$("#review-form input[name=title]").val("");
		$("#review-form textarea[name=content]").text("");
		$(".rating-cancel").trigger("click");
	}
</script>