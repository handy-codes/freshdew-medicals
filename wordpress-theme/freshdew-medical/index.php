<?php
/**
 * Main Template File
 *
 * @package FreshDewMedical
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <section style="padding: 4rem 0; text-align: center;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: #1f2937;">Welcome to FreshDew Medical Clinic</h1>
                <p style="font-size: 1.25rem; color: #6b7280; margin-bottom: 2rem;">
                    Your trusted healthcare partner in Belleville, Ontario
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn">Learn About Us</a>
                    <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" class="btn">Book Appointment</a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline" style="background: transparent; border: 2px solid #2563eb; color: #2563eb;">Contact Us</a>
                </div>
            </section>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();

