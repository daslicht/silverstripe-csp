<%-- <% include SideBar %> --%>
<div class="">
    <article>
        <h1>$Title</h1>
        $Content      

        <div class="content">$Content</div>
    </article>


    <div id="iview">
        <% loop $Images %>
            <div data-iview:thumbnail="" data-iview:image="$Image.URL">
                <div class="iview-caption" data-x="100" data-y="" data-transition="random">Test</div>
                <a class="vtemslideshow-link" href="$Up.LINK">&nbsp;</a> 
            </div>        
        <% end_loop %>
    </div>


</div>
