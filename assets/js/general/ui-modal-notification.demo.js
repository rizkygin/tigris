/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3 & 4
Version: 4.1.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v4.1/admin/
*/

var handleGritterNotification = function() {
	var adaNotif = $('#add-regular');
	if(adaNotif.length){
		$.gritter.add({
			title: $(adaNotif).data('title'),
			text: $(adaNotif).data('text'),
			image: $('input[name=base_url]').val()+'/assets/images/yellow-glass.jpg',
			sticky: false,
			time: ''
		});
		return false;
	}


	$('#remove-all').click(function(){
		$.gritter.removeAll();
		return false;
	});
	$('#remove-all-with-callbacks').click(function(){
		$.gritter.removeAll({
			before_close: function(e){
				alert('I am called before all notifications are closed.  I am passed the jQuery object containing all  of Gritter notifications.\n' + e);
			},
			after_close: function(){
				alert('I am called after everything has been closed.');
			}
		});
		return false;
	});
};

var handleSweetNotification = function() {
	$('[data-click="swal-primary"]').click(function(e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: 'You will not be able to recover this imaginary file!',
			icon: 'info',
			buttons: {
				cancel: {
					text: 'Cancel',
					value: null,
					visible: true,
					className: 'btn btn-default',
					closeModal: true,
				},
				confirm: {
					text: 'Primary',
					value: true,
					visible: true,
					className: 'btn btn-primary',
					closeModal: true
				}
			}
		});
	});

	$('[data-click="swal-info"]').click(function(e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: 'You will not be able to recover this imaginary file!',
			icon: 'info',
			buttons: {
				cancel: {
					text: 'Cancel',
					value: null,
					visible: true,
					className: 'btn btn-default',
					closeModal: true,
				},
				confirm: {
					text: 'Info',
					value: true,
					visible: true,
					className: 'btn btn-info',
					closeModal: true
				}
			}
		});
	});

	$('[data-click="swal-success"]').click(function(e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: 'You will not be able to recover this imaginary file!',
			icon: 'success',
			buttons: {
				cancel: {
					text: 'Cancel',
					value: null,
					visible: true,
					className: 'btn btn-default',
					closeModal: true,
				},
				confirm: {
					text: 'Success',
					value: true,
					visible: true,
					className: 'btn btn-success',
					closeModal: true
				}
			}
		});
	});

	$('[data-click="swal-warning"]').click(function(e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: 'You will not be able to recover this imaginary file!',
			icon: 'warning',
			buttons: {
				cancel: {
					text: 'Cancel',
					value: null,
					visible: true,
					className: 'btn btn-default',
					closeModal: true,
				},
				confirm: {
					text: 'Warning',
					value: true,
					visible: true,
					className: 'btn btn-warning',
					closeModal: true
				}
			}
		});
	});

	$('[data-click="swal-danger"]').click(function(e) {
		e.preventDefault();
		swal({
			title: 'Are you sure?',
			text: 'You will not be able to recover this imaginary file!',
			icon: 'error',
			buttons: {
				cancel: {
					text: 'Cancel',
					value: null,
					visible: true,
					className: 'btn btn-default',
					closeModal: true,
				},
				confirm: {
					text: 'Warning',
					value: true,
					visible: true,
					className: 'btn btn-danger',
					closeModal: true
				}
			}
		});
	});
};

var handleModal = function(){
	$('#modal-message').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  // var recipient = button.data('whatever') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this);
		  if(modal.find('.submit-modal').length == 0) modal.find('.modal-footer').append(`<a href="javascript:;" class="btn btn-primary submit-modal">Lanjutkan</a>`);
		  var act = button.data('act');
		  var html = button.children('textarea').val();
		  // console.log(modal);
		  if(act == 'hapus'){
		 	modal.find('.modal-title').text('Konfirmasi Hapus');
		 	modal.find('.modal-body').text('Lanjutkan menghapus data ? ');
		  } else if(act == 'detail-kolom'){
		 	modal.find('.modal-title').text('');
		 	modal.find('.modal-body').html(html);
		 	modal.find('.submit-modal').remove();
		  }
		  modal.find('.submit-modal').on('click', function(){		  	
		  	if(act == 'hapus') {
		  		window.location.href = button.attr('href');
		  	}
		  });
		});
};


var Notification = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleGritterNotification();
            // handleSweetNotification();
            handleModal();
        }
    };
}();