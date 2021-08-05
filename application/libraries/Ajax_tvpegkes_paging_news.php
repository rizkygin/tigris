<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 * 
 * Modified by CodexWorld.com
 * @Ajax pagination functionality has added with this library. 
 * @It will helps to integrate Ajax pagination with loading image in CodeIgniter application.
 * @TutorialLink http://www.codexworld.com/ajax-pagination-in-codeigniter-framework/
 */
class Ajax_tvpegkes_paging_news{

	var $base_url           = ''; // The page we are linking to
	var $total_rows  		= ''; // Total number of items (database results)
	var $per_page	 		= 10; // Max number of items you want shown per page
	var $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page	 		=  0; // The current page being viewed
	var $first_link   		= 'First';
	var $next_link			= '&#187;';
	var $prev_link			= '&#171;';
	var $last_link			= 'Last';
	var $uri_segment		= 3;
	var $full_tag_open		= '<div class="pagination">';
	var $full_tag_close		= '</div>';
	var $first_tag_open		= '';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '';
	var $cur_tag_open		= '&nbsp;<b>';
	var $cur_tag_close		= '</b>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '';
	var $target             = '';
    var $anchor_class		= '';
    var $show_count         = true;
    var $link_func          = 'getDataNews';
    var $loading            = '.loading';

	/**
	 * Constructor
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function CI_Pagination($params = array()){
		if (count($params) > 0){
			$this->initialize($params);		
		}
		log_message('debug', "Pagination Class Initialized");
	}
	
	/**
	 * Initialize Preferences
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = $val;

				}
			}		
		}
		
		// Apply class tag using anchor_class variable, if set.
		if ($this->anchor_class != ''){
			$this->anchor_class = 'class="' . $this->anchor_class . '" ';
		}
	}
	
	/**
	 * Generate the pagination links
	 * @access	public
	 * @return	string
	 */	
	function create_links($jeda=3){
		// If our item count or per-page total is zero there is no need to continue.
		// if ($this->total_rows == 0 OR $this->per_page == 0){
		//    return '';
		// }

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
			// if ($num_pages == 1){
	  //           $info = 'Showing : ' . $this->total_rows;
			// 	return $info;
			// }

		// Determine the current page number.		
		$CI =& get_instance();	
		if ($CI->uri->segment($this->uri_segment) != 0){
			$this->cur_page = $CI->uri->segment($this->uri_segment);
			
			// Prep the current page - no funny business!
			$this->cur_page = (int) $this->cur_page;
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1){
			show_error('Your number of links must be a positive number.');
		}
				
		if ( ! is_numeric($this->cur_page)){
			$this->cur_page = 0;
		}
		
		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows){
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		
		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Add a trailing slash to the base URL if needed
		$this->base_url = rtrim($this->base_url, '/') .'/';

  		// And here we go...
		$output = '';

		

		if ($this->cur_page < $num_pages) {
			$output .= $this->getAJAXlink($this->cur_page * $this->per_page);
		}else{
			$output .= $this->getAJAXlink(0);
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		?>
        <script>
        
        function getDataNews(page){  
            $.ajax({
                method: "POST",
                url: "<?php echo $this->base_url; ?>"+page,
                data: { page: page },
                beforeSend: function(){
                	$('<?php echo $this->target; ?>').fadeOut();
                },
                success: function(data){

                	$('<?php echo $this->target; ?>').html(data).fadeIn();
                	
                }
            });

           // setTimeout(getDataNews(page), 9000);
           //return false;
        }

        $(document).ready(function() {
		  // run the first time; all subsequent calls will take care of themselves
		 var page_news = $('#page_news').val();
		  // setInterval(getDataNews(page_news), 90000000);
		  // var timer = new TaskTimer(1000); // milliseconds
		  var timer = new TaskTimer(1000); // milliseconds
		  // timer.stop();
			// Execute some code on each tick...
			timer.on("tick", function () {
				
			    //console.log("tick count: " + timer.tickCount);
			    // console.log("elapsed time: " + timer.time.elapsed + " ms.");
			});
			// Or add a task named "heartbeat" that runs every 5 ticks and a total of 10 times.
			var task = {
			    name: "heartbeat",
			    tickInterval: <?php echo intval($jeda); ?>, // ticks
			    totalRuns: 1, // times
			    callback: function (task) {
			    	getDataNews(page_news);
			        //console.log(task.name + " task has run " + task.currentRuns + " times.");
			    }
			};

			timer.addTask(task).start();
		});
		
        </script>
        <?php
		return $output;		
	}

	function getAJAXlink($count, $text='') {
        $pageCount = $count?$count:0;
		// return '<a href="javascript:void(0);"' . $this->anchor_class . ' onclick="'.$this->link_func.'('.$pageCount.')">'. $text .'</a>';
		return '<input type="hidden" id="page_news" value="'.$pageCount.'">';

	}

}
// END Pagination Class