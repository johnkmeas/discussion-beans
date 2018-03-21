<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

/*
 * Remove this action and callback function if you do not whish to use LESS to style your site or overwrite UIkit variables.
 * If you are using LESS, make sure to enable development mode via the Admin->Appearance->Settings option. LESS will then be processed on the fly.
 */
add_action( 'beans_uikit_enqueue_scripts', 'beans_child_enqueue_uikit_assets' );

function beans_child_enqueue_uikit_assets() {
    $uri = get_stylesheet_directory_uri();

    beans_compiler_add_fragment( 'uikit', array(
        "{$uri}/style.less",
        "{$uri}/lib/assets/less/variables.less",
        "{$uri}/lib/assets/less/base.less",
        "{$uri}/lib/assets/less/nav.less",
        "{$uri}/lib/assets/less/buttons.less",
        "{$uri}/lib/assets/less/forums.less",
        "{$uri}/lib/assets/less/front-page.less",
        "{$uri}/lib/assets/less/mobile.less",
    ), 'less' );

}

add_action( 'wp_enqueue_scripts', 'fnsa_load_custom_scripts' );

function fnsa_load_custom_scripts() {
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/lib/assets/js/scripts.js', array(), '1.0.0', false );
}
// function fnsa_load_custom_scripts() {
//     $uri = get_stylesheet_directory_uri();

//     beans_compiler_add_fragment( 'js_compiler_id', array(
//         "{$uri}/lib/assets/js/scripts.js",
//     ),'js' );

// }
/*
 * Load Custom Login styles
 */

add_action( 'login_enqueue_scripts', 'load_custom_wp_admin_style' );

function load_custom_wp_admin_style() {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/lib/assets/less/admin.css');

}


/****************************
 * Base style modifications *
 ****************************
 */

beans_add_attribute( 'beans_main', 'class', 'fnsa-margin-large-top' );

// beans_add_attribute( 'beans_main_grid', 'class', 'uk-margin-large-top' );
beans_add_attribute( 'beans_post', 'class', 'uk-padding-top-remove' );
beans_add_attribute( 'beans_fixed_wrap[_footer]', 'class', 'fnsa-footer-credit' );
beans_add_attribute( 'beans_footer_credit_left', 'class', 'text-light' );
beans_add_attribute( 'beans_footer_credit_right', 'class', 'text-light' );
beans_replace_attribute( 'beans_site_title_tag', 'class', 'uk-text-muted', 'text-light' );


/*
 * Redirect to front page if not logged in
 */

add_action( 'template_redirect', function() {

    if( !is_front_page() && !is_page('register')) {

        if (!is_user_logged_in() ) {
            wp_redirect(site_url( '/' ));
            exit();
        }

    }

});


/*
 * Custom Login message
 */

add_filter('login_message', 'custom_login_message');

function custom_login_message() {
$message = '<i class="login-small-text">Login to the</i><br><h1 class="login-title">FNSA Discussion Board</h1>';
return $message;
}


/*
 * Custom Footer Content
 */

add_action( 'beans_footer_credit_right_text_output', 'beans_child_footer_content' );

function beans_child_footer_content() { ?>
    <span class="uk-align-medium-right uk-margin-bottom-remove" data-markup-id="beans_footer_credit_right">Designed and Developed by
        <a href="https://www.meerkatstudio.ca" rel="nofollow" data-markup-id="beans_footer_credit_framework_link">John Meas</a>
    </span>
    <?php
}


/****************************************
 * Customize Buddypress/BBpress scripts *
 ****************************************
 *
 *
 */

/*
 * BBpress visual editor
 */

add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );

function bbp_enable_visual_editor( $args = array() ) {
    $args['tinymce'] = true;
    $args['teeny'] = true;
    $args['quicktags'] = false;
    return $args;
}

/*
 * Buddypress required label change to '*'
 */

add_filter( 'bp_get_the_profile_field_required_label', 'fnsa_get_the_profile_field_required_label' );

function fnsa_get_the_profile_field_required_label() {
    $retvals = '*';

    return $retvals;
}


/*
 * Reorder BuddyPress profile tabs/navigation.
 */

add_action( 'bp_setup_nav', 'buddydev_reorder_buddypress_profile_tabs', 999 );

function buddydev_reorder_buddypress_profile_tabs() {
    $nav = buddypress()->members->nav;

    // it's a map of nav items for user profile.
    // mapping component slug to their position.
    $nav_items = array(


        'groups'            => 10, // first.
        'forums'            => 20,
        'friends'           => 30,
        'messages'          => 40,
        'notifications'     => 50,
        'activity'          => 60,
        'profile'           => 70,
        'settings'          => 80,
    );

    foreach ( $nav_items as $nav_item => $position ) {
        $nav->edit_nav( array( 'position' => $position ), $nav_item );
    }
}


