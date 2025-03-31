<?php


/**
 * Custom Mega Menu Elementor Widget
 * 
 * @package YourTheme
 */

/**
 * Enqueue jQuery
 */
function enqueue_jquery()
{
    if (!is_admin() && !wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

// Register the widget
add_action('elementor/widgets/widgets_registered', 'register_mega_menu_widget');

function register_mega_menu_widget()
{

    // Create the widget class
    class MegaMenuWidget extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'mega_menu_widget';
        }

        public function get_title()
        {
            return __('Mega Menu', 'your-theme');
        }

        public function get_icon()
        {
            return 'eicon-nav-menu';
        }

        public function get_categories()
        {
            return ['general'];
        }

        protected function _register_controls()
        {
            // Menu Items Section
            $this->start_controls_section(
                'section_menu_items',
                [
                    'label' => __('Menu Items', 'your-theme'),
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'item_title',
                [
                    'label' => __('Title', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Menu Item', 'your-theme'),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'item_link',
                [
                    'label' => __('Link', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'your-theme'),
                    'default' => [
                        'url' => '#',
                    ],
                ]
            );

            $repeater->add_control(
                'has_megamenu',
                [
                    'label' => __('Enable Mega Menu', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', 'your-theme'),
                    'label_off' => __('No', 'your-theme'),
                    'return_value' => 'yes',
                    'default' => '',
                ]
            );

            $repeater->add_control(
                'megamenu_template',
                [
                    'label' => __('Mega Menu Template', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => $this->get_elementor_templates(),
                    'condition' => [
                        'has_megamenu' => 'yes',
                    ],
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'menu_items',
                [
                    'label' => __('Menu Items', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'item_title' => __('Menu Item 1', 'your-theme'),
                            'item_link' => ['url' => '#'],
                        ],
                    ],
                    'title_field' => '{{{ item_title }}}',
                ]
            );

            $this->end_controls_section();

            // Menu Settings
            $this->start_controls_section(
                'section_menu_settings',
                [
                    'label' => __('Menu Settings', 'your-theme'),
                ]
            );

            $this->add_control(
                'menu_orientation',
                [
                    'label' => __('Menu Orientation', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'horizontal' => __('Horizontal', 'your-theme'),
                        'vertical' => __('Vertical', 'your-theme'),
                    ],
                ]
            );

            $this->add_control(
                'dropdown_trigger',
                [
                    'label' => __('Dropdown Trigger', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'hover',
                    'options' => [
                        'hover' => __('Hover', 'your-theme'),
                        'click' => __('Click', 'your-theme'),
                    ],
                ]
            );

            $this->add_responsive_control(
                'menu_align',
                [
                    'label' => __('Menu Alignment', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'flex-start' => [
                            'title' => __('Left', 'your-theme'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'your-theme'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'flex-end' => [
                            'title' => __('Right', 'your-theme'),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'space-between' => [
                            'title' => __('Justified', 'your-theme'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-container' => 'justify-content: {{VALUE}};',
                    ],
                    'default' => 'flex-start',
                ]
            );

            $this->end_controls_section();
            $this->start_controls_section(
                'section_menu_footer_settings',
                [
                    'label' => __('Menu Footer Settings', 'your-theme'),
                ]
            );
            $this->add_control(
                'footer_section_template',
                [
                    'label' => __('Mobile Mega Menu Footer Section Template', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => $this->get_elementor_templates(),
                    'label_block' => true,
                ]
            );

            $this->end_controls_section();

            // Style Tab - Main Menu
            $this->start_controls_section(
                'section_style_main_menu',
                [
                    'label' => __('Main Menu', 'your-theme'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'menu_typography',
                    'label' => __('Typography', 'your-theme'),
                    'selector' => '{{WRAPPER}} .mega-menu-item > a',
                ]
            );

            $this->add_responsive_control(
                'menu_item_spacing',
                [
                    'label' => __('Menu Item Spacing', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .horizontal .mega-menu-item' => 'margin-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .vertical .mega-menu-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'menu_padding',
                [
                    'label' => __('Menu Item Padding', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'top' => '10',
                        'right' => '15',
                        'bottom' => '10',
                        'left' => '15',
                        'unit' => 'px',
                        'isLinked' => false,
                    ],
                ]
            );

            // Normal, Hover, Active states for menu items
            $this->start_controls_tabs('menu_item_style_tabs');

            // Normal State
            $this->start_controls_tab(
                'menu_item_normal',
                [
                    'label' => __('Normal', 'your-theme'),
                ]
            );

            $this->add_control(
                'menu_item_color',
                [
                    'label' => __('Text Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#333333',
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'menu_item_bg_color',
                [
                    'label' => __('Background Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'menu_item_border',
                    'label' => __('Border', 'your-theme'),
                    'selector' => '{{WRAPPER}} .mega-menu-item > a',
                ]
            );

            $this->add_responsive_control(
                'menu_item_border_radius',
                [
                    'label' => __('Border Radius', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // Hover State
            $this->start_controls_tab(
                'menu_item_hover',
                [
                    'label' => __('Hover', 'your-theme'),
                ]
            );

            $this->add_control(
                'menu_item_hover_color',
                [
                    'label' => __('Text Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#0073aa',
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mega-menu-item:hover > a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'menu_item_hover_bg_color',
                [
                    'label' => __('Background Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a:hover' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mega-menu-item:hover > a' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'menu_item_hover_border',
                    'label' => __('Border', 'your-theme'),
                    'selector' => '{{WRAPPER}} .mega-menu-item > a:hover, {{WRAPPER}} .mega-menu-item:hover > a',
                ]
            );

            $this->add_control(
                'menu_item_hover_transition',
                [
                    'label' => __('Transition Duration', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 0.3,
                    ],
                    'range' => [
                        'px' => [
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item > a' => 'transition: all {{SIZE}}s ease;',
                    ],
                ]
            );

            $this->end_controls_tab();

            // Active State
            $this->start_controls_tab(
                'menu_item_active',
                [
                    'label' => __('Active', 'your-theme'),
                ]
            );

            $this->add_control(
                'menu_item_active_color',
                [
                    'label' => __('Text Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#0073aa',
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item.active > a' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mega-menu-item.mega-menu-active > a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'menu_item_active_bg_color',
                [
                    'label' => __('Background Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-item.active > a' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mega-menu-item.mega-menu-active > a' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'menu_item_active_border',
                    'label' => __('Border', 'your-theme'),
                    'selector' => '{{WRAPPER}} .mega-menu-item.active > a, {{WRAPPER}} .mega-menu-item.mega-menu-active > a',
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->end_controls_section();

            // Style Tab - Mega Menu Dropdown
            $this->start_controls_section(
                'section_style_mega_menu',
                [
                    'label' => __('Mega Menu Dropdown', 'your-theme'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'mega_menu_bg_color',
                [
                    'label' => __('Background Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'mega_menu_border',
                    'label' => __('Border', 'your-theme'),
                    'selector' => '{{WRAPPER}} .mega-menu-content',
                    'fields_options' => [
                        'border' => [
                            'default' => 'solid',
                        ],
                        'width' => [
                            'default' => [
                                'top' => '1',
                                'right' => '1',
                                'bottom' => '1',
                                'left' => '1',
                                'isLinked' => true,
                            ],
                        ],
                        'color' => [
                            'default' => '#eeeeee',
                        ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'mega_menu_border_radius',
                [
                    'label' => __('Border Radius', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'top' => '0',
                        'right' => '0',
                        'bottom' => '4',
                        'left' => '4',
                        'unit' => 'px',
                        'isLinked' => false,
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'mega_menu_box_shadow',
                    'selector' => '{{WRAPPER}} .mega-menu-content',
                    'fields_options' => [
                        'box_shadow_type' => [
                            'default' => 'yes',
                        ],
                        'box_shadow' => [
                            'default' => [
                                'horizontal' => 0,
                                'vertical' => 5,
                                'blur' => 15,
                                'spread' => 0,
                                'color' => 'rgba(0, 0, 0, 0.1)',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'mega_menu_padding',
                [
                    'label' => __('Padding', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'top' => '20',
                        'right' => '20',
                        'bottom' => '20',
                        'left' => '20',
                        'unit' => 'px',
                        'isLinked' => true,
                    ],
                ]
            );

            $this->add_responsive_control(
                'mega_menu_width',
                [
                    'label' => __('Width', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%', 'vw'],
                    'range' => [
                        'px' => [
                            'min' => 220,
                            'max' => 1200,
                        ],
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                        'vw' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 800,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'mega_menu_offset_x',
                [
                    'label' => __('Offset X', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'mega_menu_offset_y',
                [
                    'label' => __('Offset Y', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'mega_menu_indicator_color',
                [
                    'label' => __('Indicator Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mega-menu-indicator svg path' => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();

            // mobile menu style
            $this->start_controls_section(
                'section_style_mobile_menu',
                [
                    'label' => __('Mobile Menu', 'your-theme'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'mobile_menu_toggle_icon_color',
                [
                    'label' => __('Toggle Icon Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mobile-menu-toggle-icon svg path' => 'fill: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'mobile_menu_toggle_icon_hover_color',
                [
                    'label' => __('Toggle Icon Hover Color', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mobile-menu-toggle-icon:hover svg path' => 'fill: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'mobile_menu_toggle_align',
                [
                    'label' => __('Toggle Icon Alignment', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'right',
                    'options' => [
                        'flex-start' => __('Left', 'your-theme'),
                        'flex-end' => __('Right', 'your-theme'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .custom-mega-menu' => 'justify-content: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'mobile_menu_toggle_icon_size',
                [
                    'label' => __('Toggle Icon Size', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px'],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 50,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 24,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mobile-menu-toggle-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'mobile_menu_style_drawer_or_dropdown',
                [
                    'label' => __('Mobile Menu Style', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'drawer',
                    'options' => [
                        'drawer' => __('Drawer', 'your-theme'),
                        'dropdown' => __('Dropdown', 'your-theme'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .custom-mega-menu' => 'display: flex;',
                    ],
                ]
            );
            $this->add_control(
                'mobile_menu_drawer_width',
                [
                    'label' => __('Drawer Width', 'your-theme'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 500,
                        ],
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 300,
                    ],
                ]
            );
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings                           = $this->get_settings_for_display();
            $menu_orientation                   = $settings['menu_orientation'];
            $dropdown_trigger                   = $settings['dropdown_trigger'];
            $mobile_menu_drawer_width           = isset($settings['mobile_menu_drawer_width']['size']) ? $settings['mobile_menu_drawer_width']['size'] . $settings['mobile_menu_drawer_width']['unit'] : '300px';
            $mobile_menu_style_drawer_or_dropdown = isset($settings['mobile_menu_style_drawer_or_dropdown']) ? $settings['mobile_menu_style_drawer_or_dropdown'] : 'drawer';
            $footer_section_template             = isset($settings['footer_section_template']) ? $settings['footer_section_template'] : '';
            // Generate unique ID for this menu instance
            $menu_id = 'mega-menu-' . $this->get_id();
?>
            <style>
                .mega-menu-container ul {
                    list-style: none;
                }

                .custom-mega-menu.horizontal .mega-menu-container,
                .custom-mega-menu.horizontal .mega-menu-container .mega-menu-list {
                    display: flex;
                }
                .custom-mega-menu .mega-menu-content {
                    position: absolute;
                    display: none;
                    z-index: 999;
                    left: 0;
                    transform: translateX(-40%);
                    max-width: 1280px;
                    width: max-content !important;
                    top: 5.5rem !important;
                    transition: 1s all;
                }

                li.mega-menu-item.has-megamenu a {
                    position: relative;
                }

                span.mega-menu-indicator {
                    position: absolute;
                    top: 3rem;
                    left: -1.3rem;
                    z-index: 999;
                    display: none;
                }
                span.mega-indicator-sm{
                    display: none;
                }

                @media(min-width: 768px) {
                    li.mega-menu-item.has-megamenu:hover .mega-menu-content {
                        display: block;
                    }

                    li.mega-menu-item.has-megamenu:hover span.mega-menu-indicator {
                        display: block;
                    }
                }


                .mobile-menu-toggle-icon {
                    cursor: pointer;
                }

                .mobile-menu-toggle-icon {
                    display: none;
                }

                @media (max-width: 768px) {
                    .custom-mega-menu .mobile-menu-toggle-icon {
                        display: block;
                    }

                    .custom-mega-menu.horizontal .mega-menu-container,
                    .custom-mega-menu.horizontal .mega-menu-container .mega-menu-list {
                        flex-direction: column;
                    }

                    .mega-menu-container {
                        position: absolute;
                        display: none;
                        width: <?php echo esc_attr($mobile_menu_drawer_width); ?>;
                        background: #fff;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    .mega-menu-container.drawer {
                        position: fixed;
                        bottom: 0;
                        right: 0;
                        height: 100vh;
                        overflow-y: auto;
                        transform: translateX(100%);
                        transition: transform 0.3s ease;
                        z-index: 9999;
                        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                        padding: 0;
                        justify-content: space-between !important;
                    }

                    .mega-menu-container.drawer.open {
                        transform: translateX(0);
                    }

                    .mega-menu-container.dropdown.open {
                        display: block;
                    }

                    .mega-menu-container.drawer.open>li {
                        padding: 0 20px;
                    }

                    .mobile-top {
                        display: flex;
                        justify-content: flex-end;
                        background-color: rgb(241 245 249 / 1);
                        padding: 1rem;
                    }
                    .back-main-menu {
                        display: flex;
                        align-items: center;
                        gap: 5px;
                    }

                    .custom-mega-menu .mega-menu-content {
                        width: 100% !important;
                        left: 0;
                        top: 5rem !important;
                    }

                    .mega-menu-footer {
                        display: block !important;
                    }
                    span.mobile-menu-toggle-icon {
                        text-align: right;
                    }
                    ul.mega-menu-list {
                        padding: 0;
                    }
                    span.mega-indicator-sm{
                    display: block;
                }
                    span.mega-indicator-sm svg {
                        width: 10px;
                    }
                    li.mega-menu-item.has-megamenu a {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    }
                    span.mobile-menu-toggle-icon>span {
                        transition: all 1s;
                    }
                    .custom-mega-menu .mega-menu-content{
                        display: block !important;
                        transform: translateX(-100%);
                    }
                }
            </style>

            <div class="custom-mega-menu <?php echo esc_attr($menu_orientation); ?>"
                data-trigger="<?php echo esc_attr($dropdown_trigger); ?>"
                id="<?php echo esc_attr($menu_id); ?>">
                <span class="mobile-menu-toggle-icon">
                    <span aria-hidden="true" class="mobile-open">
                        <svg class="ast-mobile-svg ast-menu-svg" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M3 13h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 7h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 19h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1z"></path>
                        </svg></span>
                    <span aria-hidden="true" class="mobile-close" style="display: none;"><svg class="ast-mobile-svg ast-close-svg" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path>
                        </svg></span> </span>
                <div class="mega-menu-container <?php echo esc_attr($mobile_menu_style_drawer_or_dropdown); ?>">
                    <div>
                        <div class="mobile-top">
                            <div class="back-main-menu" style="display: none; width:100%;"><span style="margin-right: 5px;"><svg style="width:16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg></span>Back to main menu</div>
                            <span class="mobile-menu-toggle-icon">
                                <span aria-hidden="true" class="mobile-open">
                                    <svg fill="#000" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M3 13h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 7h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 19h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1z"></path>
                                    </svg></span>
                                <span aria-hidden="true" class="mobile-close" style="display: none;"><svg fill="#000" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path>
                                    </svg></span> </span>
                        </div>
                        <ul class="mega-menu-list">

                            <?php foreach ($settings['menu_items'] as $index => $item) : ?>
                                <?php
                                $has_megamenu = !empty($item['has_megamenu']) && $item['has_megamenu'] === 'yes';
                                $link = !empty($item['item_link']['url']) ? $item['item_link']['url'] : '#';
                                $target = !empty($item['item_link']['is_external']) ? ' target="_blank"' : '';
                                $nofollow = !empty($item['item_link']['nofollow']) ? ' rel="nofollow"' : '';
                                ?>
                                <li class="mega-menu-item <?php echo $has_megamenu ? 'has-megamenu' : ''; ?>">
                                    <a href="<?php echo esc_url($link); ?>" <?php echo $target . $nofollow; ?>>
                                        <?php echo esc_html($item['item_title']); ?>
                                        <?php if ($has_megamenu) : ?>
                                        <span class="mega-indicator-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                                        </span>
                                            <span class="mega-menu-indicator"><svg xmlns="http://www.w3.org/2000/svg" width="140" height="36" viewBox="0 0 140 36" fill="none">
                                                    <path d="M70.4264 8.29657e-07C83.7791 21.6945 106.601 36 132.52 36L8.33614 36C34.2541 35.9938 57.0789 21.6936 70.4264 8.29657e-07Z" fill="white" />
                                                </svg></span>
                                        <?php endif; ?>
                                    </a>

                                    <?php if ($has_megamenu && !empty($item['megamenu_template'])) : ?>
                                        <div class="mega-menu-content">
                                            <?php echo $this->get_template_content($item['megamenu_template']); ?>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <?php if (!empty($footer_section_template)) : ?>
                        <div class="mega-menu-footer" style="display: none;">
                            <?php echo $this->get_template_content($footer_section_template); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <script>
                jQuery(document).ready(function($) {
                    const $mobileToggleIcon = $('.custom-mega-menu .mobile-menu-toggle-icon');
                    const $menuContainer = $('.mega-menu-container');
                    const $itemWithMegamenu = $('.mega-menu-item.has-megamenu');
                    const $backMainMenu = $('.back-main-menu');

                    function handleMobileMenu() {
                        if ($(window).width() <= 768) {
                            if ($mobileToggleIcon.length) {
                                $mobileToggleIcon.on('click', function() {
                                    $menuContainer.toggleClass('open');
                                    $mobileToggleIcon.find('.mobile-open').toggle();
                                    $mobileToggleIcon.find('.mobile-close').toggle();                                    
                                });
                            }

                            if ($itemWithMegamenu.length) {
                                $itemWithMegamenu.on('click', function() {
                                    const $this = $(this);
                                    $this.addClass('active');
                                    $this.find('.mega-menu-content').css({
                                        'top': '3rem',
                                        'transform': 'translateX(0)'
                                    });
                                    $backMainMenu.show();
                                });
                            }

                            if ($backMainMenu.length) {
                                $backMainMenu.on('click', function() {
                                    $itemWithMegamenu.removeClass('active');
                                    $itemWithMegamenu.find('.mega-menu-content').css(
                                        {
                                            'transform': 'translateX(-100%)'
                                        }
                                        );
                                    $backMainMenu.hide();
                                });
                            }

                            // Close drawer on outside click
                            $(document).on('click', function(event) {
                                if (!$(event.target).closest('.custom-mega-menu').length) {
                                    $menuContainer.removeClass('open');
                                    $mobileToggleIcon.find('.mobile-open').show();
                                    $mobileToggleIcon.find('.mobile-close').hide();                       

                                }
                            });

                            // Close drawer on ESC key press
                            $(document).on('keydown', function(event) {
                                if (event.key === "Escape") {
                                    $menuContainer.removeClass('open');
                                    $mobileToggleIcon.find('.mobile-open').show();
                                    $mobileToggleIcon.find('.mobile-close').hide(); 
                                }
                            });
                        } else {
                            $menuContainer.removeClass('open');
                            $itemWithMegamenu.off('click');
                            $mobileToggleIcon.off('click');
                            $backMainMenu.off('click');
                            $(document).off('click');
                            $(document).off('keydown');
                        }
                    }

                    handleMobileMenu();
                    $(window).resize(handleMobileMenu);
                });
            </script>
<?php
        }

        private function get_elementor_templates()
        {
            $templates = [];

            // Get templates from Elementor
            $args = [
                'post_type' => 'elementor_library',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ];

            $query = new \WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $templates[get_the_ID()] = get_the_title();
                }
            }

            wp_reset_postdata();

            return $templates;
        }

        private function get_template_content($template_id)
        {
            // Return rendered content of an Elementor template
            return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id);
        }
    }
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MegaMenuWidget());
}
