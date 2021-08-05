class Paginate{
	'use strict';

	/*
	func:'getItemsRiw',
	total:total,
	limit:limit,
	curr:page,
	komp:modal,
	param:{
		id:idItems
	}
	*/
	constructor(params){
		this.komp = params.komp;
		this.func = params.func;
		this.total = params.total || 0;
		this.limit = params.limit || 10;
		this.curr = params.curr;
		this.param = params.param;
		// this.addParam = params.addParam;
	}
	init(){
		function getFunction(func, fpar){
			// console.log(fpar);
			let newFunc = new Function(func+`(`+JSON.stringify(fpar)+`)`);
			newFunc(fpar);
		}
		let komp = this.komp;
		let current = this.curr;
		let funcName = this.func;
		let totalData =this.total;
		let perPage = this.limit;
		let totalPages = Math.ceil(totalData / perPage);
		let paginationSize = 6;
		let currPage;
		let hash = false;
		let funcParam = this.param;

		function getPageList(totalPages, page, maxLength) {
			if (maxLength < 5) throw "maxLength must be at least 5";

			function range(start, end) {
				// console.log(start);
				// console.log(end);
				if(!isNaN(start) || typeof start) return Array.from(Array(end - start + 1), (_, i) => i + start);
				else return false;
			}

			// console.log(range());
			// console.log(totalPages);
			// console.log(page);
			// console.log(maxLength);
			if(!isNaN(page)){
				var sideWidth = maxLength < 9 ? 1 : 2;
				var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
				var rightWidth = (maxLength - sideWidth * 2 - 2) >> 1;
				// console.log(sideWidth);
				// console.log(leftWidth);
				// console.log(rightWidth);
				if (totalPages <= maxLength) {
					return range(1, totalPages);
				}
				if (page <= maxLength - sideWidth - 1 - rightWidth) {
					return range(1, maxLength - sideWidth - 1)
					.concat([0])
					.concat(range(totalPages - sideWidth + 1, totalPages));
				}
				if (page >= totalPages - sideWidth - 1 - rightWidth) {
					return range(1, sideWidth)
					.concat([0])
					.concat(
						range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages)
						);
				}
				return range(1, sideWidth)
				.concat([0])
				.concat(range(page - leftWidth, page + rightWidth))
				.concat([0])
				.concat(range(totalPages - sideWidth + 1, totalPages));
			}
			
		}


		function showPage(whichPage) {
			// console.log(whichPage)

			if (whichPage < 1 || whichPage > totalPages || isNaN(whichPage)) return false;
			currPage = whichPage;

			$(komp).find('.pagination li').slice(1, -1).remove();
			let  clickParam =funcParam; 
			getPageList(totalPages, currPage, paginationSize).forEach(item => {
				clickParam.page = item;

				$('<li>')
				.addClass(
					'page-item ' +
					(item ? 'current-page ' : '') +
					(item === currPage ? 'active ' : '')
					)
				.append(
					$('<a>')
					.addClass('page-link ')
					.attr({
						onClick: (item ? funcName+'('+JSON.stringify(clickParam)+')' : 'javascript:\$(function()\{return false;\})')
					})
					.text(item || "...")
					)
				.insertBefore($(komp).find('#next-page'));
				
			});
			return true;
		}

		$(komp).find('.pagination').append(
			$('<li>').addClass('page-item').attr({ id: 'previous-page' }).append(
				$('<a>')
				.addClass('page-link').addClass("page-link").attr({
                href: "javascript:void(0)"})
				.text('«')
				),
			$('<li>').addClass('page-item').attr({ id: 'next-page' }).append(
				$('<a>')
				.addClass('page-link').addClass("page-link").attr({
                href: "javascript:void(0)"})
				.text('»')
				),

			);


		showPage(current);
		$(komp).find('.total-pagination').text('Total data: '+totalData+', Menampilkan halaman '+currPage+' dari '+totalPages+'.');
		
		$(document).on('click', $(komp).find('.pagination li.current-page:not(.active)'), function() {
			showPage(+$(this).text());
		});

		currPage = current;

		$(komp).find('#next-page').unbind().click(function() {
			showPage(currPage + 1);
			funcParam.page = currPage;
			getFunction(funcName,funcParam);
		});

		$(komp).find('#previous-page').unbind().click(function() {
			showPage(currPage - 1);
			funcParam.page = currPage;
			getFunction(funcName,funcParam);
		});

		$(komp).find('.pagination').on('click', function() {
			$('html,body').animate({ scrollTop: 0 }, 0);
		});

	}

} 


