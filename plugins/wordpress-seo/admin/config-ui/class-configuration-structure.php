<?php
/**
 * WPSEO plugin file.
 *
 * @package WPSEO\Admin\ConfigurationUI
 */

/**
 * Class WPSEO_Configuration_Structure
 */
class WPSEO_Configuration_Structure {

	/** @var array Registered steps */
	protected $steps = array();

	/**
	 * List of fields for each configuration step.
	 *
	 * This list does not include the fields for the 'postTypeVisibility'
	 * step as that list will be generated on the fly.
	 *
	 * @var array
	 */
	private $fields = array(
		'intro'                      => array( 'configurationChoices' ),
		'environment_type'           => array( 'environment_type' ),
		'siteType'                   => array( 'siteType' ),
		'publishingEntity'           => array(
			'publishingEntity',
			'publishingEntityType',
			'publishingEntityCompanyName',
			'publishingEntityCompanyLogo',
			'publishingEntityPersonName',
		),
		'profileUrls'                => array(
			'socialProfilesIntro',
			'profileUrlFacebook',
			'profileUrlTwitter',
			'profileUrlInstagram',
			'profileUrlLinkedIn',
			'profileUrlMySpace',
			'profileUrlPinterest',
			'profileUrlYouTube',
			'profileUrlGooglePlus',
		),
		'multipleAuthors'            => array( 'multipleAuthors' ),
		'connectGoogleSearchConsole' => array(
			'googleSearchConsoleIntro',
			'connectGoogleSearchConsole',
		),
		'titleTemplate'              => array(
			'titleIntro',
			'siteName',
			'separator',
		),
		'newsletter'                 => array( 'mailchimpSignup' ),
		'suggestions'                => array( 'suggestions' ),
		'success'                    => array( 'successMessage' ),
	);

	/**
	 * WPSEO_Configuration_Structure constructor.
	 */
	public function initialize() {
		$this->add_step( 'intro', __( 'Welcome!', 'wordpress-seo' ), $this->fields['intro'], false, true );

		$this->add_step( 'environment_type', __( 'Environment', 'wordpress-seo' ), $this->fields['environment_type'] );
		$this->add_step( 'siteType', __( 'Site type', 'wordpress-seo' ), $this->fields['siteType'] );
		$this->add_step(
			'publishingEntity',
			__( 'Company or person', 'wordpress-seo' ),
			$this->fields['publishingEntity']
		);
		$this->add_step( 'profileUrls', __( 'Social profiles', 'wordpress-seo' ), $this->fields['profileUrls'] );

		$fields = array( 'postTypeVisibility' );

		$post_type_factory = new WPSEO_Config_Factory_Post_Type();
		foreach ( $post_type_factory->get_fields() as $post_type_field ) {
			$fields[] = $post_type_field->get_identifier();
		}
		$this->add_step( 'postTypeVisibility', __( 'Search engine visibility', 'wordpress-seo' ), $fields );

		$this->add_step(
			'multipleAuthors',
			__( 'Multiple authors', 'wordpress-seo' ),
			$this->fields['multipleAuthors']
		);
		$this->add_step(
			'connectGoogleSearchConsole',
			__( 'Google Search Console', 'wordpress-seo' ),
			$this->fields['connectGoogleSearchConsole']
		);
		$this->add_step( 'titleTemplate', __( 'Title settings', 'wordpress-seo' ), $this->fields['titleTemplate'] );

		$this->add_step( 'newsletter', __( 'Newsletter', 'wordpress-seo' ), $this->fields['newsletter'], true, true );
		$this->add_step( 'suggestions', __( 'You might like', 'wordpress-seo' ), $this->fields['suggestions'], true, true );
		$this->add_step( 'success', __( 'Success!', 'wordpress-seo' ), $this->fields['success'], true, true );
	}

	/**
	 * Add a step to the structure
	 *
	 * @param string $identifier Identifier for this step.
	 * @param string $title      Title to display for this step.
	 * @param array  $fields     Fields to use on the step.
	 * @param bool   $navigation Show navigation buttons.
	 * @param bool   $full_width Wheter the step content is full width or not.
	 */
	protected function add_step( $identifier, $title, $fields, $navigation = true, $full_width = false ) {
		$this->steps[ $identifier ] = array(
			'title'          => $title,
			'fields'         => $fields,
			'hideNavigation' => ! (bool) $navigation,
			'fullWidth'      => $full_width,
		);
	}

	/**
	 * Retrieve the registered steps
	 *
	 * @return array
	 */
	public function retrieve() {
		return $this->steps;
	}
}
