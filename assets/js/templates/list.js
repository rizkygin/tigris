'use strict';
let ajaxProc= false;
let table = $('#list-ajax');

$(document).ready(function(){
    table.find('thead').after(`<tbody></tbody>`);
    table.addClass('table-sm');

});

$(function(){
    table.find('tbody').ready(function(){
        list();
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
list();
});

function list(params){
    params = params || {};
    let table = $('#list-ajax'); //kalo pakai variabel 'table' yang atas, pas update jadi blank;
    if(ajaxProc) return;
    ajaxProc = true;

    let page = params.page || 1;
    let q = $('input[name=q]').val();
    let listUrl = table.data('list');
    let param1 = table.data('param1');
    let useAttr = table.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table.data('attr-set');
    // let attr = table.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
        url: table.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
        method: "GET",
        dataType: "JSON",
        data: req,
        beforeSend: function(){
            table.find('tbody').children().remove();
            $('.loading-table').removeClass('hide');
        },
        success: function(res){
            let koloms;
            $('.loading-table').addClass('hide');
            table.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                if(typeof res.koloms !== 'undefined') koloms = res.koloms;
                else koloms  = table.data('kolom');
                // console.log(table.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol) {
                        	// console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`">`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // attribut
                        let kolomAttr = null;
                        $.map(thAttr, function(th, ith) {
                            // return something;
                            kolomAttr += `<td id="attr-data-`+$(th).data('attr-set')+`-`+$(th).data('attr')+`-`+item.id+`"></td>`;
                        });
                        // ./attribut

                        // update & delete
                        
                        if(item.param){
                        	let encode_par = item.param;
                        	rd = `<td style="white-space:nowrap;" class="no-print">
                            <a href="`+table.data('url')+`/form/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="`+table.data('url')+`/remove/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>`;
                        }
                        

                        table.find('tbody').append(`
                            <tr>
                            <td>`+no+`</td>
                            `+kolom+`
                            `+kolomAttr+`
                            `+rd+`
                            </tr>
                            `);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        
                    });

                if(useAttr) getAttrValues(dataIds, attrCode);
                let params = {
                    func:'list',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('#box-data'),
                    param:{
                                // id:idItems
                                addParam: addParam
                            },

                        }

                        let pag = new Paginate(params);
                        pag.init();
                    // let pag = new Pagination('list', total, limit, page);
				    // pag.init();

                }else if(res.status=='failed'){
                    table.find('tbody').children().remove();
                }
                ajaxProc = false;
            }
        });

    $(function(){
       $('input[name=q]').unbind('keyup').on('keyup', function(){
        list({addParam: addParam});
    });
   })
}


function getAttrValues(ids, code){
    // console.log(ids);
    $.ajax({
        url: $('input[name=site_url]').val()+'ajax/request/attr_values',
        type: 'GET',
        dataType: 'json',
        data: {data_ids: ids, code:code},
    })
    .done(function(res) {
        // console.log(res);
        if(res.status == 'success'){
            const{result} = res;
            // let tdHtml = '';
            $.map(result, function(item, index) {
                $('#attr-data-'+item.id_attr_set+'-'+item.id_attr+'-'+item.id_data).html( item.longval ? '<a title="klik untuk detail..." data-act="detail-kolom" data-toggle="modal" data-target="#modal-message" class="use-tooltip">'+item.longval+'...<textarea class="full-html" style="display:none;">'+item.values+'</textarea></a>' : item.values );
            });

        }
    });
    
}

