<% include SideBar %>
<div class="">
    <article>
        <h1>$Title</h1>
        $Content       
        <div class="content">$Content</div>
    </article>
    $Form
    <% loop $SearchResults %>
        <% include ShipTeaser %>
    <% end_loop %>   
</div>