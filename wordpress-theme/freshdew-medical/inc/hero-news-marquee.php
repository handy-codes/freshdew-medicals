<?php
/**
 * Vacation notice marquee — markup only; styles in assets/css/hero-marquee.css (v8).
 * Desktop: flex row (track + rectangular badge). Mobile: same DOM; badge absolute over track.
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr. Kinze will be away on vacation from April 15 to April 24, 2026.  The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
$fd_marquee_build = function_exists( 'freshdew_hero_marquee_build' ) ? freshdew_hero_marquee_build() : (string) time();
?>
<!-- fd-marquee-v8: <?php echo esc_attr( $fd_marquee_build ); ?> -->
<div class="fd-hero-marquee fd-hero-marquee--v8" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>" data-fd-marquee-v="8" data-fd-marquee-build="<?php echo esc_attr( $fd_marquee_build ); ?>">
	<div class="fd-hero-marquee__center">
		<div class="fd-hero-marquee__row">
			<div class="fd-hero-marquee__row-inner">
				<div class="fd-hero-marquee__track-outer">
					<div class="fd-hero-marquee__track" aria-hidden="true">
						<?php
						for ( $i = 0; $i < 4; $i++ ) :
							?>
							<span><?php echo esc_html( $fd_marquee_text ); ?></span>
							<?php
						endfor;
						?>
					</div>
				</div>
				<div class="fd-hero-marquee__badge">
					<span class="fd-hero-marquee__badge-text fd-hero-marquee__badge-text--desktop"><?php echo esc_html__( 'Vacation Notice', 'freshdew-medical' ); ?></span>
					<span class="fd-hero-marquee__badge-text fd-hero-marquee__badge-text--mobile"><?php echo esc_html__( 'Vacation', 'freshdew-medical' ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<span class="fd-sr-only"><?php echo esc_html( $fd_marquee_text ); ?></span>
</div>
