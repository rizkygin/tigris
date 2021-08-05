/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3 & 4
Version: 4.0.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v4.0/frontend/e-commerce/
    ----------------------------
        APPS CONTENT TABLE
    ----------------------------
    
    <!-- ======== GLOBAL SCRIPT SETTING ======== -->
    01. Handle Fixed Header Option
    02. Handle Page Container Show
    03. Handle Pace Page Loading Plugins
    04. Handle Tooltip Activation
    05. Handle Theme Panel Expand
    06. Handle Theme Page Control
    07. Handle Payment Type Selection
    08. Handle Checkout Qty Control
    09. Handle Product Image
	
    <!-- ======== APPLICATION SETTING ======== -->
    Application Controller
    */

/* 07. Handle Payment Type Selection
------------------------------------------------ */
var handlePaymentTypeSelection = function() {
	$(document).on('click', '[data-click="set-payment"]', function(e) {
		e.preventDefault();

		var targetLi = $(this).closest('li');
		var targetValue = $(this).attr('data-value');
		$('[data-click="set-payment"]').closest('li').not(targetLi).removeClass('active');
		$('[data-id="payment-type"]').val(targetValue);
		$(targetLi).addClass('active');
	});
};


/* 08. Handle Checkout Qty Control
------------------------------------------------ */
var handleQtyControl = function() {
	$(document).on('click', '[data-click="increase-qty"]', function(e) {
		e.preventDefault();
		var targetId = $(this).attr('data-id');
		var targetInput = $(this).attr('data-target');
		var targetTotal = $(this).attr('data-target-total');
		var targetHrg = $(this).attr('data-hrg');
		var targetValue = parseInt($(targetInput).val()) + 1;  
		$(targetInput).val(targetValue);
		$(targetTotal).html(parseInt(targetValue) * parseFloat(targetHrg));
		updateCartCookie({id:targetId, jml:targetValue});
		updateCartSubtotal();
        // console.log($(this));
    });
	$('[data-click="decrease-qty"]').unbind('click').on('click',function(e) {
		e.preventDefault();
		var targetId = $(this).attr('data-id');
		var targetInput = $(this).attr('data-target');
		var targetTotal = $(this).attr('data-target-total');
		var targetHrg = $(this).attr('data-hrg');
		var targetValue = parseInt($(targetInput).val()) - 1;  
		targetValue = (targetValue < 0) ? 0 : targetValue;
		$(targetInput).val(targetValue);
		$(targetTotal).html(parseInt(targetValue) * parseFloat(targetHrg));
		updateCartCookie({id:targetId, jml:targetValue});
		updateCartSubtotal();
        // console.log(targetHrg);
    });
};



/* Application Controller
------------------------------------------------ */
var Checkout = function () {
	"use strict";
	
	return {
		//main function
		init: function () {
		    
            handlePaymentTypeSelection();
            handleQtyControl();
        }
    };
}();

function updateCartSubtotal(){
	let subtotal = 0;
	if(Cookies && Cookies.get('cart_bag') !== undefined) {
	let cartBag = JSON.parse(Cookies.get('cart_bag'));
		$.map(cartBag, function(item, index) {
			subtotal += parseInt(item.jml) * parseFloat(item.hrg);
		});
	$('#cart-subtotal').html(subtotal);
	}

}
function updateCartCookie(par){
	if(Cookies && Cookies.get('cart_bag') !== undefined) {
	let cartBag = JSON.parse(Cookies.get('cart_bag'));

	let foundValue = cartBag.filter(obj=>obj.id==par.id);
	// console.log(foundValue);

	if(foundValue.length > 0){
			foundValue = foundValue[0];
			// console.log(foundValue);
			let objBag = { id:par.id,jml:par.jml,nama:foundValue.nama,img_url:foundValue.img_url,hrg: foundValue.hrg,berat:foundValue.berat};
				// console.log(objBag)
				cartBag.splice(cartBag.findIndex(e => e.id == par.id),1);
				// cartBag[cartBag.filter(obj=>obj.id== proId)] = objBag;
				cartBag.push(objBag);
			}
	Cookies.set('cart_bag', cartBag);
	initCart();
	}

}