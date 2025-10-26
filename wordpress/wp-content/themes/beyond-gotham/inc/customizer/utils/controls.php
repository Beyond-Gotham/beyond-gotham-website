<?php
/**
 * Custom Customizer Control Classes
 *
 * Extended control types for enhanced customizer functionality.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

// =============================================================================
// Heading Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
	/**
	 * Simple heading control for grouping customizer fields.
	 */
	class Beyond_Gotham_Customize_Heading_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-heading';

		/**
		 * Render the control content.
		 */
		public function render_content() {
			if ( ! empty( $this->label ) ) {
				echo '<h3 class="customize-control-title" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">';
				echo esc_html( $this->label );
				echo '</h3>';
			}

			if ( ! empty( $this->description ) ) {
				echo '<p class="description customize-control-description">';
				echo esc_html( $this->description );
				echo '</p>';
			}
		}
	}
}

// =============================================================================
// Info/Notice Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Info_Control' ) ) {
	/**
	 * Info/notice box control for displaying helpful information.
	 */
	class Beyond_Gotham_Customize_Info_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-info';

		/**
		 * Notice type (info, warning, success, error).
		 *
		 * @var string
		 */
		public $notice_type = 'info';

		/**
		 * Render the control content.
		 */
		public function render_content() {
			$notice_class = 'notice notice-' . esc_attr( $this->notice_type );
			
			echo '<div class="' . $notice_class . '" style="padding: 10px; margin: 10px 0;">';
			
			if ( ! empty( $this->label ) ) {
				echo '<strong>' . esc_html( $this->label ) . '</strong>';
			}

			if ( ! empty( $this->description ) ) {
				echo '<p style="margin: 5px 0 0;">' . wp_kses_post( $this->description ) . '</p>';
			}

			echo '</div>';
		}
	}
}

// =============================================================================
// Separator Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Separator_Control' ) ) {
	/**
	 * Visual separator control for better organization.
	 */
	class Beyond_Gotham_Customize_Separator_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-separator';

		/**
		 * Render the control content.
		 */
		public function render_content() {
			echo '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;" />';
		}
	}
}

// =============================================================================
// Toggle Switch Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Toggle_Control' ) ) {
	/**
	 * iOS-style toggle switch control.
	 */
	class Beyond_Gotham_Customize_Toggle_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-toggle';

		/**
		 * Enqueue control scripts.
		 */
		public function enqueue() {
			wp_add_inline_style(
				'customize-controls',
				'
				.beyond-gotham-toggle-switch {
					position: relative;
					display: inline-block;
					width: 50px;
					height: 24px;
					margin: 10px 0;
				}
				
				.beyond-gotham-toggle-switch input {
					opacity: 0;
					width: 0;
					height: 0;
				}
				
				.beyond-gotham-toggle-slider {
					position: absolute;
					cursor: pointer;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					background-color: #ccc;
					transition: .4s;
					border-radius: 24px;
				}
				
				.beyond-gotham-toggle-slider:before {
					position: absolute;
					content: "";
					height: 18px;
					width: 18px;
					left: 3px;
					bottom: 3px;
					background-color: white;
					transition: .4s;
					border-radius: 50%;
				}
				
				.beyond-gotham-toggle-switch input:checked + .beyond-gotham-toggle-slider {
					background-color: #2271b1;
				}
				
				.beyond-gotham-toggle-switch input:checked + .beyond-gotham-toggle-slider:before {
					transform: translateX(26px);
				}
				'
			);
		}

		/**
		 * Render the control content.
		 */
		public function render_content() {
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				
				<label class="beyond-gotham-toggle-switch">
					<input 
						type="checkbox" 
						value="<?php echo esc_attr( $this->value() ); ?>" 
						<?php $this->link(); ?>
						<?php checked( $this->value() ); ?>
					/>
					<span class="beyond-gotham-toggle-slider"></span>
				</label>
				
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}

// =============================================================================
// Range Slider Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Range_Control' ) ) {
	/**
	 * Range slider control with live value display.
	 */
	class Beyond_Gotham_Customize_Range_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-range';

		/**
		 * Enqueue control scripts.
		 */
		public function enqueue() {
			wp_add_inline_script(
				'customize-controls',
				'
				(function($) {
					$(document).ready(function() {
						$(".beyond-gotham-range-slider").on("input", function() {
							var value = $(this).val();
							var unit = $(this).data("unit") || "";
							$(this).next(".beyond-gotham-range-value").text(value + unit);
						});
					});
				})(jQuery);
				'
			);
		}

		/**
		 * Render the control content.
		 */
		public function render_content() {
			$min  = isset( $this->input_attrs['min'] ) ? $this->input_attrs['min'] : 0;
			$max  = isset( $this->input_attrs['max'] ) ? $this->input_attrs['max'] : 100;
			$step = isset( $this->input_attrs['step'] ) ? $this->input_attrs['step'] : 1;
			$unit = isset( $this->input_attrs['unit'] ) ? $this->input_attrs['unit'] : '';
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				
				<div style="display: flex; align-items: center; gap: 10px;">
					<input 
						type="range" 
						class="beyond-gotham-range-slider"
						min="<?php echo esc_attr( $min ); ?>"
						max="<?php echo esc_attr( $max ); ?>"
						step="<?php echo esc_attr( $step ); ?>"
						value="<?php echo esc_attr( $this->value() ); ?>"
						data-unit="<?php echo esc_attr( $unit ); ?>"
						<?php $this->link(); ?>
						style="flex: 1;"
					/>
					<span class="beyond-gotham-range-value" style="min-width: 50px; text-align: right; font-weight: 600;">
						<?php echo esc_html( $this->value() . $unit ); ?>
					</span>
				</div>
				
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<?php
		}
	}
}

// =============================================================================
// Multi-Checkbox Control
// =============================================================================

if ( ! class_exists( 'Beyond_Gotham_Customize_Multi_Checkbox_Control' ) ) {
	/**
	 * Multiple checkbox control for selecting multiple options.
	 */
	class Beyond_Gotham_Customize_Multi_Checkbox_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'beyond-gotham-multi-checkbox';

		/**
		 * Render the control content.
		 */
		public function render_content() {
			if ( empty( $this->choices ) ) {
				return;
			}

			$multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value();
			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
				
				<ul style="list-style: none; padding: 0; margin: 10px 0;">
					<?php foreach ( $this->choices as $value => $label ) : ?>
						<li style="margin: 5px 0;">
							<label>
								<input 
									type="checkbox" 
									value="<?php echo esc_attr( $value ); ?>" 
									<?php checked( in_array( $value, $multi_values, true ) ); ?>
									style="margin-right: 5px;"
								/>
								<?php echo esc_html( $label ); ?>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
				
				<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
			</label>
			<?php
		}
	}
}
