<?php
/**
 * Vacation notice marquee — techxos-style: inset bar, white track + dark badge, no seam gap.
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
?>
<div class="fd-hero-marquee" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>">
	<style>
		/* Inset from viewport: mobile ml-10vw mr-0; sm+ ml-40vw mr-10vw */
		.hero-section--marquee .fd-hero-marquee {
			position: absolute;
			top: 0;
			left: 10vw;
			right: 0;
			width: auto;
			z-index: 30;
			box-sizing: border-box;
			background: #00468D;
			overflow: visible;
			padding: 0.2rem 0;
		}
		@media (min-width: 640px) {
			.hero-section--marquee .fd-hero-marquee {
				left: 40vw;
				right: 10vw;
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
			/* Desktop / sm+: moderate speed */
			animation: fd-marquee-scroll 68s linear infinite;
			backface-visibility: hidden;
		}
		/* Mobile: same perceived motion as desktop (shorter duration = visibly moving) */
		@media (max-width: 639.98px) {
			.fd-hero-marquee__track {
				animation-duration: 52s;
			}
		}
		.fd-hero-marquee__track span {
			display: inline-block;
			margin-right: 3rem;
			font-weight: 700;
			color: #000;
			font-size: clamp(0.8125rem, 3.1vw, 1.0625rem);
			line-height: 1.3;
			padding: 0.28rem 0.45rem 0.28rem 0.55rem;
		}
		.fd-hero-marquee__badge {
			flex: 0 0 auto;
			align-self: stretch;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #161206;
			color: #fff;
			font-weight: 700;
			font-size: clamp(0.75rem, 2.9vw, 0.9375rem);
			line-height: 1.15;
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
		/* Slower scroll instead of none — avoids "frozen" ticker when OS Reduce Motion is on (common on phones). */
		@media (prefers-reduced-motion: reduce) {
			.fd-hero-marquee__track {
				animation-duration: 110s;
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
