<?php
/**
 * Features list item template
 */
?>
<div class="brands-list__item <?php echo lastudio_element_render_grid_classes( [
    'desktop'   => $this->__get_html( 'columns' ),
    'laptop'    => $this->__get_html( 'columns_laptop' ),
    'tablet'    => $this->__get_html( 'columns_tablet' ),
    'mobile'    => $this->__get_html( 'columns_tabletportrait' ),
    'xmobile'   => $this->__get_html( 'columns_mobile' )
] ); ?>"><?php

    $item_image = $this->__loop_item( array( 'item_image', 'url' ), '%s' );

	echo $this->__open_brand_link( 'item_url' );
	echo sprintf('<div class="brands-list__item-img-wrap"><img src="%s" alt="" class="brands-list__item-img"></div>', apply_filters('lastudio_wp_get_attachment_image_url', $item_image) );
	echo $this->__loop_item( array( 'item_name' ), '<h5 class="brands-list__item-name">%s</h5>' );
	echo $this->__loop_item( array( 'item_desc' ), '<div class="brands-list__item-desc">%s</div>' );
	echo $this->__close_brand_link( 'item_url' );
?></div>