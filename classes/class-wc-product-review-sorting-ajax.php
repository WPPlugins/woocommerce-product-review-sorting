<?php
class WC_Product_Review_Sorting_Ajax {

	public function __construct() {
		//Sort product rating using Ajax
		add_action( 'wp_ajax_sort_review_rating_ajax', array(&$this, 'sort_review_rating') );
		add_action( 'wp_ajax_nopriv_sort_review_rating_ajax', array(&$this, 'sort_review_rating') );
		
		//Sort review time using Ajax
		add_action( 'wp_ajax_sort_review_time_ajax', array(&$this, 'sort_review_time') );
		add_action( 'wp_ajax_nopriv_sort_review_time_ajax', array(&$this, 'sort_review_time') );
	}

	function sort_review_rating() {
		$customer_review = array();
		$product_id = $selected_option = '';
		$no_of_comments = 0;
		$product_id = $_POST['product_id'];
		$selected_rating = $_POST['selected_rating'];
		$selected_time = $_POST['selected_time'];
		
		$customer_review = get_comments( array( 'post_id' => $product_id ) );
		
		if( $selected_time != 'default' ) {
			$temp = array();
			foreach( $customer_review as $key => $data ) {
				$temp[$key] = $data->comment_ID;
			}
			if( $selected_time && !empty($selected_time) ) {
				if( $selected_time == 'new' ) {
					array_multisort( $temp, SORT_DESC , $customer_review );
				} else if( $selected_time == 'old' ) {
					array_multisort( $temp, SORT_ASC , $customer_review );
				}
			}
		}
		
		foreach( $customer_review as $key => $each_review ) {
			$ratings = intval( get_comment_meta( $each_review->comment_ID, 'rating', true ) );
			if( !empty($ratings) && $selected_rating == $ratings ) {
				$GLOBALS['comment'] = $each_review;
				wc_get_template( 'single-product/review.php', array( 'comment' => $each_review ) );
				$no_of_comments++;
			}
		}
		
		echo '[${#(%18_concatenate-string%18)#}$]'.$no_of_comments;
		
		die();
	}
	
	
	function sort_review_time() {
		$product_id = $selected_rating = $selected_time = '';
		$customer_review = array();
		$no_of_comments = 0;
		$product_id = $_POST['product_id'];
		$selected_rating = $_POST['selected_rating'];
		$selected_time = $_POST['selected_time'];
		
		$customer_review = get_comments( array( 'post_id' => $product_id ) );
		
		$temp = array();
		foreach( $customer_review as $key => $data ) {
			$temp[$key] = $data->comment_ID;
		}
		if( $selected_time && !empty($selected_time) ) {
			if( $selected_time == 'new' ) {
				array_multisort( $temp, SORT_DESC , $customer_review );
			} else if( $selected_time == 'old' ) {
				array_multisort( $temp, SORT_ASC , $customer_review );
			}
		}
		
		if( $selected_rating != 'default' ) {
			foreach( $customer_review as $key => $each_review ) {
				$ratings = intval( get_comment_meta( $each_review->comment_ID, 'rating', true ) );
				if( !empty($ratings) && $selected_rating == $ratings ) {
					$GLOBALS['comment'] = $each_review;
					wc_get_template( 'single-product/review.php', array( 'comment' => $each_review ) );
					$no_of_comments++;
				}
			}
		} else {
			foreach( $customer_review as $key => $each_review ) {
				$GLOBALS['comment'] = $each_review;
					wc_get_template( 'single-product/review.php', array( 'comment' => $each_review ) );
			}
		}
		
		die();
	}

}
