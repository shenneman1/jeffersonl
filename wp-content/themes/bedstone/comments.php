<?php
/**
 * comments
 *
 * Both current comments and the comment form.
 *
 * @package Bedstone
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}
?>

<?php if (comments_open() || '0' != get_comments_number()) : ?>
    <section class="container-comments">
        <header class="comments-header">
            <h1 class="comments-header__title">Comments</h1>
        </header>

    	<?php if (have_comments()) : ?>

    	    <div class="comments">
                <?php wp_list_comments(array('style' => 'div', 'short_ping' => true)); ?>
    	    </div>

    		<?php if (1 < get_comment_pages_count() && get_option('page_comments')) : ?>
    		    <footer class="comments-footer">
            		<nav class="nav-comments">
            			<div class="nav-comments--prev"><?php previous_comments_link('Older Comments'); ?></div>
            			<div class="nav-comments--next"><?php next_comments_link('Newer Comments'); ?></div>
            		</nav>
        		</footer>
    		<?php endif; ?>

    	<?php endif; ?>

    	<div class="comment-form hidden-print">
    	    <?php
            if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) {
                echo '<p class="comment-form--closed">Comments are closed.</p>';
            } else {
                comment_form(array('comment-notes-before' => '', 'class-form' => ''));
            }
            ?>
    	</div>

    </section>
<?php endif; ?>
