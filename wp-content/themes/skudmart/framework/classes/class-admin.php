<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

class Skudmart_Admin {

    public function __construct(){

        add_action( 'init', array( $this, 'load_config'), 10);

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts') );
        add_action( 'customize_register', array( $this, 'override_customize_control') );

        add_action( 'wp_ajax_skudmart_core_action', array( $this, 'ajax_action' ) );
        add_action( 'widgets_init', array( $this, 'init_dynamic_sidebar' ) );

        new Skudmart_MegaMenu_Init();
    }

    public function load_config(){
        if(class_exists('LASF')) {
            require_once Skudmart_Theme_Class::$template_dir_path . '/framework/configs/options.php';
            require_once Skudmart_Theme_Class::$template_dir_path . '/framework/configs/metaboxes.php';
        }
    }


    public function ajax_action(){

        check_ajax_referer( 'admin_load_nonce', 'admin_load_nonce' );

        $router = isset($_REQUEST['router']) ? sanitize_text_field($_REQUEST['router']) : '';

        switch ($router){

            case 'add_sidebar':
                $this->ajax_add_sidebar();
                break;

            case 'remove_sidebar':
                $this->ajax_remove_sidebar();
                break;

            default:
                // does not allow to do anything on here !!!!!
        }

        wp_die();

    }

    private function ajax_add_sidebar(){
        if ( current_user_can( 'manage_options' ) ) {
            $theme_widgets = get_theme_mod( 'skudmart_widgets' );
            $number = $theme_widgets ? intval( $theme_widgets['number'] ) + 1 : 1;
            $widget_area_name = sanitize_text_field( $_POST['widget_area_name'] );
            $theme_widgets['areas']['skudmart_widget_area_' . $number] = $widget_area_name;
            $theme_widgets['number'] = $number;

            set_theme_mod( 'skudmart_widgets', $theme_widgets );

            wp_send_json_success( array(
                'message' => sprintf(__( '<strong>%1$s</strong> widget area has been created. You can create more areas, once you finish update the page to see all the areas.', 'skudmart' ), esc_html( $widget_area_name ))
            ) );
        }
    }

    private function ajax_remove_sidebar(){
        if ( current_user_can( 'manage_options' ) ) {
            $theme_widgets = get_theme_mod( 'skudmart_widgets' );

            $widget_area_name = sanitize_text_field( $_POST['widget_area_name'] );

            unset( $theme_widgets['areas'][ $widget_area_name ] );

            set_theme_mod( 'skudmart_widgets', $theme_widgets );

            wp_send_json_success( array(
                'message' => sprintf(__( '<strong>%1$s</strong> widget area has been deleted.', 'skudmart' ), esc_html( $widget_area_name )),
                'sidebar_id' => esc_html($widget_area_name)
            ) );
        }
    }

    public function init_dynamic_sidebar(){

        $theme_widgets = get_theme_mod( 'skudmart_widgets' );
        if ( !empty($theme_widgets['areas']) ) {

            $heading = 'h4';
            $heading = apply_filters( 'skudmart/filter/sidebar_heading', $heading );

            foreach ( $theme_widgets['areas'] as $id => $name ) {
                register_sidebar(array(
                    'name'          => sanitize_text_field( $name ),
                    'id'            => sanitize_text_field( $id ),
                    'before_widget' => '<div id="%1$s" class="widget sidebar-box %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'	=> '<'. $heading .' class="widget-title"><span>',
                    'after_title'	=> '</span></'. $heading .'>',
                ));
            }
        }
    }

    public function admin_scripts( $hook ){
        $ext = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
        wp_enqueue_style('skudmart-admin-css', get_theme_file_uri( '/assets/css/admin'.$ext.'.css' ));
        wp_enqueue_script('skudmart-admin-theme', get_theme_file_uri( '/assets/js/admin'.$ext.'.js' ), array( 'jquery'), false, true );

        if(!class_exists('LASF')) {
            wp_enqueue_style( 'skudmart-fonts', Skudmart_Theme_Class::enqueue_google_fonts_url() , array(), null );
        }

        $body_font_family = skudmart_get_option('body_font_family');
        if(!empty($body_font_family['font-family'])){
            wp_add_inline_style('skudmart-admin-css', '.block-editor .editor-styles-wrapper .editor-block-list__block{ font-family: "'. esc_attr($body_font_family['font-family']) .'" }');
        }

        if ( $hook === 'widgets.php' ) {
            wp_localize_script( 'skudmart-admin-theme', 'skudmart_sidebar_options', array(
                'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                'admin_load_nonce' => wp_create_nonce( 'admin_load_nonce' ),
                'widget_info'   => sprintf( '<div id="la_pb_widget_area_create"><p>%1$s.</p><p><label>%2$s <input id="la_pb_new_widget_area_name" value="" /></label><button class="button button-primary la_pb_create_widget_area">%3$s</button></p><p class="la_pb_widget_area_result"></p></div>',
                    esc_html__( 'Here you can create new widget areas for use in the Sidebar module', 'skudmart' ),
                    esc_html__( 'Widget Name', 'skudmart' ),
                    esc_html__( 'Create', 'skudmart' )
                ),
                'confirm_delete_string' => esc_html__( 'Are you sure?', 'skudmart' ),
                'delete_string' => esc_html__( 'Delete', 'skudmart' )
            ) );
        }
    }


    public function override_customize_control( $wp_customize ) {
        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('header_image');
        $wp_customize->remove_section('background_image');
    }
    

}