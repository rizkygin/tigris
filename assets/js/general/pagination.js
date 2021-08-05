class Pagination{

    constructor(func, totalItem, limit, current){
      this.func = func;
      this.totalItem = totalItem || 0;
      this.limit = limit || 10;
      this.current = current;
    }
  
    init(){
      
      let current = this.current; //current page;
  
      function getFunction(func, dat){
        // alert('haloo');
        let fungsiBaru = new Function(func+'('+dat+')');
        return fungsiBaru();
      }
  
       let funcName = this.func;
       var numberOfItems =this.totalItem;
       var limitPerPage = this.limit;
       // Total pages rounded upwards
       var totalPages = Math.ceil(numberOfItems / limitPerPage);
       // Number of buttons at the top, not counting prev/next,
       // but including the dotted buttons.
       // Must be at least 5:
       var paginationSize = 5;
       var currentPage;
       let hash = false;
      // Returns an array of maxLength (or less) page numbers
      // where a 0 in the returned array denotes a gap in the series.
      // Parameters:
      //   totalPages:     total number of pages
      //   page:           current page
      //   maxLength:      maximum size of returned array
  
      function getPageList(totalPages, page, maxLength) {
        if (maxLength < 5) throw "maxLength must be at least 5";
  
        function range(start, end) {
          return Array.from(Array(end - start + 1), (_, i) => i + start);
        }
  
  
        var sideWidth = maxLength < 9 ? 1 : 2;
        var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
        var rightWidth = (maxLength - sideWidth * 2 - 2) >> 1;
        if (totalPages <= maxLength) {
          // no breaks in list
          return range(1, totalPages);
        }
        if (page <= maxLength - sideWidth - 1 - rightWidth) {
          // no break on left of page
          return range(1, maxLength - sideWidth - 1)
            .concat([0])
            .concat(range(totalPages - sideWidth + 1, totalPages));
        }
        if (page >= totalPages - sideWidth - 1 - rightWidth) {
          // no break on right of page
          return range(1, sideWidth)
            .concat([0])
            .concat(
              range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages)
            );
        }
        // Breaks on both sides
        return range(1, sideWidth)
          .concat([0])
          .concat(range(page - leftWidth, page + rightWidth))
          .concat([0])
          .concat(range(totalPages - sideWidth + 1, totalPages));
      }
  
      
      function showPage(whichPage) {
        if (whichPage < 1 || whichPage > totalPages) return false;
        currentPage = whichPage;
        
        // Replace the navigation items (not prev/next):
        $(".pagination li").slice(1, -1).remove();
        // console.log(getPageList(totalPages, currentPage, paginationSize));
  
        getPageList(totalPages, currentPage, paginationSize).forEach(item => {
          $("<li>")
            .addClass(
              "page-item " +
                (item ? "current-page " : "") +
                (item === currentPage ? "active " : "")
            )
            .append(
              $("<a>")
                .addClass("page-link ")
                .attr({
                //   href: "#"+item,
                  onClick: (item ? funcName+'('+item+')' : 'return false;')
                })
                .text(item || "...")
            )
            .insertBefore("#next-page");
        });
        return true;
      }
  
      // Include the prev/next buttons:
      $(".pagination").append(
        $("<li>").addClass("page-item").attr({ id: "previous-page" }).append(
          $("<a>")
            .addClass("page-link")
            // .attr({
            //   href: "#"
            // })
            .text("«")
        ),
        $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
          $("<a>")
            .addClass("page-link")
            // .attr({
            //   href: "#"
            // })
            .text("»")
        ),
  
      );
  
      // Show the page links & data
  
      showPage(current);
      $('.total-pagination').text('Total data: '+numberOfItems+', Menampilkan halaman '+currentPage+' dari '+totalPages+'.');
      // Use event delegation, as these items are recreated later
      $(document).on("click", ".pagination li.current-page:not(.active)", function() {
        showPage(+$(this).text());
      });
  
      // console.log(arrPages);
  
      currentPage = current;
      $("#next-page").unbind().click(function() {
        showPage(currentPage + 1);
        getFunction(funcName,currentPage);
        // $(this).find('a').attr({
        //       href: "#"+currentPage
        //     });
      });
  
      $("#previous-page").unbind().click(function() {
        showPage(currentPage - 1);
        getFunction(funcName,currentPage);
        // $(this).find('a').attr({
        //       href: "#"+currentPage
        //     });
      });
  
  
      $(".pagination").on("click", function() {
        $("html,body").animate({ scrollTop: 0 }, 0);
      });
  
    }
  
  
  
  } 
  
  
  