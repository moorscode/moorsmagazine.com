<?php
namespace moorsmagazine\WordPress;

class Integration_Group implements Integration {

	/** @var Integration[] List of integrations */
	protected $integrations = array();

	public function __construct( array $integrations ) {
		$this->integrations = $integrations;
	}

	/**
	 * Initializes all registered integrations.
	 */
	public function initialize() {
		array_map(
			function( Integration $integration ) {
				$integration->initialize();
			},
			$this->integrations
		);
	}
}
