<?php
/**
 * Vacation notice marquee — inset bar; typography matches header .nav-menu > li > a.
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
?>
<div class="fd-hero-marquee fd-hero-marquee--v4" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>">
	<style id="fd-hero-marquee-css-v4">
		/* <640: left 4vw right 0; 640+: left 20vw right 5vw — !important beats stale/cached rules */
		.hero-section--marquee .fd-hero-marquee.fd-hero-marquee--v4 {
			position: absolute !important;
			top: 0 !important;
			left: 4vw !important;
			right: 0 !important;
			width: auto !important;
			z-index: 30 !important;
			box-sizing: border-box !important;
			background: #00468D !important;
			overflow: visible !important;
			padding: 0.2rem 0 !important;
		}
		@media (max-width: 639.98px) {
			.hero-section--marquee .fd-hero-marquee.fd-hero-marquee--v4 {
				margin-bottom: 0.65rem !important;
			}
		}
		@media (min-width: 640px) {
			.hero-section--marquee .fd-hero-marquee.fd-hero-marquee--v4 {
				left: 20vw !important;
				right: 5vw !important;
			}
		}
		.fd-hero-marquee--v4 .fd-hero-marquee__row {
			display: flex !important;
			flex-direction: row !important;
			align-items: stretch !important;
			width: 100% !important;
			min-height: 1.75rem !important;
			gap: 0 !important;
			isolation: isolate !important;
		}
		.fd-hero-marquee--v4 .fd-hero-marquee__track-outer {
			flex: 1 1 auto !important;
			min-width: 0 !important;
			overflow: hidden !important;
			display: flex !important;
			align-items: center !important;
			background: #fff !important;
			margin: 0 !important;
			padding: 0 !important;
			border: none !important;
			border-radius: 0 !important;
			margin-right: -1rem !important;
			position: relative !important;
			z-index: 1 !important;
		}
		/* Same scroll duration on all breakpoints — 45s (snappy; identical mobile/desktop) */
		.fd-hero-marquee--v4 .fd-hero-marquee__track {
			display: inline-flex !important;
			white-space: nowrap !important;
			will-change: transform !important;
			align-items: center !important;
			animation: fdMarqueeK2026 45s linear infinite !important;
			backface-visibility: hidden !important;
		}
		/* Match .site-header .main-navigation .nav-menu > li > a — not bolder than nav */
		.fd-hero-marquee--v4 .fd-hero-marquee__track span {
			display: inline-block !important;
			margin-right: 3rem !important;
			font-size: 1rem !important;
			font-weight: 600 !important;
			color: #000000 !important;
			line-height: 1.5 !important;
			padding: 0.28rem 0.45rem 0.28rem 0.55rem !important;
		}
		.fd-hero-marquee--v4 .fd-hero-marquee__badge {
			flex: 0 0 auto !important;
			align-self: stretch !important;
			display: flex !important;
			align-items: center !important;
			justify-content: center !important;
			background: #FF0000 !important;
			color: #ffffff !important;
			font-size: 1rem !important;
			font-weight: 600 !important;
			line-height: 1.5 !important;
			text-align: center !important;
			white-space: nowrap !important;
			clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%) !important;
			margin-left: -0.25rem !important;
			padding: 0.15rem 0.75rem 0.15rem 1.15rem !important;
			position: relative !important;
			z-index: 2 !important;
			max-width: 42vw !important;
			box-sizing: border-box !important;
		}
		@media (min-width: 640px) {
			.fd-hero-marquee--v4 .fd-hero-marquee__badge {
				max-width: 12rem !important;
				padding-left: 1.35rem !important;
				padding-right: 1rem !important;
			}
		}
		@keyframes fdMarqueeK2026 {
			0% { transform: translateX(0); }
			100% { transform: translateX(-50%); }
		}
		.fd-hero-marquee--v4 .fd-sr-only {
			position: absolute !important;
			width: 1px !important;
			height: 1px !important;
			padding: 0 !important;
			margin: -1px !important;
			overflow: hidden !important;
			clip: rect(0, 0, 0, 0) !important;
			white-space: nowrap !important;
			border: 0 !important;
		}
	</style>
	<div class="fd-hero-marquee__row">
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
		<div class="fd-hero-marquee__badge"><?php echo esc_html__( 'Vacation Notice', 'freshdew-medical' ); ?></div>
	</div>
	<span class="fd-sr-only"><?php echo esc_html( $fd_marquee_text ); ?></span>
</div>
