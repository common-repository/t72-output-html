<?php
$t72oh_config = new T72OhConfig();
?>
<div id="t72_docs">
<?php
if ( isset($_POST['t72oh_nonce'] )) {
	check_admin_referer('t72oh_action', 't72oh_nonce');
	$data = T72Util::sanitizeData($_POST['data']);
// print_r($data);
	update_option('t72oh_output_dir', $data['t72oh_output_dir']);
	update_option('t72oh_basic_auth_id', $data['t72oh_basic_auth_id']);
	update_option('t72oh_basic_auth_password', $data['t72oh_basic_auth_password']);
	update_option('t72oh_url_list', $data['t72oh_url_list']);
	update_option('t72oh_keyword_list', $data['t72oh_keyword_list']);

	echo '<p>保存しました。</p>';
} else {
	$data['t72oh_output_dir'] = get_option('t72oh_output_dir');
	$data['t72oh_basic_auth_id'] = get_option('t72oh_basic_auth_id');
	$data['t72oh_basic_auth_password'] = get_option('t72oh_basic_auth_password');
	$data['t72oh_url_list'] = get_option('t72oh_url_list');
	$data['t72oh_keyword_list'] = get_option('t72oh_keyword_list');
}
?>
<div class="table01">
<h3>参考値</h3>
<table>
<tr>
	<th>__FILE__ (PHP定数)</th>
	<td><?php echo __FILE__; ?></td>
</tr>
<tr>
	<th>jQuery version</th>
	<td>
	<span class="t72_jquery_version"></span>
	<script>
	(function($){
		$('.t72_jquery_version').html($().jquery);
	})(jQuery);
	</script>
	</td>
</tr>
</table>

<h3>設定</h3>
<form action="" method="post">
<?php wp_nonce_field('t72oh_action', 't72oh_nonce'); ?>
<table>
<tr>
	<th style="width: 17em;">WP 定数 ABSPATH</th>
	<td>
    <?php echo ABSPATH; ?><div>絶対パス</div>
    </td>
</tr>
<tr>
	<th>OUTPUT ディレクトリー</th>
	<td><input type="text" name="data[t72oh_output_dir]" value="<?php echo esc_attr($data['t72oh_output_dir']); ?>" style="width: 90%;">
	<p>最後の / は入力しない</p>
	<p>絶対パス</p>
	</td>
</tr>
<tr>
	<th>home_url</th>
	<td><?php echo $t72oh_config->g('home_url'); ?></td>
</tr>
<tr>
	<th>site_url</th>
	<td><?php echo $t72oh_config->g('site_url'); ?></td>
</tr>
<tr>
	<th>BASIC ID</th>
	<td>
	<input type="text" name="data[t72oh_basic_auth_id]" value="<?php echo esc_attr($data['t72oh_basic_auth_id']); ?>" style="width: 40%;">
	</td>
</tr>
<tr>
	<th>BASIC PW</th>
	<td><input type="password" name="data[t72oh_basic_auth_password]" value="<?php echo esc_attr($data['t72oh_basic_auth_password']); ?>" style="width: 40%;"></td>
</tr>
<tr>
	<th>URL 一覧</th>
	<td><textarea name="data[t72oh_url_list]" cols="60" rows="10"><?php echo esc_attr($data['t72oh_url_list']); ?></textarea></td>
</tr>
<tr>
	<th>置換用キーワード一覧</th>
	<td><textarea name="data[t72oh_keyword_list]" cols="60" rows="10"><?php echo esc_attr($data['t72oh_keyword_list']); ?></textarea></td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php require_once("inc_footer.php"); ?>
<!-- end #t72_docs --></div>
