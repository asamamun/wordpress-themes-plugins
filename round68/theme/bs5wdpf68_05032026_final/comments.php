<?php if (have_comments()) : ?>
<div class="comments-template">
	<h3><?php comments_number(); ?> <?php esc_html_e('Comments', 'bs5wdpf68'); ?></h3>
	<ol class="comment-list">
		<?php wp_list_comments(array(
			'style'        => 'ol',
			'callback'     => 'bs5wdpf68_comments_callback',
			'end_callback' => 'bs5wdpf68_comments_end_callback'
		)); ?>
	</ol>

	<?php the_comments_navigation(); ?>

	<?php if (!comments_open()) : ?>
	<p class="no-comments"><?php esc_html_e('Comments are closed.', 'bs5wdpf68'); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div>

<?php endif; ?>

<?php function bs5wdpf68_comments_callback($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar($comment, 50); ?>
			<?php printf(__('<cite class="fn">%s</cite>', 'bs5wdpf68'), get_comment_author_link()); ?>
		</div>

		<?php if ($comment->comment_approved == '1') : ?>
			<div class="comment-meta commentmetadata">
				<?php
				printf(
					__('<a href="%1$s" title="%2$s"><time datetime="%3$s">%4$s</time></a>', 'bs5wdpf68'),
					get_comment_link(),
					esc_attr(get_the_title()),
					get_comment_date('Y-m-d'),
					get_comment_date()
				);
				?>
			</div>

			<div class="comment-body">
				<?php comment_text(); ?>
			</div>
			<div class="reply">
				<?php comment_reply_link(array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])); ?>
			</div>
		<?php endif; ?>

	</div>
<?php }

function bs5wdpf68_comments_end_callback($comment, $args, $depth) {
	// End of comment item - WordPress handles the closing </li>
}
?>

