
// report

$(function(){
	$('.btn-print').unbind('click', function(e){
		e.preventDefault();
		printReport('cetak-area');
	});
})

function printReport(divID) {
	var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
	disp_setting+="scrollbars=yes,width=1024, height=550, left=50, top=25"; 
	var contet_disp = `<style type="text/css">
	@media print {
		nav, .btn, .no-print {
			display: none;
		}
	}
	table {
		width: 100% !important;
		border-collapse: collapse;
		margin-bottom: 5px;
	}

	table, th, td {
		border: 1px solid black;
	}

	.printhead-instansi {
		flex-direction: column;
		align-content: center;
		flex-wrap: wrap;
	}
	.printhead-instansi > p {
		text-align:center;
		font-size:18pt;
		font-weight: bold;
	}
	.printhead-instansi > hr {
		border-top: 3px solid;
		margin-bottom:25px !important;
	}

	</style>`;

	contet_disp += $('.print-head').html();
	contet_disp += document.getElementById(divID).innerHTML;

	var w = window.open("","", disp_setting);

		w.document.write(contet_disp); //only part of the page to print, using jquery
		w.document.close(); //this seems to be the thing doing the trick
		w.focus();
		w.print();
		w.close();
	}
// ./report





// select2 combo

// param:
// kelas: 'sample'
// additionalParam: [{key:'id_sample', val:'id_sample'}]
// onSel: nama Fungsi
// incVal: include value of this select (true, false)
function global_select(kelas, additionalParam={}, onSel=null,incVal=false){
		// console.log(kelas);
		// console.log($('.'+kelas));
		$("."+kelas).select2({
		  ajax: {
		    url: $('.'+kelas).data('url'),
		    dataType: "JSON",
		    // delay: 250,
		    beforeSend:function(){
		    	// console.log($('.select-kunkom').data('url'));
		    },
	        data: function(params) {
	        	var defaultParam = {
	        		combo: true,
	        		term: params.term || '',
	        		page: params.page || 1,
	        	};

	        	let returnParam = defaultParam;
	        	// console.log(additionalParam.length);

	        	if(additionalParam.length > 0){ //[{key:, val:}]
	        		var rObj = [];
	        		additionalParam.forEach(function(item){
	        			rObj[item.key] = $('#'+item.val) != undefined ? $('#'+item.val).val() : $('.'+item.val).val();
	        		});
					returnParam = Object.assign(defaultParam, rObj);
					// console.log(returnParam);
				}

				// console.log(returnParam);
				return returnParam;
	            // return {
	            //     term: params.term || '',
	            //     page: params.page || 1,
	            // }
	        },
		    processResults: function (data, params) {
		    	let {page} = params;
		    	let {limit,results, pagination} = data;
			    page = page || 1;
			    // console.log(data.count);
			    var mapdata = $.map(results, function (obj) {      
				    obj.id = obj.id;
				    obj.text = obj.text;
				    return obj;
				  });
			    // console.log(pagination)

			    return {
			        results: mapdata,
			        pagination
			        // pagination
			    };
			},
	        cache: true
		  },
		  // data: [{id: 3, text: '14'}], //set default value 
			  minimumInputLength: 0,
			  templateSelection: myCustomTemplate
			}).unbind('select2:select').on('select2:select', function(e){
				// var $emptyOption = $("<option></option>").val('').text('-Kosongkan-');
				var $newOption = $("<option selected='selected' style=z-index:99999 !important;'></option>").val(e.params.data.id).text(e.params.data.text);
				// $("."+kelas).html($emptyOption);
				$("."+kelas).append($newOption).trigger('change');
				
				if(onSel){
					//alerts "Hello World!" (from within bar AFTER being passed)
					// console.log(e.params.data);
					$("."+kelas).attr('data-select', JSON.stringify(e.params.data));
					if(incVal) {
						$("."+kelas).attr('func',onSel+'('+e.params.data.id+')');
					}else{
						$("."+kelas).attr('func',onSel+'()');
					}
					let newFunc = new Function($("."+kelas).attr('func'));
					newFunc(e);
				}

			});
	}

function myCustomTemplate(item) {
	     return item.text;
	}
// ./select2 combo

function isNull() {
    for (var i = 0; i < arguments.length; i++) {
        if (
            typeof arguments[i] !== 'undefined'
            && arguments[i] !== undefined
            && arguments[i] != null
            && arguments[i] != NaN
            && arguments[i] 
        ) return arguments[i];
      }
}

/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix){
		// console.log(angka);
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		// var number_string = angka.toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		// console.log(rupiah)
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}


// tinymce:
function initMce(par={}){
	// console.log(par.menu);
	tinymce.init({
		selector: '.text-area',
		skin: 'oxide',
            // width: '100%',
            height: par.height || 450,
            plugins: par.plugins || [
            'noneditable advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table directionality emoticons template paste',
            'noneditable lorumipsum',
            ],

            contextmenu: par.contextmenu || "link inserttable | cell row column deletetable",
            // content_css: '../../../assets/plugins/tinymce/js/tinymce/skins/content/writer/content.min.css',
            content_css: 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.1/skins/content/writer/content.min.css',
            toolbar: par.toolbar || 'link image insertfile undo redo lorumipsum | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            // menubar: par.menubar || "file edit insert view format table tools help",
            menubar: par.menu || "table tools view",
            // menubar: "table tools view",
            // menubar:false,
    		statusbar: false,
            
            force_p_newlines : false,
            force_br_newlines : true,
            convert_newlines_to_brs : false,
            remove_linebreaks : true,
            /* enable title field in the Image dialog*/
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
		  /*
		    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
		    images_upload_url: 'postAcceptor.php',
		    here we add custom filepicker only to Image dialog
		    */
		    file_picker_types: 'image',
		    /* and here's our custom image picker*/
		    file_picker_callback: function (cb, value, meta) {
			    	var input = document.createElement('input');
			    	input.setAttribute('type', 'file');
			    	input.setAttribute('accept', 'image/*');

			    /*
			      Note: In modern browsers input[type="file"] is functional without
			      even adding it to the DOM, but that might not be the case in some older
			      or quirky browsers like IE, so you might want to add it to the DOM
			      just in case, and visually hide it. And do not forget do remove it
			      once you do not need it anymore.
			      */

			      input.onchange = function () {
			      	var file = this.files[0];

			      	var reader = new FileReader();
			      	reader.onload = function () {
			        /*
			          Note: Now we need to register the blob in TinyMCEs image blob
			          registry. In the next release this part hopefully won't be
			          necessary, as we are looking to handle it internally.
			          */
			          var id = 'blobid' + (new Date()).getTime();
			          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
			          var base64 = reader.result.split(',')[1];
			          var blobInfo = blobCache.create(id, file, base64);
			          blobCache.add(blobInfo);

			          /* call the callback and populate the Title field with the file name */
			          cb(blobInfo.blobUri(), { title: file.name });
			      };
			      reader.readAsDataURL(file);
			  };

			  input.click();
			},
			// paste_data_images: false,

});
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



	