<?php
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

function fluentcrm_field_updated_bm_boot() {
    include_once __DIR__ . '/LinkClickingBenchmark.php';
}
add_action( 'fluentcrm_addons_loaded', 'fluentcrm_field_updated_bm_boot' );

