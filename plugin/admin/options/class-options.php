<?php
namespace Sgdd\Admin\Options;

require_once __DIR__ . '/option-types/class-stringfield.php';
require_once __DIR__ . '/option-types/class-pathfield.php';
require_once __DIR__ . '/option-types/class-integerfield.php';
require_once __DIR__ . '/option-types/class-selectfield.php';

class Options {
	public static $authorized_domain;
	public static $authorized_origin;
	public static $redirect_uri;
	public static $client_id;
	public static $client_secret;
	public static $root_path;

	public static $embed_width;
	public static $embed_height;

	public static $size_unit;

	public static function init() {
		$url                     = wp_parse_url( get_site_url() );
		self::$authorized_domain = new \Sgdd\Admin\Options\OptionTypes\StringField( 'authorized_domain', __( 'Authorised domain', 'skaut-google-drive-documents' ), 'basic', 'auth', $_SERVER['HTTP_HOST'] );
		self::$authorized_origin = new \Sgdd\Admin\Options\OptionTypes\StringField( 'authorized_origin', __( 'Authorised JavaScript origin', 'skaut-google-drive-documents' ), 'basic', 'auth', $url['scheme'] . '://' . $url['host'] );
		self::$redirect_uri      = new \Sgdd\Admin\Options\OptionTypes\StringField( 'redirect_uri', __( 'Authorised redirect URI', 'skaut-google-drive-documents' ), 'basic', 'auth', esc_url_raw( admin_url( 'admin.php?page=sgdd_basic&action=oauth_redirect' ) ) );
		self::$client_id         = new \Sgdd\Admin\Options\OptionTypes\StringField( 'client_id', __( 'Client ID', 'skaut-google-drive-documents' ), 'basic', 'auth', '' );
		self::$client_secret     = new \Sgdd\Admin\Options\OptionTypes\StringField( 'client_secret', __( 'Client secret', 'skaut-google-drive-documents' ), 'basic', 'auth', '' );

		self::$root_path = new \Sgdd\Admin\Options\OptionTypes\PathField( 'root_path', '', 'basic', 'path_selection', [] );

		self::$embed_width  = new \Sgdd\Admin\Options\OptionTypes\IntegerField( 'embed_width', __( 'Width', 'skaut-google-drive-documents' ), 'advanced', 'embed', '50' );
		self::$embed_height = new \Sgdd\Admin\Options\OptionTypes\IntegerField( 'embed_height', __( 'Height', 'skaut-google-drive-documents' ), 'advanced', 'embed', '50' );

		self::$size_unit = new \Sgdd\Admin\Options\OptionTypes\SelectField( 'size_unit', __( 'Units', 'skaut-google-drive-documents' ), 'advanced', 'embed', 'percentage' );
	}
}
