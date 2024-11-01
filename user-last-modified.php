<?php

/*
Plugin Name: User Last Modified
Plugin URI: https://wordpress.org/plugins/user-last-modified/
Description: Adds a last modified timestamp to user profiles
Version: 1.0.0
Author: Glen Scott
Author URI: https://www.glenscott.co.uk
Text Domain: user-last-modified
*/

function ulm_update_profile_modified( $user_id ) {
	update_user_meta( $user_id, 'profile_last_modified', current_time( 'mysql' ) );
}

add_action( 'profile_update', 'ulm_update_profile_modified' );

function ulm_add_extra_user_column( $columns ) {
	return array_merge( $columns,
	array( 'last-modified' => __( 'Last Modified' ) ) );
}

add_action( 'manage_users_columns', 'ulm_add_extra_user_column' );

function ulm_manage_users_custom_column( $custom_column, $column_name, $user_id ) {
	if ( 'last-modified' == $column_name ) {
		$user_info = get_userdata( $user_id );
		$profile_last_modified = $user_info->profile_last_modified;
		$custom_column = "\t{$profile_last_modified}\n";
	}
	return $custom_column;
}

add_action( 'manage_users_custom_column', 'ulm_manage_users_custom_column', 10, 3 );
