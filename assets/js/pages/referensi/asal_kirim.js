$(document).ready(function() {
	global_select('province_id');
	global_select('city_id', [{key:'province_id', val:'province_id'}]);
	global_select('subdistrict_id', [{key:'city_id', val:'city_id'}]);
});