'use strict';
$(document).ready(function(){

})

$(function(){
	$('#form-login').on('submit', function(){
		$.ajax({
      url: $(this).attr('action'),
      method: "POST",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function(res){
       if(res.error){
        $.gritter.add({
          title: 'Login Gagal',
          text: res.error,
          image: $('input[name=base_url]').val()+'assets/images/yellow-glass.jpg',
          sticky: false,
          time: '510000' //detik
        });
      }else if (res.success) {
        window.location.href= res.redirect;
      }

    }
  });
		return false;
	});
  $('#form-daftar').on('submit', function(){
    $.ajax({
      url: $(this).attr('action'),
      method: "POST",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function(res){
       if(res.error){
        $.gritter.add({
          title: 'Pendaftaran Gagal',
          text: res.error,
          image: $('input[name=base_url]').val()+'assets/images/yellow-glass.jpg',
          sticky: false,
          time: '510000' //detik
        });
      }else if (res.success) {
        window.location.href= res.redirect;
      }

    }
  });
    return false;
  });
  $('#form-resetpwd').on('submit', function(){
    $.ajax({
      url: $(this).attr('action'),
      method: "POST",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function(res){
       if(res.error){
        $.gritter.add({
          title: 'Reset kata Sandi',
          text: res.error,
          image: $('input[name=base_url]').val()+'assets/images/yellow-glass.jpg',
          sticky: false,
          time: '510000' //detik
        });
      }else if (res.success) {
        window.location.href= res.redirect;
      }

    }
  });
    return false;
  });
  $('#form-signup').on('submit', function(){
    var formSignup = $('#form-signup');

    $.ajax({
      url: formSignup.attr('action'),
      method: "POST",
      dataType: "JSON",
      data: formSignup.serialize(),
      beforeSend: function(){
        $('#modalPendaftaran').find('#btn-signup').html(`
         <span class="spinner spinner-sm text-danger" role="status" aria-hidden="true"></span>
         Loading...`);
      },
      success: function(res){
        if(res.error){
          $.gritter.add({
            title: 'Peringatan',
            text: res.error,
            image: $('input[name=base_url]').val()+'/assets/img/notif.jpg',
            sticky: false,
            time: ''
          });
        }else if (res.success) {
                              // window.location.href= res.redirect;
                              $('#modalPendaftaran').find('.close-modal').click();

                              var messageModal = $('#modal-message');
                              messageModal.find('.modal-title').html(`<h3>Pendaftaran Berhasil</h3>`);
                              messageModal.find('.modal-body').html(`<p>Pendaftaran berhasil, kami telah mengirimkan email verifikasi. Silahkan cek email dan klik tautan didalamnya.</p>`);
                              messageModal.modal('show');
                            }

                            $('#modalPendaftaran').find('#btn-signup').html('Daftar');

                          }

                        });
    return false;
  });

      // reset modal:
            // codes works on all bootstrap modal windows in application
            $('#modalPendaftaran').on('hidden.bs.modal', function(e)
            { 
              $(this).removeData();
              $(this).find('input[name=reg_email]').val('');
              $(this).find('input[name=reg_telp]').val('');
            });

            $('#modal-message').on('hidden.bs.modal', function(e)
            { 
              $(this).removeData();
              $(this).find('.modal-title').html('');
              $(this).find('.modal-body').html('');
            });
          });