<?php
/**
 * Vacation notice marquee — hero top strip (techxos-style: navy bar, white track, badge right).
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
?>
<div class="fd-hero-marquee" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>">
	<style>
		.hero-section--marquee .fd-hero-marquee {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			width: 100%;
			max-width: 100%;
			z-index: 30;
			box-sizing: border-box;
			background: #00468D;
			overflow: hidden;
			padding: 0.2rem 0;
		}
		/* Mobile: ml 10vw, mr 0. sm+: ml 40vw, mr 10vw (matches Tailwind sm = 640px). */
		.fd-hero-marquee__row {
			display: flex;
			flex-direction: row;
			align-items: stretch;
			width: auto;
			max-width: none;
			min-height: 1.65rem;
			margin-left: 10vw;
			margin-right: 0;
			gap: 0;
		}
		@media (min-width: 640px) {
			.fd-hero-marquee__row {
				margin-left: 40vw;
				margin-right: 10vw;
				min-height: 1.75rem;
			}
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
		}
		.fd-hero-marquee__track {
			display: inline-flex;
			white-space: nowrap;
			will-change: transform;
			/* Same duration at all breakpoints so scroll matches desktop feel (content width is intrinsic). */
			animation: fd-marquee-scroll 52s linear infinite;
			align-items: center;
			transform: translateZ(0);
		}
		.fd-hero-marquee__track span {
			display: inline-block;
			margin-right: 3.25rem;
			font-weight: 700;
			color: #000;
			font-size: clamp(0.82rem, 2.85vw, 1.05rem);
			line-height: 1.3;
			padding: 0.2rem 0.45rem 0.2rem 0.55rem;
		}
		@media (min-width: 640px) {
			.fd-hero-marquee__track span {
				font-size: clamp(0.9rem, 1.15vw, 1.08rem);
			}
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
			font-size: clamp(0.78rem, 2.5vw, 0.98rem);
			padding: 0.2rem 0.75rem 0.2rem 1.15rem;
			line-height: 1.25;
			text-align: center;
			clip-path: polygon(16% 0, 100% 0, 100% 100%, 0% 100%);
			max-width: 42vw;
			position: relative;
			/* Overlap white track so blue never shows in the seam */
			margin-left: -0.65rem;
			z-index: 2;
		}
		@media (min-width: 640px) {
			.fd-hero-marquee__badge {
				max-width: 11.5rem;
				padding-left: 1.35rem;
				padding-right: 0.9rem;
				margin-left: -0.7rem;
				font-size: clamp(0.85rem, 0.95vw, 1rem);
			}
		}
		@media (prefers-reduced-motion: reduce) {
			.fd-hero-marquee__track {
				animation: none;
				flex-wrap: wrap;
				white-space: normal;
				justify-content: flex-start;
				padding: 0.25rem 0.45rem;
			}
			.fd-hero-marquee__track span {
				margin-right: 0;
				white-space: normal;
			}
			.fd-hero-marquee__track span:not(:first-child) {
				display: none;
			}
		}
		@keyframes fd-marquee-scroll {
			0% { transform: translate3d(0, 0, 0); }
			100% { transform: translate3d(-50%, 0, 0); }
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
