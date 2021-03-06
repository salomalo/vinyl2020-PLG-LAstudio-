<?php
/**
 * Advanced carousel template
 */
$layout     = $this->get_settings_for_display( 'item_layout' );
$equal_cols = $this->get_settings_for_display( 'equal_height_cols' );
$cols_class = ( 'true' === $equal_cols ) ? ' lastudio-equal-cols' : '';

$cols_class .= ' lastudio-advance-carousel-layout-' . $layout;

?>
<div class="lastudio-carousel-wrap<?php echo $cols_class; ?>">
	<?php $this->__get_global_looped_template( esc_attr( $layout ) . '/items', 'items_list' ); ?>
</div>