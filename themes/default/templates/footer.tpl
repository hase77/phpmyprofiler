			</tr>
		</table>

		{literal}
			<script type="text/javascript">
				//<![CDATA[
				$(document).ready(function() {
					$('.fancybox').fancybox({'type':'image'});
				});

				jQuery(".title_select").on("click", getTitle);
				jQuery(".title_select_sub").on("click", getTitleSub);
				jQuery(".title_page").on("click", getTitlePage);

				function getTitle(event) {
					var url = window.location.pathname;
					var id = jQuery(this).attr("id").substr(2, jQuery(this).attr("id").length-2);
					var data = "ajax_call=1&content=filmprofile&id=" + id;
 
					jQuery.get(url, data, function(response) {
						jQuery('#right-frame').replaceWith(response);
						jQuery(".title_select_sub").on("click", getTitleSub);
						jQuery(".title_page").on("click", getTitlePage);
						$('.fancybox').fancybox({'type':'image'});
					}, "html");
					
					jQuery('html, body').animate({scrollTop: $("#right-frame").offset().top}, 200);

					return false;
				}
				
				function getTitleSub() {
					var url = window.location.pathname;
					var id = jQuery(this).attr("id").substr(2, jQuery(this).attr("id").length-2);
					var data = "ajax_call=1&content=filmprofile&id=" + id;
 
					jQuery.get(url, data, function(response) {
						jQuery('#right-frame').replaceWith(response);
						jQuery(".title_select_sub").on("click", getTitleSub);
						jQuery(".title_page").on("click", getTitlePage);
						$('.fancybox').fancybox({'type':'image'});
					}, "html");
					
					jQuery('html, body').animate({scrollTop: $("#right-frame").offset().top}, 200);

					return false;
				}


				function getTitlePage() {
					var url = window.location.pathname;
					var id = jQuery(this).parent().attr("id").substr(2, jQuery(this).parent().attr("id").length-2);
					var page = jQuery(this).attr('id').substr(4, jQuery(this).attr("id").length-4)
					var data = "ajax_call=1&content=filmprofile&id=" + id + "&page=" + page;

					jQuery.get(url, data, function(response) {
						jQuery('#right-frame').replaceWith(response);
						jQuery(".title_select").on("click", getTitle);
						jQuery(".title_page").on("click", getTitlePage);
						$('.fancybox').fancybox({'type':'image'});
					}, "html");
				}

				//]]>
			</script>
		{/literal}
	</body>

</html>
