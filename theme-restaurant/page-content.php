<?php
$pageid = get_the_ID();
if (isset($rf_theme_options['cp_sidebar_position'])) $sidebar_pos = $rf_theme_options['cp_sidebar_position'];
if (isset($pageid)) $sidebar_pos_page = get_post_meta($pageid, "pagelayout", true);
if (isset($sidebar_pos_page) && $sidebar_pos_page != '' && $sidebar_pos_page != 'Global setting') $sidebar_pos = $sidebar_pos_page;
?>

<section id="section-content">
    <div class="container">
        <div class="row">
            <div class="<?php if (isset($sidebar_pos) && $sidebar_pos == 'Fullwidth page') { echo 'col-xs-12'; } elseif ($sidebar_pos == 'Sidebar left') { echo 'col-md-9 col-md-push-3'; } else { echo 'col-md-9'; } ?>">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </div><!-- .post -->
            </div>

            <?php get_sidebar(); ?>

        </div>
    </div>
    <?php //if (current_user_can('edit_posts')) echo '<a class="button editpage" href="'.get_admin_url().'post.php?post='.get_the_ID().'&action=edit" title="'. __('Edit page', 'the-restaurant') .'"></a>'; ?>
</section>
