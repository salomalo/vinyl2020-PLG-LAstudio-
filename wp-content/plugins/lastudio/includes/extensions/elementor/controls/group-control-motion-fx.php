<?php

namespace LaStudio_Element\Controls;

if (!defined('WPINC')) {
    die;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

class Group_Control_Motion_Fx extends Group_Control_Base {

	protected static $fields;

	public static function get_type() {
		return 'motion_fx';
	}

    protected function init_fields() {
        $fields = [
            'motion_fx_scrolling' => [
                'label' => __( 'Scrolling Effects', 'lastudio' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'lastudio' ),
                'label_on' => __( 'On', 'lastudio' ),
                'render_type' => 'ui',
                'frontend_available' => true,
            ],
        ];

        $this->prepare_effects( 'scrolling', $fields );

        $transform_origin_conditions = [
            'terms' => [
                [
                    'name' => 'motion_fx_scrolling',
                    'value' => 'yes',
                ],
                [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'rotateZ_effect',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'scale_effect',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ],
        ];

        $fields['transform_origin_x'] = [
            'label' => __( 'X Anchor Point', 'lastudio' ),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
            'options' => [
                'left' => [
                    'title' => __( 'Left', 'lastudio' ),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'lastudio' ),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __( 'Right', 'lastudio' ),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'conditions' => $transform_origin_conditions,
            'label_block' => false,
            'toggle' => false,
            'render_type' => 'ui',
        ];

        $fields['transform_origin_y'] = [
            'label' => __( 'Y Anchor Point', 'lastudio' ),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
            'options' => [
                'top' => [
                    'title' => __( 'Top', 'lastudio' ),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => __( 'Center', 'lastudio' ),
                    'icon' => 'eicon-v-align-middle',
                ],
                'bottom' => [
                    'title' => __( 'Bottom', 'lastudio' ),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'conditions' => $transform_origin_conditions,
            'selectors' => [
                '{{SELECTOR}}' => 'transform-origin: {{transform_origin_x.VALUE}} {{VALUE}}',
            ],
            'label_block' => false,
            'toggle' => false,
        ];

        $fields['devices'] = [
            'label' => __( 'Apply Effects On', 'lastudio' ),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => 'true',
            'default' => [ 'desktop', 'tablet', 'mobile' ],
            'options' => [
                'desktop' => __( 'Desktop', 'lastudio' ),
                'tablet' => __( 'Tablet', 'lastudio' ),
                'mobile' => __( 'Mobile', 'lastudio' ),
            ],
            'condition' => [
                'motion_fx_scrolling' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ];

        $fields['motion_fx_mouse'] = [
            'label' => __( 'Mouse Effects', 'lastudio' ),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __( 'Off', 'lastudio' ),
            'label_on' => __( 'On', 'lastudio' ),
            'separator' => 'before',
            'render_type' => 'none',
            'frontend_available' => true,
        ];

        $this->prepare_effects( 'mouse', $fields );

        return $fields;
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }

    private function get_scrolling_effects() {
        return [
            'translateY' => [
                'label' => __( 'Vertical Scroll', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            '' => __( 'Up', 'lastudio' ),
                            'negative' => __( 'Down', 'lastudio' ),
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 4,
                        ],
                        'range' => [
                            'px' => [
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                    'affectedRange' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 0,
                                'end' => 100,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
            'translateX' => [
                'label' => __( 'Horizontal Scroll', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            '' => __( 'To Left', 'lastudio' ),
                            'negative' => __( 'To Right', 'lastudio' ),
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 4,
                        ],
                        'range' => [
                            'px' => [
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                    'affectedRange' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 0,
                                'end' => 100,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
            'opacity' => [
                'label' => __( 'Transparency', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'out-in',
                        'options' => [
                            'out-in' => 'Fade In',
                            'in-out' => 'Fade Out',
                            'in-out-in' => 'Fade Out In',
                            'out-in-out' => 'Fade In Out',
                        ],
                    ],
                    'level' => [
                        'label' => __( 'Level', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 10,
                        ],
                        'range' => [
                            'px' => [
                                'min' => 1,
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                    'range' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 20,
                                'end' => 80,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
            'blur' => [
                'label' => __( 'Blur', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'out-in',
                        'options' => [
                            'out-in' => 'Fade In',
                            'in-out' => 'Fade Out',
                            'in-out-in' => 'Fade Out In',
                            'out-in-out' => 'Fade In Out',
                        ],
                    ],
                    'level' => [
                        'label' => __( 'Level', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 7,
                        ],
                        'range' => [
                            'px' => [
                                'min' => 1,
                                'max' => 15,
                            ],
                        ],
                    ],
                    'range' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 20,
                                'end' => 80,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
            'rotateZ' => [
                'label' => __( 'Rotate', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            '' => __( 'To Left', 'lastudio' ),
                            'negative' => __( 'To Right', 'lastudio' ),
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 1,
                        ],
                        'range' => [
                            'px' => [
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                    'affectedRange' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 0,
                                'end' => 100,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
            'scale' => [
                'label' => __( 'Scale', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'out-in',
                        'options' => [
                            'out-in' => 'Scale Up',
                            'in-out' => 'Scale Down',
                            'in-out-in' => 'Scale Down Up',
                            'out-in-out' => 'Scale Up Down',
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 4,
                        ],
                        'range' => [
                            'px' => [
                                'min' => -10,
                                'max' => 10,
                            ],
                        ],
                    ],
                    'range' => [
                        'label' => __( 'Viewport', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'sizes' => [
                                'start' => 20,
                                'end' => 80,
                            ],
                            'unit' => '%',
                        ],
                        'labels' => [
                            __( 'Bottom', 'lastudio' ),
                            __( 'Top', 'lastudio' ),
                        ],
                        'scales' => 1,
                        'handles' => 'range',
                    ],
                ],
            ],
        ];
    }

    private function get_mouse_effects() {
        return [
            'mouseTrack' => [
                'label' => __( 'Mouse Track', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => '',
                        'options' => [
                            '' => __( 'Opposite', 'lastudio' ),
                            'negative' => __( 'Direct', 'lastudio' ),
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 1,
                        ],
                        'range' => [
                            'px' => [
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                ],
            ],
            'tilt' => [
                'label' => __( '3D Tilt', 'lastudio' ),
                'fields' => [
                    'direction' => [
                        'label' => __( 'Direction', 'lastudio' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => '',
                        'options' => [
                            '' => __( 'Direct', 'lastudio' ),
                            'negative' => __( 'Opposite', 'lastudio' ),
                        ],
                    ],
                    'speed' => [
                        'label' => __( 'Speed', 'lastudio' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 4,
                        ],
                        'range' => [
                            'px' => [
                                'max' => 10,
                                'step' => 0.1,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function prepare_effects( $effects_group, array & $fields ) {
        $method_name = "get_{$effects_group}_effects";

        $effects = $this->$method_name();

        foreach ( $effects as $effect_name => $effect_args ) {
            $args = [
                'label' => $effect_args['label'],
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'condition' => [
                    'motion_fx_' . $effects_group => 'yes',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ];

            if ( ! empty( $effect_args['separator'] ) ) {
                $args['separator'] = $effect_args['separator'];
            }

            $fields[ $effect_name . '_effect' ] = $args;

            $effect_fields = $effect_args['fields'];

            $first_field = & $effect_fields[ key( $effect_fields ) ];

            $first_field['popover']['start'] = true;

            end( $effect_fields );

            $last_field = & $effect_fields[ key( $effect_fields ) ];

            $last_field['popover']['end'] = true;

            reset( $effect_fields );

            foreach ( $effect_fields as $field_name => $field ) {
                $field = array_merge( $field, [
                    'condition' => [
                        'motion_fx_' . $effects_group => 'yes',
                        $effect_name . '_effect' => 'yes',
                    ],
                    'render_type' => 'none',
                    'frontend_available' => true,
                ] );

                $fields[ $effect_name . '_' . $field_name ] = $field;
            }
        }
    }
}
