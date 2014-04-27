{*
===============================================================================
phpMyProfiler Theme "Bstrap"
-------------------------------------------------------------------------------
Release:    0.4.003
Date:       2014-04-27
Author:     George Lewe (george@lewe.com)
Copyright:  (c) 2014. All rights reserved.
-------------------------------------------------------------------------------

update_log_end.tpl

===============================================================================
*}

         {if $founderror}
            <p>{t}Error: The update was not successful!{/t}</p>
			{else}
            <p>{t}Success. The database is now up-to-date{/t}</p>
			{/if}
         
      </div>
   </div>
</div>

{include file="admin/footer.tpl"}
