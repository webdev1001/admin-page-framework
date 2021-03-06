<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2014 Michael Uno; Licensed MIT
 * 
 */
if ( ! class_exists( 'AdminPageFramework_PageLoadInfo_NetworkAdminPage' ) ) :
/**
 * Collects data of page loads of the added pages.
 *
 * @since			3.1.0
 * @extends			AdminPageFramework_PageLoadInfo_Base
 * @package			AdminPageFramework
 * @subpackage		Debug
 * @internal
 */
class AdminPageFramework_PageLoadInfo_NetworkAdminPage extends AdminPageFramework_PageLoadInfo_Base {
	
	private static $_oInstance;
	private static $aClassNames = array();
	
	function __construct( $oProp, $oMsg ) {

		if ( is_network_admin() && defined( 'WP_DEBUG' ) && WP_DEBUG ) {

			add_action( 'network_admin_menu', array( $this, '_replyToSetPageLoadInfoInFooter' ), 999 );	// must be loaded after the sub pages are registered
			
		}
		parent::__construct( $oProp, $oMsg );
		
	}
		
	
	/**
	 * Ensures that only one instance of this class object exists per class. ( no multiple instances of this object on a particular class ) 
	 * 
	 * @remark			This class should be instantiated via this method.
	 */
	public static function instantiate( $oProp, $oMsg ) {

		if ( ! is_network_admin() ) { 
			return;
		}		
		
		if ( in_array( $oProp->sClassName, self::$aClassNames ) )
			return self::$_oInstance;
		
		self::$aClassNames[] = $oProp->sClassName;
		self::$_oInstance = new AdminPageFramework_PageLoadInfo_NetworkAdminPage( $oProp, $oMsg );
		
		return self::$_oInstance;
		
	}		
	
	/**
	 * Sets the hook if the current page is one of the framework's added pages.
	 * @internal
	 */ 
	public function _replyToSetPageLoadInfoInFooter() {
		
		// static $_fLoaded;
		// if ( $_fLoaded ) {
			// return;
		// }
		// $_fLoaded = true;
		
		// For added pages
		if ( $this->oProp->isPageAdded( isset( $_GET['page'] ) ? $_GET['page'] : '' ) ) {
			add_filter( 'update_footer', array( $this, '_replyToGetPageLoadInfo' ), 999 );
		}
		
	}		
	
}
endif;