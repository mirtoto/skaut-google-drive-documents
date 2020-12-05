<?php
/**
 * IntegerField class
 *
 * @package SGDD
 * @since 1.0.0
 */
namespace Sgdd\Admin\Options\OptionTypes;

require_once __DIR__ . '/class-settingfield.php';

/**
 * An option containing an checkbox value.
 *
 * @see CheckboxField
 */
class CheckboxField extends SettingField {
	/**
	 * Register option into WordPress.
	 */
	public function register() {
		register_setting(
			$this->page,
			$this->id,
			[
				'type'              => 'integer',
				'sanitize_callback' => [ $this, 'sanitize' ],
				'default'           => $this->default_value,
			]
		);
	}

	/**
	 * Sanitize the input.
	 *
	 * @param $value The unsanitized input.
	 * @return boolean Sanitized value.
	 */
	public function sanitize( $value ) {
		return ( 1 === absint( $value ) ) ? 1 : 0;
	}

	/**
	 * Display field for updating the option
	 */
	public function display() {
		echo "<label for='" . esc_attr( $this->id ) . "'>" . 
				"<input type='checkbox' name='" . esc_attr( $this->id ) . "' id='" . esc_attr( $this->id ) . "' value='1' " . checked( 1, get_option( $this->id, $this->default_value ), false ) . ">" .
				esc_attr( $this->label ) . "</label>" . 
			"<p class='description'>" . esc_attr( $this->description ) . "</p>";
	}
}
