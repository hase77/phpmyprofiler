{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

footer.tpl

===============================================================================
*}

      </div> <!-- CONTAINER -->

      <footer class="panel-footer">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <ul class="list-unstyled">
                     <li class="pull-right"><a href="#top">Back to top</a></li>
                     <li>{t}Built by{/t}&nbsp;<a href="http://www.phpmyprofiler.de">phpMyProfiler&nbsp;{$pmp_version}</a>&nbsp;-&nbsp;{t}published under General Public License (GPL){/t}</li>
                     <li>{if isset($last_update)}&nbsp;-&nbsp;{t}Last update{/t}&nbsp;{$last_update}{else}&nbsp;{/if}</li>
                     <li class="pull-right"><img src="themes/{$pmp_theme}/images/valid-html5.gif" alt="Valid HTML5"></li>
                     <li>Theme "Bstrap" 0.4.003 by&nbsp;<a href="http://www.lewe.com">George Lewe</a></li>
                     <li class="pull-right"><img src="themes/{$pmp_theme}/images/valid-css3.gif" alt="Valid CSS3"></li>
                     <li>&nbsp;</li>
                     <li class="pull-right"><img src="themes/{$pmp_theme}/images/responsive.gif" alt="Responsive"></li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>

      <!-- ==================================================================== 
      JAVASCRIPT
      Placed at the end of the document so the pages load faster 
      -->
		{literal}
		<script type="text/javascript">
			//<![CDATA[
			           
         /*
          *  Simple image gallery. Uses default settings
          */
         $('.fancybox').fancybox();

         /*
          *  Different effects
          */
         // Change title type, overlay closing speed
         $(".fancybox-effects-a").fancybox({
            helpers: {
               title :   { type : 'outside' },
               overlay : { speedOut : 0 }
            }
         });

         // Disable opening and closing animations, change title type
         $(".fancybox-effects-b").fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            helpers : {
               title : { type : 'over' }
            }
         });

         // Set custom style, close if clicked, change title type and overlay color
         $(".fancybox-effects-c").fancybox({
            wrapCSS    : 'fancybox-custom',
            closeClick : true,
            openEffect : 'none',
            helpers : {
               title : { type : 'inside' },
               overlay : {  css:{'background':'rgba(238,238,238,0.85)'} }
            }
         });

         // Remove padding, set opening and closing animations, close if clicked and disable overlay
         $(".fancybox-effects-d").fancybox({
            padding: 0,
            openEffect : 'elastic',
            openSpeed  : 150,
            closeEffect : 'elastic',
            closeSpeed  : 150,
            closeClick : true,
            helpers : {
               overlay : null
            }
         });

         /*
          *  Button helper. Disable animations, hide close button, change title type and content
          */
         $('.fancybox-buttons').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            prevEffect : 'none',
            nextEffect : 'none',
            closeBtn  : false,
            helpers : {
               title : { type : 'inside' },
               buttons  : {}
            },
            afterLoad : function() {
               this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
            }
         });

         /*
          *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
          */
         $('.fancybox-thumbs').fancybox({
            prevEffect : 'none',
            nextEffect : 'none',
            closeBtn  : false,
            arrows    : false,
            nextClick : true,
            helpers : {
               thumbs : { width  : 50, height : 50 }
            }
         });

         /*
          *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
          */
         $('.fancybox-media')
            .attr('rel', 'media-gallery')
            .fancybox({
               openEffect : 'none',
               closeEffect : 'none',
               prevEffect : 'none',
               nextEffect : 'none',
               arrows : false,
               helpers : {
                  media : {},
                  buttons : {}
               }
            });

         /*
          *  Open manually
          */
         $("#fancybox-manual-a").click(function() {
            $.fancybox.open('1_b.jpg');
         });

         $("#fancybox-manual-b").click(function() {
            $.fancybox.open({
               href : 'iframe.html',
               type : 'iframe',
               padding : 5
            });
         });

         $("#fancybox-manual-c").click(function() {
            $.fancybox.open([
               { href : '1_b.jpg', title : 'My title' }, 
               { href : '2_b.jpg', title : '2nd title' }, 
               { href : '3_b.jpg' }
            ], {
               helpers : {
                  thumbs : { width: 75, height: 50 }
               }
            });
         });
			           
			           
			jQuery(".title_select").on("click", getTitle);
			jQuery(".title_select_sub").on("click", getTitleSub);
			jQuery(".title_page").on("click", getTitlePage);

			function getTitle(event) {
				var url = window.location.pathname;
				var id = jQuery(this).attr("id").substr(2,jQuery(this).attr("id").length-2);
				var data = "ajax_call=1&content=filmprofile&id=" + id;

				jQuery.get(url, data, function(response) {
					jQuery('#right-frame').replaceWith(response);
					jQuery(".title_select_sub").on("click", getTitleSub);
					jQuery(".title_page").on("click", getTitlePage);
					$('.fancybox').fancybox({'type':'image'});
				}, "html");

				return false;
			}
			
			function getTitleSub() {
				var url = window.location.pathname;
				var id = jQuery(this).attr("id").substr(2,jQuery(this).attr("id").length-2);
				var data = "ajax_call=1&content=filmprofile&id=" + id;

				jQuery.get(url, data, function(response) {
					jQuery('#right-frame').replaceWith(response);
					jQuery(".title_select_sub").on("click", getTitleSub);
					jQuery(".title_page").on("click", getTitlePage);
					$('.fancybox').fancybox({'type':'image'});
				}, "html");

				return false;
			}


			function getTitlePage() {
				var url = window.location.pathname;
				var id = jQuery(this).parent().attr("id").substr(2,jQuery(this).parent().attr("id").length-2);
				var page = jQuery(this).attr('id').substr(4,jQuery(this).attr("id").length-4)
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
      <script src="themes/bstrap/css/bootstrap.css/js/jquery-1.10.2.min.js"></script>
      <script src="themes/bstrap/css/bootstrap.css/js/bootstrap.min.js"></script>
      
   </body>
</html>
