<?php global $more, $wp_query;
get_header();
the_post();
?>

<div id="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><?php the_title() ?></h1>
            </div>
        </div>
    </div>
</div>

<div id="sections">
        
	<?php
	// Set rf section id
	$rf_section_ID = get_the_ID();
	
	// Get section
	include(locate_template('section'));
	?>
    
</div>

<?php get_footer(); ?>