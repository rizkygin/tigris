'use strict';
let ajaxAkun= false;
let ajaxProvinces= false;
let ajaxCity= false;
let ajaxKecamatan= false;

let table_akun = $('#tab_akun');
let table_provinces = $('#tab_provinsi');
let table_city = $('#tab_kabupaten');
let table_kec = $('#tab_kecamatan');

$(document).ready(function(){
    table_akun.find('thead').after(`<tbody></tbody>`);
    table_akun.addClass('table-sm');

    table_provinces.find('thead').after(`<tbody></tbody>`);
    table_provinces.addClass('table-sm');

    table_city.find('thead').after(`<tbody></tbody>`);
    table_city.addClass('table-sm');

    table_kec.find('thead').after(`<tbody></tbody>`);
    table_kec.addClass('table-sm');

    $(function(){
    // table_akun.find('tbody').ready(function(){
        list_akun();
        list_provinces();
        list_city();
        list_kecamatan();
        $('.btn-print').on('click', function(){
            printReport('cetak-area');
            return false;
        });
    // });

    });

});




function list_akun(params){
    params = params || {};
    let table_akun = $('#tab_akun'); //kalo pakai variabel 'table_akun' yang atas, pas update jadi blank;
    if(ajaxAkun) return;
    ajaxAkun = true;
    let page = params.page || 1;
    let q = $('input[name=q]').val();
    let listUrl = table_akun.data('list');
    let param1 = table_akun.data('param1');
    let useAttr = table_akun.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table_akun.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table_akun.data('attr-set');
    // let attr = table_akun.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
        url: table_akun.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
        method: "GET",
        dataType: "JSON",
        data: req,
        beforeSend: function(){
            table_akun.find('tbody').children().remove();
            $('.loading-table_akun').removeClass('hide');
        },
        success: function(res){
            let koloms;
            $('.loading-table_akun').addClass('hide');
            table_akun.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                if(typeof res.koloms !== 'undefined') koloms = res.koloms;
                else koloms  = table_akun.data('kolom');
                // console.log(table_akun.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table_akun.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol) {
                            console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`" `+(kol.colspan ? `colspan="`+kol.colspan+`"`: ``)+`>`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // update & delete
                        
                        if(item.param){
                            let encode_par = item.param;
                            rd = `<td style="white-space:nowrap;" class="no-print">
                            <a href="`+table_akun.data('url')+`/sync_akun/`+encode_par+`" class="btn btn-xs btn-success"><i class="fa fa-sync"></i> Sinkron</a>
                            <a href="`+table_akun.data('url')+`/form_akun/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="`+table_akun.data('url')+`/remove_akun/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>`;
                        }
                        

                        table_akun.find('tbody').append(`
                            <tr>
                            <td>`+no+`</td>
                            `+kolom+`
                            `+rd+`
                            </tr>
                            `);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        
                    });

                let params = {
                    func:'list_akun',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('.ro-akun'),
                    param:{
                                addParam: addParam
                            },

                        }

                        let pag = new Paginate(params);
                        pag.init();
                    // let pag = new Pagination('list', total, limit, page);
                    // pag.init();

                }else if(res.status=='failed'){
                    table_akun.find('tbody').children().remove();
                }
                ajaxAkun = false;
            }
        });

    $(function(){
       $('input[name=q]').unbind('keyup').on('keyup', function(){
        list({addParam: addParam});
    });

   })
}

function list_provinces(params){
    params = params || {};
    let table_provinces = $('#tab_provinsi'); //kalo pakai variabel 'table_provinces' yang atas, pas update jadi blank;
    if(ajaxProvinces) return;
    ajaxProvinces = true;
    let page = params.page || 1;
    let q = $('input[name=q_provinsi]').val();
    let listUrl = table_provinces.data('list');
    let param1 = table_provinces.data('param1');
    let useAttr = table_provinces.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table_provinces.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table_provinces.data('attr-set');
    // let attr = table_provinces.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
        url: table_provinces.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
        method: "GET",
        dataType: "JSON",
        data: req,
        beforeSend: function(){
            table_provinces.find('tbody').children().remove();
            $('.loading-table_provinces').removeClass('hide');
        },
        success: function(res){
            let koloms;
            $('.loading-table_provinces').addClass('hide');
            table_provinces.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                if(typeof res.koloms !== 'undefined') koloms = res.koloms;
                else koloms  = table_provinces.data('kolom');
                // console.log(table_provinces.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table_provinces.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol) {
                            console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`" `+(kol.colspan ? `colspan="`+kol.colspan+`"`: ``)+`>`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // update & delete
                        
                        if(item.param){
                            let encode_par = item.param;
                            rd = `<td style="white-space:nowrap;" class="no-print">
                            <a href="`+table_provinces.data('url')+`/sync_akun/`+encode_par+`" class="btn btn-xs btn-success"><i class="fa fa-sync"></i> Sinkron</a>
                            <a href="`+table_provinces.data('url')+`/form_akun/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="`+table_provinces.data('url')+`/remove_akun/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>`;
                        }
                        

                        table_provinces.find('tbody').append(`
                            <tr>
                            <td>`+no+`</td>
                            `+kolom+`
                            `+rd+`
                            </tr>
                            `);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        
                    });

                let params = {
                    func:'list_provinces',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('.ro-provinsi'),
                    param:{
                                addParam: addParam
                            },

                        }

                        let pag = new Paginate(params);
                        pag.init();
                    // let pag = new Pagination('list', total, limit, page);
                    // pag.init();

                }else if(res.status=='failed'){
                    table_provinces.find('tbody').children().remove();
                }
                ajaxProvinces = false;
            }
        });

    $(function(){
       $('input[name=q_provinsi]').unbind('keyup').on('keyup', function(){
        list_provinces({addParam: addParam});
    });

   })
}
function list_city(params){
    params = params || {};
    let table_city = $('#tab_kabupaten'); //kalo pakai variabel 'table_city' yang atas, pas update jadi blank;
    if(ajaxCity) return;
    ajaxCity = true;
    let page = params.page || 1;
    let q = $('input[name=q_kabupaten]').val();
    let listUrl = table_city.data('list');
    let param1 = table_city.data('param1');
    let useAttr = table_city.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table_city.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table_city.data('attr-set');
    // let attr = table_city.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
        url: table_city.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
        method: "GET",
        dataType: "JSON",
        data: req,
        beforeSend: function(){
            table_city.find('tbody').children().remove();
            $('.loading-table_city').removeClass('hide');
        },
        success: function(res){
            let koloms;
            $('.loading-table_city').addClass('hide');
            table_city.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                if(typeof res.koloms !== 'undefined') koloms = res.koloms;
                else koloms  = table_city.data('kolom');
                // console.log(table_city.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table_city.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol) {
                            console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`" `+(kol.colspan ? `colspan="`+kol.colspan+`"`: ``)+`>`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // update & delete
                        
                        if(item.param){
                            let encode_par = item.param;
                            rd = `<td style="white-space:nowrap;" class="no-print">
                            <a href="`+table_city.data('url')+`/sync_akun/`+encode_par+`" class="btn btn-xs btn-success"><i class="fa fa-sync"></i> Sinkron</a>
                            <a href="`+table_city.data('url')+`/form_akun/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="`+table_city.data('url')+`/remove_akun/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>`;
                        }
                        

                        table_city.find('tbody').append(`
                            <tr>
                            <td>`+no+`</td>
                            `+kolom+`
                            `+rd+`
                            </tr>
                            `);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        
                    });

                let params = {
                    func:'list_city',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('.ro-kabupaten'),
                    param:{
                                addParam: addParam
                            },

                        }

                        let pag = new Paginate(params);
                        pag.init();
                    // let pag = new Pagination('list', total, limit, page);
                    // pag.init();

                }else if(res.status=='failed'){
                    table_city.find('tbody').children().remove();
                }
                ajaxCity = false;
            }
        });

    $(function(){
       $('input[name=q_kabupaten]').unbind('keyup').on('keyup', function(){
        list_city({addParam: addParam});
    });

   })
}

function list_kecamatan(params){
    params = params || {};
    let table_kec = $('#tab_kecamatan'); //kalo pakai variabel 'table_kec' yang atas, pas update jadi blank;
    if(ajaxKecamatan) return;
    ajaxKecamatan = true;
    let page = params.page || 1;
    let q = $('input[name=q_kecamatan]').val();
    let listUrl = table_kec.data('list');
    let param1 = table_kec.data('param1');
    let useAttr = table_kec.data('useattr');
    let addParam = params.addParam || null;

    // getdata attr and store to addParam:
    let dataSetting = table_kec.data();

    let req = {page:page,q:q, param1:param1, add_param: addParam, data_setting: dataSetting};
    // let attrSet = table_kec.data('attr-set');
    // let attr = table_kec.data('attr-set');
    let thAttr = $('.th-attr');
    $.ajax({
        url: table_kec.data('url')+'/'+ (listUrl != undefined ? listUrl : 'listdata'),
        method: "GET",
        dataType: "JSON",
        data: req,
        beforeSend: function(){
            table_kec.find('tbody').children().remove();
            $('.loading-table_kec').removeClass('hide');
        },
        success: function(res){
            let koloms;
            $('.loading-table_kec').addClass('hide');
            table_kec.find('tbody').children().remove();
            if(res.status=='success'){
                const {result,offset,total,limit} = res;
                let {page} = res; 
                let no=1+offset;
                if(typeof res.koloms !== 'undefined') koloms = res.koloms;
                else koloms  = table_kec.data('kolom');
                // console.log(table_kec.data('kolom'));
                // console.log(koloms);
                var rd;
                let dataIds = [], attrCode = table_kec.data('attrcode');

                $.each(result,function(idx, item){
                        // console.log(item);
                        let par_aksi = {
                            'id':item.id
                        };
                        let kolom =null;

                        $.map(koloms, function(kol) {
                            console.log(kol) ;
                            // console.log(typeof kol);
                            if(typeof kol == 'object') kolom +=`<td class="data-`+item.id+` data-kolom `+(kol.class ? kol.class : '')+`" `+(kol.colspan ? `colspan="`+kol.colspan+`"`: ``)+`>`+item[kol.field]+`</td>`;
                            else kolom +=`<td class="data-`+item.id+` data-kolom">`+item[kol]+`</td>`;
                        });

                        // update & delete
                        
                        if(item.param){
                            let encode_par = item.param;
                            rd = `<td style="white-space:nowrap;" class="no-print">
                            <a href="`+table_kec.data('url')+`/sync_akun/`+encode_par+`" class="btn btn-xs btn-success"><i class="fa fa-sync"></i> Sinkron</a>
                            <a href="`+table_kec.data('url')+`/form_akun/`+encode_par+`" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            <a href="`+table_kec.data('url')+`/remove_akun/`+encode_par+`" data-act="hapus" class="btn btn-xs btn-danger" data-target="#modal-message" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>`;
                        }
                        

                        table_kec.find('tbody').append(`
                            <tr>
                            <td>`+no+`</td>
                            `+kolom+`
                            `+rd+`
                            </tr>
                            `);
                        no++;

                        if(useAttr) dataIds.push(item.id);
                        
                    });

                let params = {
                    func:'list_kecamatan',
                    total:total,
                    limit:limit,
                    curr:page,
                    komp:$('.ro-kecamatan'),
                    param:{
                                addParam: addParam
                            },

                        }

                        let pag = new Paginate(params);
                        pag.init();
                    // let pag = new Pagination('list', total, limit, page);
                    // pag.init();

                }else if(res.status=='failed'){
                    table_kec.find('tbody').children().remove();
                }
                ajaxKecamatan = false;
            }
        });

    $(function(){
       $('input[name=q_kecamatan]').unbind('keyup').on('keyup', function(){
        list_kecamatan({addParam: addParam});
    });

   })
}

