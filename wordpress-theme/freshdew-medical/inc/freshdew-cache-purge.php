<?php
/**
 * Full-page cache purging + asset version tokens (marquee / hero / CSS busting).
 *
 * @package FreshDewMedical
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Latest mtime among theme files that affect front-page look (CSS, hero, marquee).
 *
 * @return int
 */
function freshdew_theme_critical_files_mtime() {
	$files = array(
		get_stylesheet_directory() . '/style.css',
		get_template_directory() . '/assets/css/main.css',
		get_template_directory() . '/inc/hero-news-marquee.php',
		get_template_directory() . '/inc/hero-important-notice.php',
		get_template_directory() . '/page-home.php',
		get_template_directory() . '/functions.php',
	);
	$max = 0;
	foreach ( $files as $path ) {
		if ( is_readable( $path ) ) {
			$max = max( $max, (int) filemtime( $path ) );
		}
	}
	return $max;
}

/**
 * Version string for wp_enqueue_* — busts browser cache when theme files change.
 *
 * @return string
 */
function freshdew_get_assets_version() {
	$deploy_file = get_template_directory() . '/assets/deploy-version.txt';
	$base        = '';
	if ( is_readable( $deploy_file ) ) {
		$base = trim( (string) file_get_contents( $deploy_file ) );
	}
	if ( $base === '' ) {
		$base = wp_get_theme()->get( 'Version' );
	}
	$touch = freshdew_theme_critical_files_mtime();
	return $base . '.' . $touch;
}

/**
 * Build token for marquee markup (debugging + cache plugins that vary by body hash).
 *
 * @return string
 */
function freshdew_hero_marquee_build() {
	$f = get_template_directory() . '/inc/hero-news-marquee.php';
	return is_readable( $f ) ? (string) filemtime( $f ) : '0';
}

/**
 * Purge common WordPress full-page / optimization caches (LiteSpeed, WP Rocket, W3TC, etc.).
 * Safe no-ops when a plugin is not active.
 *
 * @return void
 */
function freshdew_purge_all_page_caches() {
	// LiteSpeed Cache
	do_action( 'litespeed_purge_all' );
	do_action( 'litespeed_purge_all_cssjs' );
	do_action( 'litespeed_purge_all_object' );
	if ( class_exists( 'LiteSpeed_Cache_API' ) && method_exists( 'LiteSpeed_Cache_API', 'purge_all' ) ) {
		LiteSpeed_Cache_API::purge_all();
	}

	// WP Rocket
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
	if ( function_exists( 'rocket_clean_minify' ) ) {
		rocket_clean_minify();
	}

	// W3 Total Cache
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
	}

	// SiteGround Optimizer
	if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
		sg_cachepress_purge_cache();
	}

	// WP Fastest Cache
	if ( isset( $GLOBALS['wp_fastest_cache'] ) && is_object( $GLOBALS['wp_fastest_cache'] ) && method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' ) ) {
		$GLOBALS['wp_fastest_cache']->deleteCache( true );
	}

	// Cache Enabler (multiple versions)
	do_action( 'cache_enabler_clear_complete_cache' );
	if ( class_exists( 'Cache_Enabler' ) && method_exists( 'Cache_Enabler', 'clear_complete_cache' ) ) {
		Cache_Enabler::clear_complete_cache();
	}

	// WP Super Cache
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}

	// Hummingbird
	do_action( 'wphb_clear_page_cache' );

	// Autoptimize
	if ( function_exists( 'autoptimize_clear_cache' ) ) {
		autoptimize_clear_cache();
	}

	// Official Cloudflare plugin
	if ( function_exists( 'cloudflare_purge_cache' ) ) {
		cloudflare_purge_cache();
	}

	// WP Optimize
	if ( function_exists( 'wpo_cache_flush' ) ) {
		wpo_cache_flush();
	}

	/**
	 * After FreshDew runs its purge pass (e.g. custom CDN integration).
	 */
	do_action( 'freshdew_after_purge_page_caches' );

	if ( function_exists( 'wp_cache_flush' ) ) {
		wp_cache_flush();
	}
}

/**
 * When deploy-version.txt changes, purge everything (extends prior LiteSpeed-only behavior).
 *
 * @return void
 */
function freshdew_maybe_purge_cache_on_deploy() {
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return;
	}

	$deploy_version_file = get_template_directory() . '/assets/deploy-version.txt';
	if ( ! is_readable( $deploy_version_file ) ) {
		return;
	}

	$deploy_version = trim( (string) file_get_contents( $deploy_version_file ) );
	if ( $deploy_version === '' ) {
		return;
	}

	$last_version = (string) get_option( 'freshdew_deploy_version', '' );
	if ( hash_equals( $last_version, $deploy_version ) ) {
		return;
	}

	update_option( 'freshdew_deploy_version', $deploy_version, false );
	freshdew_purge_all_page_caches();
}
add_action( 'init', 'freshdew_maybe_purge_cache_on_deploy', 20 );

/**
 * After theme switch or theme update, purge caches so new templates/CSS apply.
 *
 * @return void
 */
function freshdew_purge_caches_after_theme_change() {
	freshdew_purge_all_page_caches();
	update_option( 'freshdew_theme_files_mtime_stored', freshdew_theme_critical_files_mtime(), false );
}
add_action( 'after_switch_theme', 'freshdew_purge_caches_after_theme_change' );

/**
 * @param WP_Upgrader $upgrader Upgrader instance.
 * @param array       $options  Hook payload.
 */
function freshdew_purge_after_theme_upgrade( $upgrader, $options ) {
	if ( ! isset( $options['type'], $options['action'] ) || $options['type'] !== 'theme' || $options['action'] !== 'update' ) {
		return;
	}
	if ( empty( $options['themes'] ) || ! is_array( $options['themes'] ) ) {
		return;
	}
	$slug = get_template();
	if ( in_array( $slug, $options['themes'], true ) ) {
		freshdew_purge_caches_after_theme_change();
	}
}
add_action( 'upgrader_process_complete', 'freshdew_purge_after_theme_upgrade', 20, 2 );

/**
 * If critical theme files change (e.g. SFTP edit), purge once on next wp-admin load.
 *
 * @return void
 */
function freshdew_maybe_purge_on_theme_file_mtime() {
	if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$current = freshdew_theme_critical_files_mtime();
	$stored  = (int) get_option( 'freshdew_theme_files_mtime_stored', 0 );
	if ( $current <= $stored ) {
		return;
	}

	update_option( 'freshdew_theme_files_mtime_stored', $current, false );
	freshdew_purge_all_page_caches();
}
add_action( 'admin_init', 'freshdew_maybe_purge_on_theme_file_mtime', 5 );
