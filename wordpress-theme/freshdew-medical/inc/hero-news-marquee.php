<?php
/**
 * Hero marquee — markup only; styles in assets/css/hero-marquee.css (v8).
 * Set global $freshdew_marquee_args (array with keys text, badge_desktop, badge_mobile) before get_template_part().
 *
 * @package FreshDewMedical
 */

global $freshdew_marquee_args;
$m = ( isset( $freshdew_marquee_args ) && is_array( $freshdew_marquee_args ) ) ? $freshdew_marquee_args : array();

$fd_marquee_text = isset( $m['text'] ) ? $m['text'] : 'This is to notify all patients that Dr. Kinze will be away on vacation from April 15 to April 24, 2026.  The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
$fd_badge_desktop = isset( $m['badge_desktop'] ) ? $m['badge_desktop'] : __( 'Vacation Notice', 'freshdew-medical' );
$fd_badge_mobile  = isset( $m['badge_mobile'] ) ? $m['badge_mobile'] : __( 'Vacation', 'freshdew-medical' );

$fd_marquee_build = function_exists( 'freshdew_hero_marquee_build' ) ? freshdew_hero_marquee_build() : (string) time();
?>
<!-- fd-marquee-v8: <?php echo esc_attr( $fd_marquee_build ); ?> -->
<div class="fd-hero-marquee fd-hero-marquee--v8" role="region" aria-label="<?php echo esc_attr( wp_strip_all_tags( $fd_badge_desktop ) ); ?>" data-fd-marquee-v="8" data-fd-marquee-build="<?php echo esc_attr( $fd_marquee_build ); ?>">
	<div class="fd-hero-marquee__center">
		<div class="fd-hero-marquee__row">
			<div class="fd-hero-marquee__row-inner">
				<div class="fd-hero-marquee__track-outer">
					<div class="fd-hero-marquee__track" aria-hidden="true">
						<?php for ( $i = 0; $i < 4; $i++ ) : ?>
							<span><?php echo esc_html( $fd_marquee_text ); ?></span>
						<?php endfor; ?>
					</div>
				</div>
				<div class="fd-hero-marquee__badge">
					<span class="fd-hero-marquee__badge-text fd-hero-marquee__badge-text--desktop"><?php echo esc_html( $fd_badge_desktop ); ?></span>
					<span class="fd-hero-marquee__badge-text fd-hero-marquee__badge-text--mobile"><?php echo esc_html( $fd_badge_mobile ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<span class="fd-sr-only"><?php echo esc_html( $fd_marquee_text ); ?></span>
</div>
