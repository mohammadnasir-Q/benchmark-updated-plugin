<?php

/**
 * Plugin Name: FluentCRM - Field Updated Trigger + Benchmark
 * Description: Adds a FluentCRM custom trigger and benchmark for when a custom field is updated.
 * Version: 1.1.0
 * Author: Bilal Altaf
 * Author URI: mailto:altafbilal649@gmail.com
 */

/**
 * **********************************************************************
 * Developed by Bilal Altaf
 * Email: altafbilal649@gmail.com
 * WhatsApp: +92 313 2167944
 *
 * This plugin adds a custom Trigger and Benchmark to FluentCRM that fires
 * when a specific contact field is updated.
 *
 * All credit belongs to Bilal Altaf.
 * **********************************************************************
 */

// deny direct access.
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Bootstrap the trigger part of the plugin.
 *
 * @since 1.0.0
 */
function benchmark_field_updated_trigger_boot() {
	include_once __DIR__ . '/class-field-updated-trigger.php';
	include_once __DIR__ . '/class-contact-updated-trigger.php';
}
add_action( 'fluentcrm_loaded', 'benchmark_field_updated_trigger_boot' );

/**
 * Bootstrap the benchmark part of the plugin.
 */
function benchmark_field_updated_bm_boot() {
	include_once __DIR__ . '/fluentcrm_contact_custom_data_updated_bm.php';
}
add_action( 'fluentcrm_addons_loaded', 'benchmark_field_updated_bm_boot' );
