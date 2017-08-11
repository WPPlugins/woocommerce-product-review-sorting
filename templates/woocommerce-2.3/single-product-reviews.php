<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;
global $WC_Product_Review_Sorting;

$plugin_settings = array();
$plugin_settings = get_option('dc_wc_product_review_sorting_general_settings_name');

if( !empty($plugin_settings) && isset($plugin_settings) ) {
	$star_5 = $star_4 = $star_3 = $star_2 = $star_1 = $new = $old = '';
	
	$star_5 = $plugin_settings['rating_5'] ? $plugin_settings['rating_5'] : '5 Stars';
	$star_4 = $plugin_settings['rating_4'] ? $plugin_settings['rating_4'] : '4 Stars';
	$star_3 = $plugin_settings['rating_3'] ? $plugin_settings['rating_3'] : '3 Stars';
	$star_2 = $plugin_settings['rating_2'] ? $plugin_settings['rating_2'] : '2 Stars';
	$star_1 = $plugin_settings['rating_1'] ? $plugin_settings['rating_1'] : '1 Stars';
	$new = $plugin_settings['newest'] ? $plugin_settings['newest'] : 'Newest';
	$old = $plugin_settings['oldest'] ? $plugin_settings['oldest'] : 'Oldest';
}



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments">
		<input type="hidden" class="current_post_id" value="<?php echo get_the_id(); ?>" />
		<input type="hidden" class="current_product_title" value="<?php echo get_the_title(); ?>" />
		
		<div class="product_reviews">
			<h2 class="no_of_review"><span><?php
				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
					printf( _n( '%s review for %s', '%s reviews for %s', $count, 'woocommerce' ), $count, get_the_title() );
				else
					_e( 'Reviews', 'woocommerce' );
			?></span></h2>
			<div class="review_sort">
				<?php if( $product->get_review_count() ) : ?>
					<div class="rating_sorting_container">
						<select class="rating_sorting">
							<option id="default" selected="selected" value="default"><?php echo __( 'Sort by Rating', $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="5"><?php echo __( $star_5, $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="4"><?php echo __( $star_4, $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="3"><?php echo __( $star_3, $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="2"><?php echo __( $star_2, $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="1"><?php echo __( $star_1, $WC_Product_Review_Sorting->text_domain ); ?></option>
						</select>
					</div>
					<div class="time_sorting_container">
						<select class="time_sorting">
							<option id="default" selected="selected" value="default"><?php echo "Sort by Date" ?></option>
							<option value="new"><?php echo __( $new, $WC_Product_Review_Sorting->text_domain ); ?></option>
							<option value="old"><?php echo __( $old, $WC_Product_Review_Sorting->text_domain ); ?></option>
						</select>
					</div>
				<?php endif ?>
			</div>
		</div>
		<div class="clear"></div>

		<?php if ( have_comments() ) : ?>
			
			<ol class="commentlist">
				<?php
					wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );
				?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'woocommerce' ) : __( 'Be the first to review', 'woocommerce' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => __( 'Submit', 'woocommerce' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
							<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
						</select></p>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
