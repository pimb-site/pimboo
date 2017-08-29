@if (Auth::user()->permission == 10)
<div class="top_menu">
	<a class="menu" href="/admin">
		<img src="/img/member_my_acc.png" />
		<div class="menu_text">Home</div>
	</a>
	<a class="menu" href="/admin/reports">
		<img src="/img/member_personal_info.png" />
		<div class="menu_text">Reports</div>
	</a>
	<a class="menu" href="/admin/ads">
		<img src="/img/member_my_org.png" />
		<div class="menu_text">Ads</div>
	</a>
	<a class="menu" href="/admin/snip">
		<img src="/img/snip-adm.png" width="100" height="90" />
		<div class="menu_text">ADV SNIP</div>
	</a>
</div>
@endif