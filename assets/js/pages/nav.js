'use strict';
var ajaxProc= false;
var container = $('#nav');

$(function(){
    container.find('ul').ready(function(){
        list();

        $('input[name=q]').on('keyup', function(){
            console.log($(this).val())
            $('#nav').children().remove();
            list();
        });

        $('.btn-print').on('click', function(){
            printReport('cetak-area');
            return false;
        });
    });
   
});


// reload
$(document).on('hover', '[data-click=panel-reload]', function(e) {
    if (!$(this).attr('data-init')) {
        $(this).tooltip({
            title: 'Reload',
            placement: 'bottom',
            trigger: 'hover',
            container: 'body'
        });
        $(this).tooltip('show');
        $(this).attr('data-init', true);
    }
});
$(document).on('click', '[data-click=panel-reload]', function(e) {
    e.preventDefault();
    var target = $(this).closest('.panel');
    if (!$(target).hasClass('panel-loading')) {
        var targetBody = $(target).find('.panel-body');
        var spinnerHtml = '<div class="panel-loader"><span class="spinner-small"></span></div>';
        $(target).addClass('panel-loading');
        $(targetBody).prepend(spinnerHtml);
        setTimeout(function() {
            $(target).removeClass('panel-loading');
            $(target).find('.panel-loader').remove();
        }, 1000);

    }
// reload container:
    list();
});

function list(id_nav){
    // if(ajaxProc) return;
    // ajaxProc = true;

    id_nav = id_nav || 0;
    let q = $('input[name=q]').val();
    var container = $('#nav');
    var store=[];

    $.ajax({
            url: $('input[name=site_url]').val()+'inti/nav/listdata',
            method: "GET",
            dataType: "JSON",
            data: {id_nav:id_nav,q:q, id_aplikasi: container.data('param')},
            beforeSend: function(){
                // container.find('ul').children().remove();
                $('.loading-container').removeClass('d-none');
            },
            success: function(res){
                $('.loading-container').addClass('d-none');
                // container.find('tbody').children().remove();
                if(res.status=='success'){
                    const {result} = res;
                    let no=1;
                    $.each(result,function(idx, item){

                        // console.log(item);
                        let par_aksi = {
                            'id_aplikasi':container.data('param'),
                            'id':item.id
                        };


                        let par_urut_naik = {
                            'id_aplikasi' : container.data('param'),
                            'id_nav' : item.id_nav,
                            'id_par_nav' : item.id_par_nav,
                            'urut' : item.urut,
                            'tipe' : 'naik',
                        }
                        // par_urut_naik = setEncode(par_urut_naik);
                        par_urut_naik = item.par_urut_naik;

                        let par_urut_turun = {
                            'id_aplikasi' : container.data('param'),
                            'id_nav' : item.id_nav,
                            'id_par_nav' : item.id_par_nav,
                            'urut' : item.urut,
                            'tipe' : 'turun',
                        }
                        // par_urut_turun = setEncode(par_urut_turun);
                        par_urut_turun = item.par_urut_turun;

                        // let encode_par = setEncode(par_aksi);
                        let encode_par = item.param;
                        if(id_nav == 0){ 
                        	container.append(`
	                            <li style="list-style-type:none;" id="nav-`+item.id_nav+`" class="`+item.margin+` mt-3">
	                            `+no+`. <b>`+item.judul+`</b>
	                            <a href="`+$('input[name=site_url]').val()+`inti/nav/form/`+encode_par+`" class="btn btn-xs btn-default">ubah</a>
	                            <a href="`+$('input[name=site_url]').val()+`inti/nav/remove/`+encode_par+`" class="btn btn-xs btn-default" data-toggle="modal" data-target="#modal-message" data-act="hapus" data-func="hapus">hapus</a>
                                <a href="`+$('input[name=site_url]').val()+`inti/nav/urutkan/`+par_urut_turun+`" class="btn btn-xs btn-default"><i class="fas fa-angle-down"></i></a>
                                <a href="`+$('input[name=site_url]').val()+`inti/nav/urutkan/`+par_urut_naik+`" class="btn btn-xs btn-default"><i class="fas fa-angle-up"></i></a>
	                            </li>
	                        `);
                        }else{
                        	if(idx == 0){
                        		$(`<li style="list-style-type:none;" id="nav-`+item.id_nav+`" class="`+item.margin+` mt-3">
	                        		`+no+`. <b>`+item.judul+`</b>
	                        		<a href="`+$('input[name=site_url]').val()+`inti/nav/form/`+encode_par+`" class="btn btn-xs btn-default">ubah</a>
		                            <a href="`+$('input[name=site_url]').val()+`inti/nav/remove/`+encode_par+`" class="btn btn-xs btn-default" data-toggle="modal" data-target="#modal-message" data-act="hapus" data-func="hapus">hapus</a>
	                        		</li>`).insertAfter('#nav-'+item.id_par_nav);
                        	}else{
                        		$(`<li style="list-style-type:none;" id="nav-`+item.id_nav+`" class="`+item.margin+` mt-3">
	                        		`+no+`. <b>`+item.judul+`</b>
	                        		<a href="`+$('input[name=site_url]').val()+`inti/nav/form/`+encode_par+`" class="btn btn-xs btn-default">ubah</a>
		                            <a href="`+$('input[name=site_url]').val()+`inti/nav/remove/`+encode_par+`" class="btn btn-xs btn-default" data-toggle="modal" data-target="#modal-message" data-act="hapus" data-func="hapus">hapus</a>
	                        		</li>`).insertAfter('#nav-'+result[idx - 1].id_nav);
                        	}
                        	
                        }
                        
                        ++no;

                        list(item.id_nav);
                    });

                    // let pag = new Pagination('list', total, limit, id_nav);
				    // pag.init();

                }else if(res.status=='failed'){
                    // container.find('ul').children().remove();
                }
                // ajaxProc = false;
            }
        });
}

