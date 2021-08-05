$(document).ready(function() {
	global_select('id_provinsi');
	global_select('id_kabupaten', [{key:'province_id',val:'id_provinsi'}]);
	global_select('id_kecamatan', [{key:'city_id',val:'id_kabupaten'}]);
});