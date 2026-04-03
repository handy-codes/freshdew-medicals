<?php
/**
 * Vacation notice marquee — full width at top of hero (techxos-style: navy bar, white track, red badge right).
 *
 * @package FreshDewMedical
 */

$fd_marquee_text = 'This is to notify all patients that Dr.Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.';
?>
<div class="fd-hero-marquee" role="region" aria-label="<?php echo esc_attr__( 'Vacation notice', 'freshdew-medical' ); ?>">
	<style>
		/* Full-bleed bar at top of hero; flush to viewport edges when hero is full width */
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
			padding: 0.35rem 0;
		}
		.fd-hero-marquee__row {
			display: flex;
			flex-direction: row;
			align-items: stretch;
			width: 100%;
			min-height: 2.35rem;
			gap: 0;
		}
		.fd-hero-marquee__track-outer {
			flex: 1 1 auto;
			min-width: 0;
			overflow: hidden;
			display: flex;
			align-items: center;
			background: #fff;
			margin: 0;
			border: none;
			border-radius: 0;
		}
		.fd-hero-marquee__track {
			display: inline-flex;
			white-space: nowrap;
			will-change: transform;
			animation: fd-marquee-scroll 75s linear infinite;
			align-items: center;
		}
		.fd-hero-marquee__track span {
			display: inline-block;
			margin-right: 3.5rem;
			font-weight: 700;
			color: #000;
			font-size: clamp(0.7rem, 2.6vw, 0.9rem);
			line-height: 1.35;
			padding: 0.4rem 0.5rem 0.4rem 0.65rem;
		}
		.fd-hero-marquee__badge {
			flex: 0 0 auto;
			align-self: stretch;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #FF0000;
			color: #fff;
			font-weight: 700;
			font-size: clamp(0.65rem, 2.4vw, 0.8125rem);
			padding: 0.2rem 0.85rem 0.2rem 1.35rem;
			line-height: 1.2;
			text-align: center;
			clip-path: polygon(14% 0, 100% 0, 100% 100%, 0% 100%);
			max-width: 38vw;
		}
		@media (min-width: 768px) {
			.fd-hero-marquee__badge {
				max-width: 11rem;
				padding-left: 1.5rem;
				padding-right: 1rem;
			}
		}
		@media (prefers-reduced-motion: reduce) {
			.fd-hero-marquee__track {
				animation: none;
				flex-wrap: wrap;
				white-space: normal;
				justify-content: flex-start;
				padding: 0.35rem 0.5rem;
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
