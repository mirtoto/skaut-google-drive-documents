<?php
namespace Sgdd\Admin\SettingsPages\PathSelection;

if ( ! is_admin() ) {
	return;
}

function register() {
  add_action( 'admin_init', '\\Sgdd\\Admin\\SettingsPages\\PathSelection\\addSettings' );
	add_action( 'admin_enqueue_scripts', '\\Sgdd\\Admin\\SettingsPages\\PathSelection\\registerScript' );
	add_action( 'wp_ajax_listDrive', '\\Sgdd\\Admin\\SettingsPages\\PathSelection\\ajaxHandler' );
}

function addSettings() {
  add_settings_section( 'sgdd_path_select', __( 'Step 2: Root Path Selection', 'skaut-google-drive-documents' ), '\\Sgdd\\Admin\\SettingsPages\\PathSelection\\display', 'sgdd_settings' );

	\Sgdd\Admin\Options\Options::$rootPath->register();
}

function registerScript( $hook ) {
	\Sgdd\enqueue_style( 'sgdd_path_selection_css', '/admin/css/path-selection.css' );
	if ( $hook === 'toplevel_page_sgdd_settings' ) {
		\Sgdd\enqueue_script( 'sgdd_path_selection_ajax', '/admin/js/path-selection.js', [ 'jquery' ] );
		wp_localize_script(
			'sgdd_path_selection_ajax',
			'sgddRootPathLocalize',
			[
				'ajax_url'        => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( 'sgddPathSelection' ),
				'path'            => \Sgdd\Admin\Options\Options::$rootPath->get(),
				'team_drive_list' => esc_html__( 'Team drive list', 'skaut-google-drive-documents' ),
			]
		);
	}
}

function ajaxHandler() {
	try {
		drivePathSelection();
	} catch ( \Sgdd\Vendor\Google_Service_Exception $e ) {
		if ( 'userRateLimitExceeded' === $e->getErrors()[0]['reason'] ) {
			wp_send_json( [ 'error' => esc_html__( 'The maximum number of requests has been exceeded. Please try again in a minute.', 'skaut-google-drive-documents' ) ] );
		} else {
			wp_send_json( [ 'error' => $e->getErrors()[0]['message'] ] );
		}
	} catch ( \Exception $e ) {
		wp_send_json( [ 'error' => $e->getMessage() ] );
	}
}

function drivePathSelection() {
	check_ajax_referer( 'sgddPathSelection' );
	
	if ( ! current_user_can( 'manage_options' ) ) {
		throw new \Exception( esc_html__( 'Insufficient role for this action.', 'skaut-google-drive-documents' ) );
	}
	
	$service = \Sgdd\Admin\GoogleAPILib\getDriveClient();
	$path = isset( $_GET['path'] ) ? $_GET['path'] : [];

	if ( empty( $path ) ) {
		$path = "Empty!";
	}

	wp_send_json( $path );
}

function display() {  
?>	
	<div id="rootPath">
		<div id="loadingCircle"></div>
		<table border='1'>
			<tr>
					<th>PathName</th>
					<th>PathId</th>
			</tr>
		</table>
	</div>
<?php
	//\Sgdd\Admin\Options\Options::$rootPath->display();
  //$service = \Sgdd\Admin\GoogleAPILib\getDriveClient();
	
	
	//Get Path Name From ID
	//$path = \Sgdd\Admin\Options\Options::$rootPath->get();
	/*$response = $service->teamdrives->get( $path[0], [ 'fields' => 'name' ] );
	$name = $response->getName();
  //Get Path Name From ID

	echo $name;*/

	/*$path = [ '0AG1axM1kLzqjUk9PVA', '1w78zgtEG8dQNJ5mBnJc2hJA9PuW2KiA2', '1m5epvIURE_nVz6hV28ZsyhVGURrvqSju' ];

  $ret        = [];
  $page_token = null;
	$root = end( $path );
	do {
		$params   = [
			//'q'                     => '"' . $root . '" in parents and mimeType = "application/vnd.google-apps.folder" and trashed = false',
			'q'                     => '"' . $root . '" in parents and trashed = false',
			'supportsTeamDrives'    => true,
			'includeTeamDriveItems' => true,
			'pageToken'             => $page_token,
			'pageSize'              => 1000,
			'fields'                => 'nextPageToken, files(id, name)',
		];
		$response = $service->files->listFiles( $params );
		if ( $response instanceof \Sgdd\Vendor\Google_Service_Exception ) {
			throw $response;
		}
		foreach ( $response->getFiles() as $file ) {
			$ret[] = [
				'name' => $file->getName(),
				'id'   => $file->getId(),
			];
		}
		$page_token = $response->getNextPageToken();
	} while ( null !== $page_token );*/

	/*$ret        = [
		[
			'name' => esc_html__( 'My Drive', 'skaut-google-drive-gallery' ),
			'id'   => 'root',
		],
	];
	$page_token = null;
	do {
		$params   = [
			'pageToken' => $page_token,
			'pageSize'  => 100,
			'fields'    => 'nextPageToken, teamDrives(id, name)',
		];
		$response = $service->teamdrives->listTeamdrives( $params );

		if ( $response instanceof \Sgdd\Vendor\Google_Service_Exception ) {
			throw $response;
		}
		foreach ( $response->getTeamdrives() as $teamdrive ) {
			$ret[] = [
				'name' => $teamdrive->getName(),
				'id'   => $teamdrive->getId(),
			];
		}
		$page_token = $response->getNextPageToken();
	} while ( null !== $page_token );*/

	/*$ret = [];
	if ( count( $path ) > 0 ) {
		if ( 'root' === $path[0] ) {
			$ret[] = esc_html__( 'My Drive', 'skaut-google-drive-gallery' );
		} else {
			$response = $service->teamdrives->get( $path[0], [ 'fields' => 'name' ] );
			$ret[]    = $response->getName();
		}
	}
	foreach ( array_slice( $path, 1 ) as $path_element ) {
		$response = $service->files->get(
			$path_element,
			[
				'supportsTeamDrives' => true,
				'fields'             => 'name',
			]
		);
		$ret[]    = $response->getName();
	}*/

	//var_dump($ret);

  /*foreach ( $ret as $res ) {
    echo $res['name'] . ' [id: '. $res['id'] . ']';
    echo '<br>';
	}*/

	/*var_dump( \Sgdd\Admin\Options\Options::$rootPath->get()[0] );*/

  //echo count($ret);
}