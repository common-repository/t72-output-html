<?php

if ( !function_exists('t72_admin_head_customize') ) {
	function t72_admin_head_customize() {
		echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'assets/style_admin.css' , __FILE__ ) . '" />';
	}
	add_action('admin_head', 't72_admin_head_customize', 100);
}

class T72OhConfig {

	private $config = array();

	function __construct() {
		$base_dir = get_option('t72oh_base_dir');
		$this->config['output_dir'] = get_option('t72oh_output_dir');
		$this->config['home_url'] = home_url(); // サイトのアドレス（URL)
		$this->config['site_url'] = site_url(); // WordPressのアドレス（URL)
		$this->config['basic_auth_id'] = get_option('t72oh_basic_auth_id');
		$this->config['basic_auth_password'] =get_option('t72oh_basic_auth_password') ;
		$this->config['url_list'] = get_option('t72oh_url_list');
		$this->config['keyword_list'] = get_option('t72oh_keyword_list');
	} // __construct

    public function set( $key=null, $value=null ) {
		$this->config[$key] = $value;
	}

    public function g( $key=null ) {
		if ( empty($key) ) {
			return '';
		} else {
			return $this->config[$key];
		}
	} // g

    public function d( $key=null ) {
		echo self::g($key);
		return ;
	} // d

} // class
?>
