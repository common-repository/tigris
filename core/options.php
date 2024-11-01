<?php
/**
 * @package WordPress
 * @subpackage Tigris for Salesforce
 * @since 1.0
 */

// Prevent direct file access
defined( 'ABSPATH' ) or exit;

// Get global plug-in options
$apl_setting = get_option( str_replace( '-', '_', ACS_TFS_NAME ) ); // acs_tigris_for_salesforce

/**
 * [acs_tfs_menu 						BACK-OFFICE: Adding menu to Administration panel]
 * @return [hook] 						[No return]
 */
function acs_tfs_menu() {

	if ( ! isset( $admin_page_hooks[ 'acs_tfs_adminpage' ] ) ) {

		$page_title = ACS_TFS_DEV . ' ' .  __( 'extension', ACS_TFS_NAME );
		$menu_title = __( 'Tigris', ACS_TFS_NAME );
		$capability = 'manage_options';
		$menu_slug  = 'acs-tigris-for-salesforce';
		$function 	= 'acs_tfs_adminpage';
		$icon_url 	= ACS_TFS_ASSETS_URL . 'img/plugin-icon.png';
		$position 	= '80.000001';

		$page_hook = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		add_action( "load-{$page_hook}", 'acs_tfs_add_help_tab' );
	}
}

/**
 * [acs_tfs_register_settings 			CORE: Plug-In settings]
 * @return [NULL] 						[No return]
 */
function acs_tfs_register_settings() {

	$option_group = 'acs-tfs-settings';
	$option_name  = str_replace( '-', '_', ACS_TFS_NAME );
	$args 		  = array(
			'type'              => 'string',
			'group'             => $option_group,
			'description'       => '',
			'sanitize_callback' => null,
			'show_in_rest'      => false,
		);
	register_setting( $option_group, $option_name, $args );

	$id 	  = 'acs_tfs_section_id';
	$title 	  = '';
	$callback = '';
	$page 	  = 'acs-tigris-for-salesforce';
	add_settings_section( $id, $title, $callback, $page );

	$section  = 'acs_tfs_section_id';

	$args	  = array(
		'type' 	  => 'text',
		'options' => str_replace( '-', '_', ACS_TFS_NAME )
	);

	$args['label'] = 'channel';
	$args['desc']  = __( 'Enter the channel ID.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_0', __( 'Organization Id', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	/*$args['label'] = 'login';
	$args['desc']  = __( 'Enter the login to access the channel.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_1', __( 'Salesforce Login', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'password';
	$args['desc']  = __( 'Enter the password to access the channel.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_2', __( 'Salesforce Password', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );*/

	$args['label'] = 'consumer_key';
	$args['desc']  = __( 'Consumer Key.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_14', __( 'Consumer Key', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'consumer_secret';
	$args['desc']  = __( 'Consumer Secret.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_15', __( 'Consumer Secret', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'category';
	$args['desc']  = __( 'Enter the name of the category you want to retrieve from.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_3', __( 'Category name', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'author';
	$args['desc']  = __( 'Enter the ID of the author whose entries you want to receive.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_4', __( 'Author ID', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'email';
	$args['desc']  = __( 'The form will be sent only if there is a failure in sending to Salesforce.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_5', __( 'E-mail for send forms', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'email_on';
	$args['desc']  = __( 'Enable if you want to receive all forms by e-mail.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_6', __( 'Enable sending forms to email', ACS_TFS_NAME ), 'acs_tfs_field_checkbox', $page, $section, $args );

	$args['label'] = 'redirect';
	$args['desc']  = __( 'If left blank, then the application will be sent in the background.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_7', __( 'Forwarding after submitting the form', ACS_TFS_NAME ), 'acs_tfs_field_select', $page, $section, $args );

	$args['label'] = 'location_area';
	$args['desc']  = __( 'Job placement regions for aplication form. Each region is entered through ";".<br>Example: Texas;Alabama;', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_8', __( 'Job locations', ACS_TFS_NAME ), 'acs_tfs_field_textarea', $page, $section, $args );

	$args['label'] = 'def_category';
	$args['desc']  = __( 'Enter the default category name. If you leave empty, default category name will be "no-vacancies".', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_9', __( 'Default category', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'category_off';
	$args['desc']  = __( 'Disable categories functionality.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_10', __( 'Disable categories', ACS_TFS_NAME ), 'acs_tfs_field_checkbox', $page, $section, $args );

	$args['label'] = 'branch_off';
	$args['desc']  = __( 'Disable branches functionality.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_11', __( 'Disable branches', ACS_TFS_NAME ), 'acs_tfs_field_checkbox', $page, $section, $args );

	$args['label'] = 'roles_off';
	$args['desc']  = __( 'Disable vacancies author functionality.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_12', __( 'Disable vacancies author', ACS_TFS_NAME ), 'acs_tfs_field_checkbox', $page, $section, $args );

	$args['label'] = 'google_api_key';
	$args['desc']  = __( 'API key for Google Maps.', ACS_TFS_NAME );
	add_settings_field( 'acs_tfs_section_id_13', __( 'Google API key', ACS_TFS_NAME ), 'acs_tfs_field_input', $page, $section, $args );

	$args['label'] = 'refresh_token';
	add_settings_field( 'acs_tfs_section_id_16', __( 'Connect SF', ACS_TFS_NAME ), 'acs_tfs_field_refreshToken', $page, $section, $args );
}

/**
 * [acs_tfs_adminpage 					BACK-OFFICE: Adding settings page in Administration panel]
 * @return [string] 					[Settings page HTML code]
 */
function acs_tfs_adminpage() {
	global $apl_setting;

	include_once 'page-setup.php';
}

/**
 * [acs_tfs_add_help_tab 				BACK-OFFICE: Adding help block to setting page]
 * @return [NULL] 						[No return]
 */
function acs_tfs_add_help_tab(){
	$screen = get_current_screen();

	$help_array = array(
			array(
				'id'      => 'acs_tfs_help_tab_firsst',
				'title'   => __( 'Connect user templates', ACS_TFS_NAME ),
				'content' => '<p>'
								. __( '1. Create a new "tigris" folder in your theme.', ACS_TFS_NAME ) . '<br />'
								. __( '2. Add your template to this new folder:', ACS_TFS_NAME ) . '<br />'
								. __( '- for the page of the list of vacancies (category-tigrisvacancies.php).', ACS_TFS_NAME ) . '<br />'
								. __( '- for the loadable AJAX vacancy block (ajax-tigrisvacancy.php).', ACS_TFS_NAME ) . '<br />'
								. __( '- for a single job page (single-tigrisvacancy.php).', ACS_TFS_NAME ) . '<br />'
								. __( '- for the form of the answer to the vacancy (form-tigrisvacancy.php).', ACS_TFS_NAME ) . '<br />'
								. __( '- for a single branch page (single-tigrisbranch.php).', ACS_TFS_NAME ) . '<br />'
								. '<br /><b>' . __( 'P.S.:', ACS_TFS_NAME ) . '</b> '
								. __( 'The default templates are located in the plugin folder "templates".', ACS_TFS_NAME ) . '<br />'
							. '</p>',
			),
			array(
				'id'      => 'acs_tfs_help_tab_second',
				'title'   => __( 'Form connection via shortcode.', ACS_TFS_NAME ),
				'content' => '<p>'
								. __( 'To show the application form for work in your theme template, insert a short code.', ACS_TFS_NAME ) . '<br /><br />'
								. __( 'Example:', ACS_TFS_NAME ) . '<br />'
								. __( '- outside the vacancy loop', ACS_TFS_NAME ) .  ': <b>[tigris_form id="0"]</b> ' . '<br />'
								. __( '- inside the vacancy loop',  ACS_TFS_NAME ) . ': <b>[tigris_form]</b>' . '<br />'
								. __( '- in php code',  ACS_TFS_NAME ) . ': <b>&lt;?php echo do_shortcode( &prime;[tigris_form id="0"]&prime; ); ?&gt;</b><br />'
							. '</p>',
			),
			array(
				'id'      => 'acs_tfs_help_tab_thirdth',
				'title'   => __( 'Attention', ACS_TFS_NAME ),
				'content' => '<p>'
								. __( 'Do not forget to re-save permanent links (Settings -> Permalinks).', ACS_TFS_NAME ) . '<br /><br />'
								. __( 'Link to the list of vacancies:', ACS_TFS_NAME ) . ' (' . __( 'your site permalink', ACS_TFS_NAME ) . ')<b>/vacatures</b><br /><br />'
							. '</p>',
			)
		);

	foreach ( $help_array as $value ) {
		$screen->add_help_tab( $value );
	}
}

/**
 * [acs_tfs_field_input					FRONT-OFFICE: Generated type input setting field]
 * @param  [array] $args 				[Field parameters]
 * @return [string] 					[Print settings fields]
 */
function acs_tfs_field_input( $args ) {
	$val = get_option( $args['options'] );

	switch ( $args['label'] ) {
		case 'password': $type = 'password';
			break;
		case 'email': $type = 'email';
			break;
		case 'phone': $type = 'tel';
			break;
		case 'hidden': $type = 'hidden';
			break;

		default: $type = esc_attr( $args['type'] );
			break;
	}
	?>

	<input
		type="<?php echo $type; ?>"
		name="<?php echo esc_attr( $args['options'] . '[' . $args['label'] . ']' ); ?>"
		value="<?php echo isset( $val[ $args['label'] ] ) ? $val[ $args['label']] :  '' ; ?>"
		size="60"
	/>

	<p class="description" style="font-size: .7em;">
		<?php echo esc_attr( $args['desc'] ); ?>
	</p>

	<?php
}

/**
 * [acs_tfs_field_select				FRONT-OFFICE: Generated type select setting field]
 * @param  [array] $args 				[Field parameters]
 * @return [string] 					[Print settings fields]
 */
function acs_tfs_field_select( $args ) {
	$val = get_option( $args['options'] );
	$pages = get_pages( $args ); ?>

	<select name="<?php echo esc_attr( $args['options'] . '[' . $args['label'] . ']' ); ?>" style="width: 400px">
		<option value="0">— <?php _e( 'Select', ACS_TFS_NAME ); ?> —</option>

		<?php foreach ( $pages as $key => $value ) {

			$link = str_replace( '/', '', parse_url( get_permalink( $value->ID ), PHP_URL_PATH ) );
			$select = '';

			if ( $val['redirect'] == $link && $val['redirect'] != NULL ) {
				$select = ' selected';
			} ?>

			<option value="<?php echo $link; ?>"<?php echo $select; ?>><?php echo $value->post_title; ?></option>

		<?php } ?>

	</select>

	<p class="description" style="font-size: .7em;">
		<?php echo esc_attr( $args['desc'] ); ?>
	</p>

	<?php
}

/**
 * [acs_tfs_field_checkbox				FRONT-OFFICE: Generated type checkbox setting field]
 * @param  [array] $args 				[Field parameters]
 * @return [string] 					[Print settings fields]
 */
function acs_tfs_field_checkbox( $args ) {
	$val = get_option( $args['options'] );
	$checked = '';
	if ( isset( $val[ $args['label'] ] ) && $val[ $args['label'] ] ) {
		$checked = 'checked';
	} ?>

	<input
		type="checkbox"
		name="<?php echo esc_attr( $args['options'] . '[' . $args['label'] . ']' ); ?>"
		value="1"
		<?php echo $checked; ?>
	/>

	<p class="description" style="font-size: .7em;">
		<?php echo esc_attr( $args['desc'] ); ?>
	</p>

	<?php
}

/**
 * [acs_tfs_field_textarea				FRONT-OFFICE: Generated textarea setting field]
 * @param  [array] $args 				[Field parameters]
 * @return [string] 					[Print settings fields]
 */
function acs_tfs_field_textarea( $args ) {
	$val = get_option( $args['options'] ); ?>

	<textarea
		name="<?php echo esc_attr( $args['options'] . '[' . $args['label'] . ']' ); ?>"
		rows="5"
		cols="60"><?php echo isset( $val[ $args['label'] ] ) ? $val[ $args['label']] :  '' ; ?></textarea>

	<p class="description" style="font-size: .7em;">
		<?php echo html_entity_decode( $args['desc'] ); ?>
	</p>

	<?php
}

function acs_tfs_field_refreshToken( $args ) {
	$val = get_option( $args['options'] );
	if (isset( $val[ $args['label'] ] ) && $val[ $args['label'] ] != '') {
		echo __( 'Salesforce account is connected', ACS_TFS_NAME );
	} else {
		$options = get_option( str_replace( '-', '_', ACS_TFS_NAME ) );
		$redirectUrl = home_url( 'tigrisoauth-callback.php' );
		$login_button_text = __('Login with SaleForce', ACS_TFS_NAME);
		$saleForceLoginUrl = 'https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=' . $options['consumer_key'] . '&redirect_uri=' . $redirectUrl;
		echo '<p class="sale-force-button"><a href="' . $saleForceLoginUrl . '">' . esc_html($login_button_text) . '</a></p>';
	}
}

/**
 * [acs_tfs_add_region_column 			CORE: Update columns list]
 * @param [array] $columns 				[All columns]
 * @return [array] 						[Update columns]
 */
function acs_tfs_add_region_column( $columns ) {
	$num = 4;

	$new_columns = array(
		'region'	=> __( 'Vacancy Region', ACS_TFS_NAME ),
		'education'	=> __( 'Vacancy Education', ACS_TFS_NAME ),
		'type'		=> __( 'Vacancy Type', ACS_TFS_NAME ),
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}
add_filter( 'manage_vacatures_posts_columns', 'acs_tfs_add_region_column', 4 );

/**
 * [acs_tfs_add_region_value 			BACK-OFFICE: Adding data to columns]
 * @param [string] $colname 			[Current column name]
 * @param [integer] $post_id     		[ID current post]
 * @return [hook]                  		[No return]
 */
function acs_tfs_add_region_value( $colname, $post_id ) {

		$meta_values = get_post_meta( $post_id );

		if ( $colname == 'region' ) {

			if ( isset( $meta_values['tigris__plaats__c'] ) && ! empty( $region = trim( $meta_values['tigris__plaats__c'][0] ) ) ) {
				echo $region;
			} else {
				echo '—';
			}
		}

		if ( $colname == 'type' ) {

			if( isset( $meta_values['tigris__soort_dienstverband__c'] ) && ! empty( $type = trim( $meta_values['tigris__soort_dienstverband__c'][0] ) ) ) {
				echo $type;
			} else {
				echo '—';
			}
		}

		if ( $colname == 'education' ) {

			if( isset( $meta_values['tigris__opleidingsniveau__c'] ) && ! empty( $education = trim( $meta_values['tigris__opleidingsniveau__c'][0] ) ) ) {
				echo $education;
			} else {
				echo '—';
			}
		}
}
add_filter( 'manage_vacatures_posts_custom_column', 'acs_tfs_add_region_value', 5, 2 );

/**
 * [acs_tfs_add_sortable_column 		BACK-OFFICE: Adding sortable to column]
 * @param  [array] $sortable_columns 	[Sortable columns]
 * @return [array] $sortable_columns   	[Update sortable columns]
 */
function acs_tfs_add_sortable_column( $sortable_columns ) {
	$sortable_columns['region'] 	= array( 'views_region', false );
	$sortable_columns['education'] 	= array( 'views_education', false );
	$sortable_columns['type'] 		= array( 'views_type', false );

	return $sortable_columns;
}
add_filter('manage_edit-vacatures_sortable_columns', 'acs_tfs_add_sortable_column');

/**
 * [acs_tfs_add_sortable_column_request BACK-OFFICE: Correcting request to sortable columns]
 * @param  [array] $vars 				[Query options]
 * @return [array] $vars   				[Updated query]
 */
function acs_tfs_add_sortable_column_request( $vars ) {

	if ( is_admin() && isset( $vars['orderby'] ) ) {

		switch ( $vars['orderby'] ) {
			case 'views_region':
				$vars['meta_key'] = 'tigris__plaats__c';
				$vars['orderby']  = 'meta_value';
				break;

			case 'views_education':
				$vars['meta_key'] = 'tigris__opleidingsniveau__c';
				$vars['orderby']  = 'meta_value';
				break;

			case 'views_type':
				$vars['meta_key'] = 'tigris__soort_dienstverband__c';
				$vars['orderby']  = 'meta_value';
				break;

			default:
				break;
		}
	}
	return $vars;
}
add_filter( 'request', 'acs_tfs_add_sortable_column_request' );
/**
 * END: 414;
 */