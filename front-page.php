<?php
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */



/**
*   Initial front page overrides
*
*/

beans_replace_attribute( 'beans_post_title', 'class', 'uk-article-title', 'uk-article-title hide' );
beans_remove_markup( 'beans_main_grid' );
beans_remove_markup('beans_primary');
beans_remove_markup('beans_content');
beans_remove_markup('beans_post');
beans_remove_markup('beans_post_header');
beans_remove_markup('beans_post_body');


/**
*   Modify site header text output for Front page only
*
*/

add_action( 'beans_site_title_text_output', 'front_page_site_title' );

function front_page_site_title() {

    return 'First Nations Schools Association';

}

beans_remove_action( 'beans_site_title_tag' );

/**
*   Append the Hero section
*
*/

add_action( 'beans_main_append_markup', 'fnsa_add_hero' );

function fnsa_add_hero() {
    $hero = get_field('hero_section');
    $text_color = $hero['text_colour'];
    if( $hero ) { ?>
         <div class="uk-cover-background custom-bg" style="background-image: url(<?php echo $hero['background_image']['url'] ?> ">
            <div class="uk-container uk-container-center">
                <div class="hero-content uk-flex uk-flex-center uk-flex-middle fnsa-hero-copy text-light uk-text-center ">
                    <?php echo $hero['heading'] ?>
                    <div class="front-pg-button-group">
                    <?php if( !is_user_logged_in()){ ?>
                        <a class="button register" href="<?php echo get_permalink( get_page_by_path( 'register' ) ) ?>">SIGNUP</a>
                        <a class="button login" href="<?php echo wp_login_url( $redirect ); ?>">LOGIN</a>
                    <?php }else { ?>
                        <a class="button register" href="<?php echo bp_loggedin_user_domain() ?>">Go to Profile</a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}


/**
*   Append the Main Content section
*
*/

add_action( 'beans_main_append_markup', 'fnsa_add_content_main' );

function fnsa_add_content_main() {

    echo beans_open_markup('fnsa_container', 'div', array('class' => 'uk-container uk-container-center'));
        echo beans_open_markup('fnsa_block', 'div', array('class' => 'uk-block uk-block-large uk-block-muted'));
            ?>
            <div class="fnsa-main-header uk-text-center uk-margin-large-bottom">
                <div class="fnsa-main-heading"><?php the_field('heading'); ?></div>
                <i class="uk-text-small">-<?php the_field('heading_credit'); ?></i>
            </div>
            <?php

            echo beans_open_markup( 'fnsa_main_content', 'div',  array( 'class' => 'uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1' ) );
                if( have_rows('information') ):
                    while ( have_rows('information') ) : the_row();
                        ?>
                            <div class="fnsa-card uk-panel-box">
                                <?php the_sub_field('copy'); ?>
                            </div>
                        <?php
                    endwhile;
                    else:
                endif;
            echo beans_close_markup( 'your_markup_id', 'div' );
        echo beans_close_markup('fnsa_block', 'div');
    echo beans_close_markup('fnsa_container', 'div');
}


/**
*   Append the Call to Action section ( similar to hero section )
*
*/

add_action( 'beans_main_append_markup', 'fnsa_add_action' );

function fnsa_add_action() {
    $action = get_field('call_to_action_section');
    $text_color = $action['text_colour'];

    if( $action ) { ?>
        <div class="uk-cover-background custom-bg" style="background-image: url(<?php echo $action['background_image']['url'] ?> ">
            <div class="uk-container uk-container-center">
                <div class="hero-content-action uk-flex uk-flex-center uk-flex-middle fnsa-hero-copy text-light uk-text-center ">
                <?php echo $action['heading'] ?>
                    <div class="front-pg-button-group">
                    <?php if( !is_user_logged_in()){ ?>
                        <a class="button register" href="<?php echo get_permalink( get_page_by_path( 'register' ) ) ?>">SIGNUP</a>
                        <a class="button login" href="<?php echo wp_login_url( $redirect ); ?>">LOGIN</a>
                    <?php }else { ?>
                        <a class="button register" href="<?php echo bp_loggedin_user_domain() ?>">Go to Profile</a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}

beans_load_document();

