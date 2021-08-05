$(document).ready(function() {
	
	$('.btn-tolak').click(function() {	   
	   $('.form-delete-msg').html('Anda akan menolak data tersebut !!');
	   $('.form-title').html('<i class="fa fa-ban"></i> Tolak');
	   $('.form-delete-url').attr('href',$(this).attr('href')).children().html('<i class="fa fa-ban"></i> Ok');
	   $('#modal-delete').modal('show');
	   return false;
   });
	
	$('.btn-edit, .btn-form').click(function() {
			$('#box-main').hide();
			
			act = $(this).attr('act');
			
		    $.ajax({
			  	url: (act)?act:$(this).attr('href'),
				beforeSend: function() { 
					$('#form-overlay').show(); 
					$(this).attr('disabled','disabled');
				},
			  	success: function(cont) {
			  		$('#form-overlay').hide();
					$(this).removeAttr('disabled');
			  		$('#form-content').html(cont);
			  		$('#form-box').slideDown();
				},error:function(){
					show_error('Sistem bermasalah. Hubungi Developer');
				}
		   });
		   return false;
	   });

		$('.btn-stop').click(function() {
		   $('.form-delete-msg').html('Apakah anda ingin mengakhiri ?');
		   $('.form-title').html('<i class="fa fa-check-square-o"></i> Mengakhiri');
		   $('.form-delete-url').attr('href',$(this).attr('href')).children().html('<i class="fa fa-check-square-o"></i> OK');
		   $('#modal-delete').modal('show');
		   return false;
	   	});
	   
	   $('.btn-delete').click(function() {
		   var ac = $(this).attr('act');
		   var msg = $(this).attr('msg');
		   var icn = $(this).attr('t_icn');
		   var tl = $(this).attr('t_text');
		   $('.form-title').html('<i class="fa '+(icn?icn:'fa-trash')+' fa-btn"></i> '+(tl?tl:'Konfirmasi Hapus'));
		   var btn_del = '<i class="fa '+(icn?icn:'fa-trash')+' fa-btn"></i> '+(tl?tl:'Hapus');
		   $('.form-delete-msg').html(msg);
		   if (ac) $('.form-delete-url').attr('href',$(this).attr('act')).children().html(btn_del).show();
		   else $('.form-delete-url').attr('href',$(this).attr('href')).children().html(btn_del).show();
		   $('#modal-delete').modal('show');
		   return false;
	   });

	   $('.btn-back').click(function() {
		   var ac = $(this).attr('act');
		   var msg = $(this).attr('msg');
		   var icn = $(this).attr('t_icn');
		   var tl = $(this).attr('t_text');
		   $('.form-title').html('<i class="fa '+(icn?icn:'fa-check-square-o')+' fa-btn"></i> '+(tl?tl:'Konfirmasi'));
		   var btn_del = '<i class="fa '+(icn?icn:'fa-check-square-o')+' fa-btn"></i> '+(tl?tl:'Ok');
		   $('.form-delete-msg').html(msg);
		   if (ac) $('.form-delete-url').attr('href',$(this).attr('act')).children().html(btn_del).show();
		   else $('.form-delete-url').attr('href',$(this).attr('href')).children().html(btn_del).show();
		   $('#modal-delete').modal('show');
		   return false;
	   });
	   
	   $('.btn-off').click(function() {
		   
		   $('.form-delete-msg').html('Apakah anda ingin mengakhiri pemakaian aplikasi?');
		   $('.form-title').html('<i class="fa fa-power-off fa-btn"></i> Logout');
		   $('.form-delete-url').attr('href',$(this).attr('href')).children().html('<i class="fa fa-power-off"></i> &nbsp; Logout').show();
		   $('#modal-delete').modal('show');
		   return false;
	   });

	   $('.btn-check').click(function() {
		   var msg = $(this).attr('msg');
		   $('.form-delete-msg').html(msg);
		   $('.form-title').html('<i class="fa fa-check-square-o"></i> &nbsp; Konfirmasi');
		   $('.form-delete-url').attr('href',$(this).attr('act')).children().html('<i class="fa fa-check-square-o"></i>  &nbsp;  Ya').show();
		   $('#modal-delete').modal('show');
		   return false;
	   });
	   
	   $('.btn-profil').click(function() {
		    $.ajax({
		      url: $(this).attr('href'),
		      cache: false,
		      success: function(msg) {
		         $('#modal-profil').html(msg);
				 $('#load-profil').hide();
				
		      },error:function(error){
				$('#load-profil').html('<i class="fa fa-error"></i> ERROR : '+error).show();
				}
		   });
		    $('#modal-profil').modal('show');
		    return false;
	   });
	   
		$('.cek-all').click(function() {
			if ($(this).is(':checked')) {
				$('.cek').prop('checked', true);
				$('.btn-delete-all').show();
			} else {
				$('.cek').prop('checked', false);
				$('.btn-delete-all').hide();
			} 
		});
		
		$('.cek').click(function(){
			var ju = 0;
			$('.cek').each(function() { if($(this).is(':checked')) ju+=1; });
			
			if (ju > 0) $('.btn-delete-all').show();             
			else $('.btn-delete-all').hide();
		});
		
		$('.btn-delete-all').click(function() {
			
			$('.form-delete-msg').html('Apakah ingin menghapus item yang tercentang?<br>Aksi ini tak dapat dibatalkan!');
			$('.form-delete-url').hide();
			$('.form-delete-btn').show();
			$('#modal-delete').modal('show');
			return false;
			
		});
		
		$('.form-delete-btn').click(function() {
			
			$('#form_delete').submit();
			
		});
	   
	
});

function show_error(e) {
	$(document).ready(function() {
		$('.alert-dialog').removeClass('alert-success');
		$('.alert-dialog').addClass('alert-danger');
		$('.alert-icon').html('<i class="icon fa fa-ban"></i> Kesalahan!');
		$('.alert-message').html(e);
		$('#modal-alert-btn').removeClass('btn-success').addClass('btn-danger');
		$('#modal-alert').modal('show');
		
	});
}

function show_message(e) {
	$(document).ready(function() {
		
		$('.alert-dialog').removeClass('alert-danger');
		$('.alert-dialog').addClass('alert-success');
		$('.alert-icon').html('<i class="icon fa fa-check"></i> Pesan');
		$('.alert-message').html(e);
		$('#modal-alert-btn').removeClass('btn-danger').addClass('btn-success');
		$('#modal-alert').modal('show');
		
	});
}


function setExpiration(cookieLife){
    var today = new Date();
    var expr = new Date(today.getTime() + cookieLife * 24 * 60 * 60 * 1000);
    return  expr.toGMTString();
}

function numberToCurrency(a){
	if (parseInt(a) < 0) d = 1;
	else d = 0;
	if(a!=''&&a!=null){
		a=a.toString();       
        var b = '';
		if (a == '-') b = a.replace(/[^\d\,\-]/g,'');
		else b = a.replace(/[^\d\,]/g,'');
		var dump = b.split(',');
        var c = '';
        var lengthchar = dump[0].length;
        var j = 0
        for (var i = lengthchar; i > 0; i--) {
			
				j = j + 1;
				if (((j % 3) == 1) && (j != 1)) c = dump[0].substr(i-1,1) + '.'+ c;
				else c = dump[0].substr(i-1,1) + c;
        }
		
		if(dump.length>1){
			if(dump[1].length>0){
				c += ','+dump[1];
			}else{
				c += ',';
			}
		}
	
		if (d == 1) return '-' + c;
		else return c;
	} else {
        return '';
    }
}


function formatNumber(obj) {
	var a = obj.value;
	obj.value = numberToCurrency(a);
}

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}

/* -- Cookies -- */


function getCookie(w){
	cName = "";
	pCOOKIES = new Array();
	pCOOKIES = document.cookie.split('; ');
	for(bb = 0; bb < pCOOKIES.length; bb++){
		NmeVal  = new Array();
		NmeVal  = pCOOKIES[bb].split('=');
		if(NmeVal[0] == w){
			cName = unescape(NmeVal[1]);
		}
	}
	return cName;
}

function printCookies(w){
	cStr = "";
	pCOOKIES = new Array();
	pCOOKIES = document.cookie.split('; ');
	for(bb = 0; bb < pCOOKIES.length; bb++){
		NmeVal  = new Array();
		NmeVal  = pCOOKIES[bb].split('=');
		if(NmeVal[0]){
			cStr += NmeVal[0] + '=' + unescape(NmeVal[1]) + '; ';
		}
	}
	return cStr;
}

function setCookie(name, value, expires, path, domain, secure){
	cookieStr = name + "=" + escape(value) + "; ";
	
	if(expires){
		expires = setExpiration(expires);
		cookieStr += "expires=" + expires + "; ";
	}
	if(path){
		cookieStr += "path=" + path + "; ";
	}
	if(domain){
		cookieStr += "domain=" + domain + "; ";
	}
	if(secure){
		cookieStr += "secure; ";
	}
	
	document.cookie = cookieStr;
}

function setExpiration(cookieLife){
    var today = new Date();
    var expr = new Date(today.getTime() + cookieLife * 24 * 60 * 60 * 1000);
    return  expr.toGMTString();
}
 

function contentloader(urldesire,contentbox, target=''){
   $.ajax({
      url: urldesire,
      cache: false,
      success: function(msg) {
         $(contentbox).html(msg);
         $(target).select2();
      },error:function(error){
		show_error(error);
	}
   });
}
function contentjson(urldesire,contentbox, attr){
   $.ajax({
      url: urldesire,
      dataType: 'JSON',
      cache: false,
      success: function(msg) {
         $(contentbox).attr(attr, msg);
      },error:function(error){
		show_error(error);
	}
   });
}

function din_combo(url, to){
     $.ajax({
        url:url,
        success:function(data){
            $('#' + to).empty('');
            $.each(JSON.parse(data), function(key, val){
                $('#' + to).append('<option value="' + val.key + '">' + val.val + '</option>');
             //   alert(val.key+val.val);
            });
        },
        error:function(){
            alert('sistem bermasalah..');
        }
    });
}



// tinymce:
function initMce(par={}){
	// console.log(par.menu);
	tinymce.init({
		relative_urls: false,
		selector: '.textarea',
		// skin: 'oxide',
        // content_css: 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.1.2/skins/content/writer/content.min.css',
        content_css: 'writer',
        height: par.height || 450,
        plugins: par.plugins || [
        'noneditable advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table directionality emoticons template paste',
        'noneditable lorumipsum responsivefilemanager',
        ],

        contextmenu: par.contextmenu || "link inserttable | cell row column deletetable",
        // content_css: '../../../assets/plugins/tinymce/js/tinymce/skins/content/writer/content.min.css',
        toolbar: par.toolbar || 'responsivefilemanager link image insertfile media undo redo lorumipsum | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
        // menubar: par.menubar || "file edit insert view format table tools help",
        menubar: par.menu || "table tools view",
        // menubar: "table tools view",
        // menubar:false,
		statusbar: false,
		// filemanager:
		external_filemanager_path:"/malcom/filemanager/",
	    filemanager_title:"Upload dokumen atau file" ,
	    // external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"},
	    external_plugins: {
			"responsivefilemanager": "plugins/responsivefilemanager/plugin.min.js",
			"filemanager": "/malcom/filemanager/plugin.min.js"
		},
        force_p_newlines : false,
        force_br_newlines : true,
        convert_newlines_to_brs : false,
        remove_linebreaks : true,
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
		/*
	    file_picker_types: 'image',
	    file_picker_callback: function (cb, value, meta) {
		    	var input = document.createElement('input');
		    	input.setAttribute('type', 'file');
		    	input.setAttribute('accept', 'image/*');
		      input.onchange = function () {
		      	var file = this.files[0];

		      	var reader = new FileReader();
		      	reader.onload = function () {
		          var id = 'blobid' + (new Date()).getTime();
		          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
		          var base64 = reader.result.split(',')[1];
		          var blobInfo = blobCache.create(id, file, base64);
		          blobCache.add(blobInfo);
		          cb(blobInfo.blobUri(), { title: file.name });
		      };
		      reader.readAsDataURL(file);
		  };

		  input.click();
		},
		// paste_data_images: false,
		*/

});
}