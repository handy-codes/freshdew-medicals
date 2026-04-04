<?php
/**
 * Vacation notice marquee — v6: full-width navy bar, red badge enforced (incl. mobile cache).
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
$fd_marquee_build = function_exists( 'freshdew_hero_marquee_build' ) ? freshdew_hero_marquee_build() : '0';
?>
<!-- fd-marquee-build: <?php echo esc_attr( $fd_marquee_build ); ?> -->
<div class="fd-hero-marquee fd-hero-marquee--v6" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>" data-fd-marquee-build="<?php echo esc_attr( $fd_marquee_build ); ?>" style="color-scheme: light;">
	<style>
		/* Self-contained if style.css is stale: navy full width, red badge, scroll speed. */
		@keyframes fdMarqueeV6Inline {
			from { transform: translate3d(0, 0, 0); }
			to { transform: translate3d(-50%, 0, 0); }
		}
		.hero-section--marquee .fd-hero-marquee--v6.fd-hero-marquee,
		.fd-hero-marquee--v6.fd-hero-marquee {
			position: absolute !important;
			top: 0 !important;
			z-index: 30 !important;
			box-sizing: border-box !important;
			background-color: #00468D !important;
			overflow: hidden !important;
			padding: 0.3rem 0 !important;
		}
		@media (max-width: 639.98px) {
			.hero-section--marquee .fd-hero-marquee--v6.fd-hero-marquee,
			.fd-hero-marquee--v6.fd-hero-marquee {
				left: 50% !important;
				right: auto !important;
				transform: translateX(-50%) !important;
				width: 100vw !important;
				max-width: 100vw !important;
			}
		}
		@media (min-width: 640px) {
			.hero-section--marquee .fd-hero-marquee--v6.fd-hero-marquee,
			.fd-hero-marquee--v6.fd-hero-marquee {
				left: 0 !important;
				right: 0 !important;
				width: 100% !important;
				max-width: 100% !important;
				transform: none !important;
			}
		}
		.fd-hero-marquee--v6 .fd-hero-marquee__center {
			display: flex !important;
			justify-content: center !important;
			align-items: stretch !important;
			width: 100% !important;
			box-sizing: border-box !important;
		}
		@media (max-width: 639.98px) {
			.fd-hero-marquee--v6 .fd-hero-marquee__center {
				padding: 0 clamp(8px, 2.5vw, 14px) !important;
			}
		}
		@media (min-width: 640px) {
			.fd-hero-marquee--v6 .fd-hero-marquee__center {
				padding: 0 clamp(1.5rem, 7vw, 4.5rem) !important;
			}
		}
		.fd-hero-marquee--v6 .fd-hero-marquee__track.fd-marquee-track-fast {
			animation: fdMarqueeV6Inline 40s linear infinite !important;
		}
		@media (max-width: 639.98px) {
			.fd-hero-marquee--v6 .fd-hero-marquee__track.fd-marquee-track-fast {
				animation: fdMarqueeV6Inline 26s linear infinite !important;
			}
		}
		.fd-hero-marquee--v6 .fd-hero-marquee__badge.fd-marquee-badge-red {
			background: #FF0000 !important;
			background-color: #FF0000 !important;
			color: #ffffff !important;
			-webkit-print-color-adjust: exact !important;
			print-color-adjust: exact !important;
		}
		@media (forced-colors: active) {
			.fd-hero-marquee--v6 .fd-hero-marquee__badge.fd-marquee-badge-red {
				forced-color-adjust: none !important;
				background-color: #FF0000 !important;
				color: #ffffff !important;
			}
		}
	</style>
	<div class="fd-hero-marquee__center">
		<div class="fd-hero-marquee__row">
			<div class="fd-hero-marquee__track-outer">
				<div class="fd-hero-marquee__track fd-marquee-track-fast" aria-hidden="true">
					<?php
					for ( $i = 0; $i < 4; $i++ ) :
						?>
						<span><?php echo esc_html( $fd_marquee_text ); ?></span>
						<?php
					endfor;
					?>
				</div>
			</div>
			<div class="fd-hero-marquee__badge fd-marquee-badge-red" style="background-color:#FF0000;color:#ffffff;">
				<span class="fd-hero-marquee__badge-text"><?php echo esc_html__( 'Vacation Notice', 'freshdew-medical' ); ?></span>
			</div>
		</div>
	</div>
	<span class="fd-sr-only"><?php echo esc_html( $fd_marquee_text ); ?></span>
</div>
