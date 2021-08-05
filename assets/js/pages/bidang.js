'use strict';
var ajaxProc= false;
var table = $('#tab_user');
$(document).ready(function(){
    table.find('thead').after(`<tbody></tbody>`);

});

$(function(){
    table.find('tbody').ready(function(){
        list();

        $('input[name=q]').on('keyup', function(){
            console.log($(this).val())
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
// reload table:
list(1);
});

function list(params){
    params = params || {};
    let page = params.page || 1;
    if(ajaxProc) return;
    ajaxProc = true;

    page = page || 1;
    let q = $('input[name=q]').val();
    var table = $('#tab_user');
    $.ajax({
        url: table.data('url')+'/listdata',
        method: "GET",
        dataType: "JSON",
        data: {page:page,q:q, id_unit: table.data('param')},
        beforeSend: function(){
            table.find('tbody').children().remove();
            $('.loading-table').removeClass('d-none');
        },
        success: function(res){
            $('.loading-table').addClass('d-none');
            table.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id_unit':table.data('param'),
                            'id':item.id
                        };
                        let encode_par = item.param;
                        table.find('tbody').append(`
                            <tr id="`+item.id+`" class="data">
                            <td class="number">`+no+`</td>
                            <td class="data" colspan="20">`+item.bidang+`</td>
                            <td style="white-space:nowrap;">
                            <a href="`+table.data('url')+`/form/`+encode_par+`" class="btn btn-xs btn-warning">ubah</a>
                            <a href="`+table.data('url')+`/remove/`+encode_par+`" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-message" data-act="hapus" data-func="hapus">hapus</a>
                            </td>
                            </tr>
                            `);
                        if(item.child) sub(item.id);
                        
                        no++;
                    });

                let params = {
                    func:'list',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('#box-data'),
                    param:{
                                // id:idItems
                            }
                        }

                        let pag = new Paginate(params);
                        pag.init();

                    }else if(res.status=='failed'){
                        table.find('tbody').children().remove();
                    }
                    ajaxProc = false;
                }
            });
}

function sub(parent,level,colspan, after, page){
    page = page || 1;
    after = after || parent;
    level = level || 1;
    colspan = colspan || 19;
    var table = $('#tab_user');
    var xHR = $.ajax({
        url: table.data('url')+'/sub',
        method: "GET",
        dataType: "JSON",
        data: {parent : parent, page:page, id_unit : table.data('param')},
        async: false
    })

    const {status} = xHR.responseJSON;
    if(status == 'success'){
        const {results, more, total, offset} = xHR.responseJSON;
        var no=1+offset;
        // adding td
        let tds = null;
        for (var i = 0; i < level; i++) {
            tds += '<td></td>';
        }
        // ,.adding td
        
        $.map(results, function(item, index) {
            // return something;
            let par_aksi = {
                'id_unit':table.data('param'),
                'id':item.id
            };
            let encode_par = item.param;
            // if(item.child) colspan = colspan - 1;

            $(`<tr id="`+item.id+`" class="page-`+page+`">
                `+tds+`
                <td class="number">`+no+`</td>
                <td class="data" colspan="`+colspan+`">`+item.bidang+`</td>
                <td style="white-space:nowrap;">
                <a href="`+table.data('url')+`/form/`+encode_par+`" class="btn btn-xs btn-warning">ubah</a>
                <a href="`+table.data('url')+`/remove/`+encode_par+`" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-message" data-act="hapus" data-func="hapus">hapus</a>
                </td>
                </tr>`).insertAfter('#'+after);
            no++;
            if(more) sub(parent, level,colspan, item.id, page+1);

            if(item.child) sub(item.id,level+1, colspan-1);
        });
    }
    console.log(status);
    
}

