<%-- <% include SideBar %> --%>
<div class="content-container unit size3of4 lastUnit">
    <article>
        <h1>$Title</h1>
        $Content      

        <div class="content">$Content</div>
    </article>
    <div>hallo welt</div>
 

    <div id="iview">
        <% loop $Images %>
            <div data-iview:thumbnail="" data-iview:image="$Image.URL">
                <div class="iview-caption" data-x="100" data-y="" data-transition="random">Test</div>
                <a class="vtemslideshow-link" href="$Up.LINK">&nbsp;</a> 
            </div>        
        <% end_loop %>
    </div>

<%--     <% loop $Images %>
	    <div>

	    $Image.SetWidth(150).URL
        $featured

	    </div>
        <article>
            <h2><a href="$Link" title="Read more on &quot;{$Title}&quot;">$Title</a></h2>
            $Photo.SetWidth(150)
            <p>$Content.FirstParagraph</p>
            <a href="$Link" title="Read more on &quot;{$Title}&quot;">Read more &gt;&gt;</a>
        </article>
    <% end_loop %> --%>
        $Form
</div>
