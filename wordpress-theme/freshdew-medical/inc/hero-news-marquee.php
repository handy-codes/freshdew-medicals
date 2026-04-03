<?php
/**
 * Vacation notice marquee — techxos-style: inset bar, white track + badge, no seam gap.
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
?>
<div class="fd-hero-marquee" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>">
	<style>
		/* Inset: mobile ml-4vw mr-0 (+ mb); 640px+ ml-20vw mr-5vw */
		.hero-section--marquee .fd-hero-marquee {
			position: absolute;
			top: 0;
			left: 4vw;
			right: 0;
			width: auto;
			z-index: 30;
			box-sizing: border-box;
			background: #00468D;
			overflow: visible;
			padding: 0.2rem 0;
		}
		@media (max-width: 639.98px) {
			.hero-section--marquee .fd-hero-marquee {
				margin-bottom: 0.65rem;
			}
		}
		@media (min-width: 640px) {
			.hero-section--marquee .fd-hero-marquee {
				left: 20vw;
				right: 5vw;
			}
		}
		.fd-hero-marquee__row {
			display: flex;
			flex-direction: row;
			align-items: stretch;
			width: 100%;
			min-height: 1.75rem;
			gap: 0;
			/* Kill subpixel gaps between flex children */
			isolation: isolate;
		}
		.fd-hero-marquee__track-outer {
			flex: 1 1 auto;
			min-width: 0;
			overflow: hidden;
			display: flex;
			align-items: center;
			background: #fff;
			margin: 0;
			padding: 0;
			border: none;
			border-radius: 0;
			/* Pull badge inward so white meets diagonal; overlap removes blue seam */
			margin-right: -0.75rem;
			position: relative;
			z-index: 1;
		}
		.fd-hero-marquee__track {
			display: inline-flex;
			white-space: nowrap;
			will-change: transform;
			align-items: center;
			/* Same duration on all viewports (68s) */
			animation: fd-marquee-scroll 68s linear infinite;
			backface-visibility: hidden;
		}
		/* Match .site-header .main-navigation .nav-menu > li > a + .main-navigation a */
		.fd-hero-marquee__track span,
		.fd-hero-marquee__badge {
			font-family: inherit;
			font-size: 1rem;
			font-weight: 600;
			line-height: 1.5;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}
		.fd-hero-marquee__track span {
			display: inline-block;
			margin-right: 3rem;
			padding: 0.28rem 0.45rem 0.28rem 0.55rem;
			color: #000000;
		}
		.fd-hero-marquee__badge {
			flex: 0 0 auto;
			align-self: stretch;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #FF0000;
			color: #ffffff;
			text-align: center;
			white-space: nowrap;
			clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);
			margin-left: -0.125rem;
			padding: 0.15rem 0.75rem 0.15rem 1.15rem;
			position: relative;
			z-index: 2;
			max-width: 42vw;
			box-sizing: border-box;
		}
		@media (min-width: 640px) {
			.fd-hero-marquee__badge {
				max-width: 12rem;
				padding-left: 1.35rem;
				padding-right: 1rem;
			}
		}
		@keyframes fd-marquee-scroll {
			0% { transform: translateX(0); }
			100% { transform: translateX(-50%); }
		}
		.fd-hero-marquee .fd-sr-only {
			position: absolute;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			white-space: nowrap;
			border: 0;
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
