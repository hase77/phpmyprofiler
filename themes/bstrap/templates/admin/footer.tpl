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
                     <li class="pull-right"><img src="../themes/{$pmp_theme}/images/valid-html5.gif" alt="Valid HTML5"></li>
                     <li>Theme "Bstrap" 0.4.003 by&nbsp;<a href="http://www.lewe.com">George Lewe</a></li>
                     <li class="pull-right"><img src="../themes/{$pmp_theme}/images/valid-css3.gif" alt="Valid CSS3"></li>
                     <li>&nbsp;</li>
                     <li class="pull-right"><img src="../themes/{$pmp_theme}/images/responsive.gif" alt="Responsive"></li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>

      <script src="../themes/bstrap/css/bootstrap.css/js/jquery-1.10.2.min.js"></script>
      <script src="../themes/bstrap/css/bootstrap.css/js/bootstrap.min.js"></script>
      
   </body>
</html>
