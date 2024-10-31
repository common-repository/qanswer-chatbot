<?php
/**
 * QAnswer Chatbot - AI conversational assistant
 * 
 * @package QAnswerChatbot
 * @version 1.0.1
 * @copyright 2024 The QA Company
 * @author The QA Company
 * @license GPL-2.0
 *
 * @wordpress-plugin
 * Plugin Name: QAnswer Chatbot - AI conversational assistant
 * Plugin URI: http://wordpress.org/plugins/qanswer-chatbot/
 * Description: QAnswer AI conversational assistant integrated in your website effortlessly. Bring the power of AI to your website and improve your customer experience.
 * Author: The QA Company
 * Version: 1.0.1
 * Author URI: https://the-qa-company.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

include(plugin_dir_path( __FILE__ ) . 'QAnswerChatbotSettings.php');

class QACB_QAnswerChatbot {

	private QACB_QAnswerChatbotSettings $settings;

	function __construct() {
		add_action( 'init', [ $this, 'createSettings' ] );
		add_action( 'wp_head', [ $this, 'displayWidget' ] );
	}

	public function createSettings() {
		$this->settings = QACB_QAnswerChatbotSettings::getInstance();
	}

	// Now we set that function up to execute when the admin_notices action is called.
	public function displayWidget() {
		$dataset = $this->getDataset();
		$username = $this->getUsername();
		if ( !$dataset || !$username ) return;
		printf(
			'<iframe src="https://app.qanswer.ai/widget?kb=%s&amp;user=%s&amp;type=text" id="qanswer-widget" allow="microphone; clipboard-write" referrerpolicy="origin" frameborder="0" style="border:none;overflow:hidden;display:none;position:fixed;right:16px;bottom:16px;z-index:9999;" allowtransparency="true" onload="var iframe = this;window.addEventListener(\'message\', function (e) {if (e.origin !== \'https://app.qanswer.ai\') return;if (e.data.type === \'eval\') Function(e.data.code).call(null, iframe);});"></iframe>',
			esc_html( $this->getDataset() ),
			esc_html( $this->getUsername() )
		);
	}

	public function getUsername(): ?string {
		return $this->getOptions()['username'] ?? null;
	}

	public function getDataset(): ?string {
		return $this->getOptions()['kb'] ?? null;
	}

	private function getOptions(): array {
		return get_option( 'wporg_options', [] );
	}

}

if (!defined('ABSPATH')) exit; // Exit if accessed directly

new QACB_QAnswerChatbot();
