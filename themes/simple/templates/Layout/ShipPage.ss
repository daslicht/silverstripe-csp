<%-- <% include SideBar %> --%>
<div class="">
    <article>
        <h1>$Title</h1>
        $Content       
        <div class="content">$Content</div>
    </article>

    <div id="iview">
        <% loop $Images %>
         
            <a href="#">
                <div data-iview:thumbnail="$Image.URL" data-iview:image="$Image.URL">
                    <div class="iview-caption" data-x="0" data-y="0" data-transition="random">Test</div>
                </div>
            </a>
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
