<?php
$t72oh_config = new T72OhConfig();

$url_list_arr = T72Util::getLineArray( $t72oh_config->g('url_list') );

if ( isset($_POST['t72oh_nonce'] )) {
	check_admin_referer('t72oh_action', 't72oh_nonce');
	$write_dir = T72Util::getNextDirectory( $t72oh_config->g('output_dir') . '/' . T72Date::getToday("Ymd") );

	// 実行
	foreach ( $url_list_arr as $path ) {
		
		if ( $t72oh_config->g('basic_auth_id')!='' && $t72oh_config->g('basic_auth_password')!='' ) { // BASIC 認証 あり
			$target_url = T72Util::makeBasicAuthUrl(
				$t72oh_config->g('home_url') . '/' . $path
				, $t72oh_config->g('basic_auth_id')
				, $t72oh_config->g('basic_auth_password')
			);
		} else { // BASIC 認証 なし
			$target_url = $t72oh_config->g('home_url') . '/' . $path;
		}

		// 読込み、キーワード置換もする。
		$data = T72Util::readFileReplaceKeyword($target_url, T72Util::getKeyValueLine($t72oh_config->g('keyword_list')));

		// 文字コード変換
		$data = mb_convert_encoding($data, "SJIS", "UTF-8");

		// 書込み
		$write_path = $write_dir . '/' . $path;
		T72Util::mkdirPath($write_path); // ディレクトリーをつくっておく
		
		if ( !is_dir($write_path) ) {
			$fp = fopen( $write_path, "w");
			fwrite( $fp, $data );
			fclose( $fp );
		} // is_dir
	} // foreach

	// wp 画像をコピーする。/web/blog/7-2/wp/wp-content
	// echo $write_dir . '/' . 'uploads';
	T72Util::copyDirRecursive(
		ABSPATH.'wp-content/uploads'
		, $write_dir . '/csr/images/' . 'uploads'
	);
	
	// 圧縮
	T72Util::zipExec( $write_dir );

} // if isset($_POST['t72oh_nonce']
?>
<div id="t72_docs">
<div class="table01">
<h1>Output HTML</h1>
<table>
<!--
<tr>
	<th style="width: 17em;">出力フォルダーのパス</th>
	<td><?php echo $t72oh_config->g('output_dir' ); ?></td>
</tr>
<tr>
	<th>対象パス（テキスト）</th>
	<td><pre><?php $t72oh_config->d('url_list'); ?></pre></td>
</tr>
<tr>
	<th>今日</th>
	<td><pre><?php echo T72Date::getToday("Ymd"); ?></pre></td>
</tr>
<tr>
	<th>次のDIR</th>
	<td><pre><?php echo T72Util::getNextDirectory( $t72oh_config->g('output_dir' ) . '/' . T72Date::getToday("Ymd") ); ?></pre></td>
</tr>
-->
<tr>
	<th style=" width: 30%;">対象パス 一覧</th>
	<td>
	<ul>
	<?php
	if ( !empty($url_list_arr) ) {
		foreach( $url_list_arr as $arr ) {
			echo '<li><a href="' . $t72oh_config->g('home_url' ) . '/' . $arr . '" target="_blank">'.$arr.'</a></li>';
		} // foreach
	}
	?>
	</ul>
	</td>
</tr>
<tr>
	<th>キーワード</th>
	<td><?php echo T72Util::getHtmlTableFrom2DimensionalArray(
						T72Util::getKeyValueLine($t72oh_config->g('keyword_list'))
						, array('変換前', '変換後')
					); ?></td>
</tr>
<tr>
	<th>出力フォルダーの一覧</th>
	<td>
	<ul>
	<?php
		$dir_list = T72Util::getDirectoryList($t72oh_config->g('output_dir'));
		rsort($dir_list);
		for( $i=0; $i<10; $i++ ) {
			echo '<li><a href="' . $t72oh_config->g('home_url' ) . '/_files/output_html/' . $dir_list[$i] . '" target="_blank">'.$dir_list[$i].'</a></li>';
		} // for
	?>
	</ul>
	</td>
</tr>
</table>

<form action="" method="post">
<?php wp_nonce_field('t72oh_action', 't72oh_nonce'); ?>
<?php submit_button(); ?>
</form>

<!-- end .table01 --></div>
<!-- end #t72_docs --></div>
