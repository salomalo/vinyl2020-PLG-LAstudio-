<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: group
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'LASF_Field_group' ) ) {
  class LASF_Field_group extends LASF_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'max'                    => 0,
        'min'                    => 0,
        'fields'                 => array(),
        'button_title'           => esc_html__( 'Add New', 'lastudio' ),
        'accordion_title_prefix' => '',
        'accordion_title_number' => false,
        'accordion_title_auto'   => true,
      ) );

      $title_prefix = ( ! empty( $args['accordion_title_prefix'] ) ) ? $args['accordion_title_prefix'] : '';
      $title_number = ( ! empty( $args['accordion_title_number'] ) ) ? true : false;
      $title_auto   = ( ! empty( $args['accordion_title_auto'] ) ) ? true : false;

      if( ! empty( $this->parent ) && preg_match( '/'. preg_quote( '['. $this->field['id'] .']' ) .'/', $this->parent ) ) {

        echo '<div class="lasf-notice lasf-notice-danger">'. esc_html__( 'Error: Nested field id can not be same with another nested field id.', 'lastudio' ) .'</div>';

      } else {

        echo $this->field_before();

        echo '<div class="lasf-cloneable-item lasf-cloneable-hidden">';

          echo '<div class="lasf-cloneable-helper">';
          echo '<i class="lasf-cloneable-sort dashicons dashicons-move"></i>';
          echo '<i class="lasf-cloneable-clone dashicons dashicons-admin-page"></i>';
          echo '<i class="lasf-cloneable-remove lasf-confirm dashicons dashicons-no-alt" data-confirm="'. esc_html__( 'Are you sure to delete this item?', 'lastudio' ) .'"></i>';
          echo '</div>';

          echo '<h4 class="lasf-cloneable-title">';
          echo '<span class="lasf-cloneable-text">';
          echo ( $title_number ) ? '<span class="lasf-cloneable-title-number"></span>' : '';
          echo ( $title_prefix ) ? '<span class="lasf-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
          echo ( $title_auto ) ? '<span class="lasf-cloneable-value"><span class="lasf-cloneable-placeholder"></span></span>' : '';
          echo '</span>';
          echo '</h4>';

          echo '<div class="lasf-cloneable-content">';
          foreach ( $this->field['fields'] as $field ) {

            $field_parent  = $this->parent .'['. $this->field['id'] .']';
            $field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';

            LASF::field( $field, $field_default, '_nonce', 'field/group', $field_parent );

          }
          echo '</div>';

        echo '</div>';

        echo '<div class="lasf-cloneable-wrapper lasf-data-wrapper" data-title-number="'. $title_number .'" data-unique-id="'. $this->unique .'" data-field-id="['. $this->field['id'] .']" data-max="'. $args['max'] .'" data-min="'. $args['min'] .'">';

        if( ! empty( $this->value ) ) {

          $num = 0;

          foreach ( $this->value as $value ) {

            $first_id    = ( isset( $this->field['fields'][0]['id'] ) ) ? $this->field['fields'][0]['id'] : '';
            $first_value = ( isset( $value[$first_id] ) ) ? $value[$first_id] : '';

            echo '<div class="lasf-cloneable-item">';

              echo '<div class="lasf-cloneable-helper">';
              echo '<i class="lasf-cloneable-sort dashicons dashicons-move"></i>';
              echo '<i class="lasf-cloneable-clone dashicons dashicons-admin-page"></i>';
              echo '<i class="lasf-cloneable-remove lasf-confirm dashicons dashicons-no-alt" data-confirm="'. esc_html__( 'Are you sure to delete this item?', 'lastudio' ) .'"></i>';
              echo '</div>';

              echo '<h4 class="lasf-cloneable-title">';
              echo '<span class="lasf-cloneable-text">';
              echo ( $title_number ) ? '<span class="lasf-cloneable-title-number">'. ( $num+1 ) .'.</span>' : '';
              echo ( $title_prefix ) ? '<span class="lasf-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
              echo ( $title_auto ) ? '<span class="lasf-cloneable-value">' . $first_value .'</span>' : '';
              echo '</span>';
              echo '</h4>';

              echo '<div class="lasf-cloneable-content">';

              foreach ( $this->field['fields'] as $field ) {

                $field_parent  = $this->parent .'['. $this->field['id'] .']';
                $field_unique = ( ! empty( $this->unique ) ) ? $this->unique .'['. $this->field['id'] .']['. $num .']' : $this->field['id'] .'['. $num .']';
                $field_value  = ( isset( $field['id'] ) && isset( $value[$field['id']] ) ) ? $value[$field['id']] : '';

                LASF::field( $field, $field_value, $field_unique, 'field/group', $field_parent );

              }

              echo '</div>';

            echo '</div>';

            $num++;

          }

        }

        echo '</div>';

        echo '<div class="lasf-cloneable-alert lasf-cloneable-max">'. esc_html__( 'You can not add more than', 'lastudio' ) .' '. $args['max'] .'</div>';
        echo '<div class="lasf-cloneable-alert lasf-cloneable-min">'. esc_html__( 'You can not remove less than', 'lastudio' ) .' '. $args['min'] .'</div>';

        echo '<a href="#" class="button button-primary lasf-cloneable-add">'. $args['button_title'] .'</a>';

        echo $this->field_after();

      }

    }

    public function enqueue() {

      if( ! wp_script_is( 'jquery-ui-accordion' ) ) {
        wp_enqueue_script( 'jquery-ui-accordion' );
      }

      if( ! wp_script_is( 'jquery-ui-sortable' ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
      }

    }

  }
}
