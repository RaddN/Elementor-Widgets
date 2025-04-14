
function register_fancy_dropdown_widget($widgets_manager)
{

	if (!defined('ABSPATH')) {
		exit; // Exit if accessed directly
	}

	class Fancy_Dropdown_Widget extends \Elementor\Widget_Base
	{

		public function get_name()
		{
			return 'fancy_dropdown';
		}

		public function get_title()
		{
			return __('Fancy Dropdown', 'fancy-dropdown-elementor');
		}

		public function get_icon()
		{
			return 'eicon-select';
		}

		public function get_categories()
		{
			return ['general'];
		}

		protected function register_controls()
		{
			$this->start_controls_section(
				'content_section',
				[
					'label' => __('Dropdown Content', 'fancy-dropdown-elementor'),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'trigger_text',
				[
					'label' => __('Trigger Text', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __('Kies uw locatie', 'fancy-dropdown-elementor'),
					'placeholder' => __('Enter dropdown placeholder text', 'fancy-dropdown-elementor'),
					'label_block' => true,
				]
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'list_title',
				[
					'label' => __('Title', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __('List Item', 'fancy-dropdown-elementor'),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_url',
				[
					'label' => __('Link', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => __('https://your-link.com', 'fancy-dropdown-elementor'),
					'default' => [
						'url' => '#',
					],
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_value',
				[
					'label' => __('Value (optional)', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
					'description' => __('Data value for the item, used for filtering or identification', 'fancy-dropdown-elementor'),
				]
			);

			$this->add_control(
				'dropdown_items',
				[
					'label' => __('Dropdown Items', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => __('Rotterdam Zuid', 'fancy-dropdown-elementor'),
							'list_url' => ['url' => '/tandarts-rotterdam-zuid/'],
							'list_value' => 'tandarts-rotterdam-zuid',
						],
						[
							'list_title' => __('Rotterdam Centrum', 'fancy-dropdown-elementor'),
							'list_url' => ['url' => '/tandarts-rotterdam-centrum/'],
							'list_value' => 'tandarts-rotterdam-centrum',
						],						
						[
							'list_title' => __('Rotterdam Noord', 'fancy-dropdown-elementor'),
							'list_url' => ['url' => '/tandarts-rotterdam-noord/'],
							'list_value' => 'tandarts-rotterdam-noord',
						],
						[
							'list_title' => __('Rotterdam West', 'fancy-dropdown-elementor'),
							'list_url' => ['url' => '/tandarts-rotterdam-west/'],
							'list_value' => 'tandarts-rotterdam-west',
						],						
					],
					'title_field' => '{{{ list_title }}}',
				]
			);

			$this->end_controls_section();

			// Style section
			$this->start_controls_section(
				'style_section',
				[
					'label' => __('Triger Style', 'fancy-dropdown-elementor'),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'trigger_background',
				[
					'label' => __('Trigger Background', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#f1e1e9',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .trigger' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'trigger_text_color',
				[
					'label' => __('Trigger Text Color', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .trigger' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'trigger_typography',
					'label' => __('Trigger Typography', 'fancy-dropdown-elementor'),
					'selector' => '{{WRAPPER}} .fincy_dropdown .trigger',
				]
			);

			$this->add_responsive_control(
				'padding',
				[
					'label' => __('Padding', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'margin',
				[
					'label' => __('Margin', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'border_radius',
				[
					'label' => __('Border Radius', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'box_shadow',
				[
					'label' => __('Box Shadow', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::BOX_SHADOW,
					'selector' => '{{WRAPPER}} .fincy_dropdown',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'style_dropdown_section',
				[
					'label' => __('Dropdown Style', 'fancy-dropdown-elementor'),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'dropdown_background',
				[
					'label' => __('Dropdown Background', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'item_text_color',
				[
					'label' => __('Item Text Color', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#333333',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'item_hover_background',
				[
					'label' => __('Item Hover Background', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#f5f5f5',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li:hover' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'item_hover_text_color',
				[
					'label' => __('Item Hover Text Color', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li:hover a' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'item_typography',
					'label' => __('Item Typography', 'fancy-dropdown-elementor'),
					'selector' => '{{WRAPPER}} .fincy_dropdown .options li a',
				]
			);						
			$this->add_responsive_control(
				'item_border_radius',
				[
					'label' => __('Item Border Radius', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			// add border for items
			$this->add_control(
				'item_border',
				[
					'label' => __('Item Border', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => __('None', 'fancy-dropdown-elementor'),
						'solid' => __('Solid', 'fancy-dropdown-elementor'),
						'dashed' => __('Dashed', 'fancy-dropdown-elementor'),
						'dotted' => __('Dotted', 'fancy-dropdown-elementor'),
					],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li:not(:last-child)' => 'border-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'item_border_color',
				[
					'label' => __('Item Border Color', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#e0e0e0',
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li:not(:last-child)' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'item_border_width',
				[
					'label' => __('Item Border Width', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li:not(:last-child)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			// item padding
			$this->add_responsive_control(
				'item_padding',
				[
					'label' => __('Item Padding', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'item_margin',
				[
					'label' => __('Item Margin', 'fancy-dropdown-elementor'),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .fincy_dropdown .options.show' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


			$this->end_controls_section();
		}

		protected function render()
		{
			$settings = $this->get_settings_for_display();
?>
			<style>
				/* assets/css/fancy-dropdown.css */

				.fincy_dropdown {
					position: relative;
					width: 100%;
					font-size: 16px;
					border-radius: 8px;
					box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
					background-color: white;
					z-index: 100;
					margin-bottom: 15px;
				}

				.fincy_dropdown .trigger {
					padding: 15px 20px;
					background-color: #4A90E2;
					color: white;
					border-radius: 8px;
					cursor: pointer;
					position: relative;
					transition: all 0.3s ease;
					display: flex;
					justify-content: space-between;
					align-items: center;
				}

				.fincy_dropdown .trigger:after {
					content: '▼';
					font-size: 12px;
					margin-left: 10px;
					transition: transform 0.3s ease;
				}

				.fincy_dropdown .trigger.active:after {
					transform: rotate(180deg);
				}

				.fincy_dropdown .options {
					position: absolute;
					top: calc(100% + 5px);
					left: 0;
					width: 100%;
					background-color: white;
					border-radius: 8px;
					overflow: hidden;
					max-height: 0;
					opacity: 0;
					transition: all 0.3s ease;
					box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
					z-index: 99;
				}

				.fincy_dropdown .options.show {
					max-height: 300px;
					opacity: 1;
				}

				.fincy_dropdown .options.overflowing {
					max-height: 200px;
					overflow-y: auto;
				}

				.fincy_dropdown .options li {
					list-style: none;
					padding: 0;
					border-bottom: 1px solid #f0f0f0;
					transition: background-color 0.2s ease;
				}

				.fincy_dropdown .options li:last-child {
					border-bottom: none;
				}

				.fincy_dropdown .options li a {
					display: block;
					padding: 12px 20px;
					text-decoration: none;
					color: #333;
					transition: color 0.2s ease;
				}

				.fincy_dropdown .options li:hover {
					background-color: #f5f5f5;
				}

				/* Responsive adjustments */
				@media (max-width: 767px) {
					.fincy_dropdown {
						width: 100%;
					}
				}
			</style>
			<div class="fincy_dropdown">
				<div class="trigger"><?php echo esc_html($settings['trigger_text']); ?></div>
				<ul class="options" style="display: none;">
					<?php foreach ($settings['dropdown_items'] as $item) : ?>
						<li <?php echo !empty($item['list_value']) ? 'data-raw-value="' . esc_attr($item['list_value']) . '"' : ''; ?>>
							<a href="<?php echo esc_url($item['list_url']['url']); ?>"
								<?php echo $item['list_url']['is_external'] ? 'target="_blank"' : ''; ?>
								<?php echo $item['list_url']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
								<?php echo esc_html($item['list_title']); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<script>
				// assets/js/fancy-dropdown.js

				(function($) {
					'use strict';

					$(document).ready(function() {
						// Toggle dropdown visibility
						$('.fincy_dropdown .trigger').on('click', function(e) {
							e.stopPropagation();
							const $this = $(this);
							const $options = $this.next('.options');

							// Toggle active class on trigger
							$this.toggleClass('active');

							// Toggle options visibility
							if ($options.hasClass('show')) {
								$options.removeClass('show');
								setTimeout(function() {
									$options.css('display', 'none');
								}, 300); // Match transition duration
							} else {
								$options.css('display', 'block');
								// Force a reflow before adding the show class
								$options[0].offsetHeight;
								$options.addClass('show');

								// Check if we need scrolling
								if ($options.find('li').length > 5) {
									$options.addClass('overflowing');
								}
							}
						});

						// Close dropdown when clicking outside
						$(document).on('click', function(e) {
							if (!$(e.target).closest('.fincy_dropdown').length) {
								const $openDropdowns = $('.fincy_dropdown .options.show');
								const $activeTriggers = $('.fincy_dropdown .trigger.active');

								$activeTriggers.removeClass('active');
								$openDropdowns.removeClass('show');

								setTimeout(function() {
									$openDropdowns.css('display', 'none');
								}, 300);
							}
						});

						// Handle option selection
						$('.fincy_dropdown .options li a').on('click', function() {
							const $this = $(this);
							const $dropdown = $this.closest('.fincy_dropdown');
							const newText = $this.text();

							// You can use this to update the trigger text if needed
							// $dropdown.find('.trigger').text(newText);

							// Close the dropdown
							$dropdown.find('.options').removeClass('show');
							$dropdown.find('.trigger').removeClass('active');

							setTimeout(function() {
								$dropdown.find('.options').css('display', 'none');
							}, 300);
						});
					});

				})(jQuery);
			</script>
<?php
		}
	}
	$widgets_manager->register(new \Fancy_Dropdown_Widget());
}
add_action('elementor/widgets/register', 'register_fancy_dropdown_widget');
