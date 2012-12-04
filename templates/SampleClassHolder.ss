<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <% base_tag %>
        <title>$Title &raquo; $SiteConfig.Title</title>
        <% require themedCSS(pagination) %>
    </head>
<body>
    <div id="content">
        <div class="container">
            <section>
            $Layout
            <% if GetChildren %>
                <ul class="ss-pagination-children">
                <% control GetChildren %>
                    <li><a href="$Link">$Title</a></li>
                <% end_control %>
                </ul>
            <% else %>
                <p>Nenhum texto publicado. Aguardem.</p>
            <% end_if %>

            <% if GetChildren.MoreThanOnePage %>
                <div id="tnt_pagination">
                <% if GetChildren.PrevLink %>
                    <a href="$GetChildren.PrevLink">&lt;&lt; Prev</a>
                <% end_if %>

                <% control GetChildren.Pages %>
                    <% if CurrentBool %>
                        <span class="active_tnt_link">$PageNum</span> 
                    <% else %>
                        <a href="$Link" title="Go to page $PageNum">$PageNum</a> 
                    <% end_if %>
                <% end_control %>

                <% if GetChildren.NextLink %>
                    <a href="$GetChildren.NextLink">Next&gt;&gt;</a>
                <% end_if %>
                </div>
            <% end_if %>            
            </section>            
        </div>
    </div>
</body>
</html>