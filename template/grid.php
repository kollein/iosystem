<?php
class Template_grid {
	public $_map_go_view;

	public function __construct ($map_go_view) {
		$this->_map_go_view = $map_go_view;
	}

	public function grid_3_json ($rows, $TABLE) {
		$data_return['query'] = 'iamquery';
		$data_return['items'] = [];
		
		foreach ( $rows as $row ) {
			$alias_book_case_table = $this->_map_go_view[$TABLE];
			$urlTitle = convertAlias($row['TITLE'], true);
			$url_go_post = generate_url_by_map([$alias_book_case_table, $row['ID'], $urlTitle], true, true);
			$getIMG = get_link_img_from_str($row['IMAGE']);
			// SETUP DATA
			$item_data = [
				"id" => $row['ID'],
				"link" => $url_go_post,
				// "imgUrl" => $getIMG[0],
				"imgUrl" => CDN_DOMAIN.substr($getIMG[0], 2),
				"multitab" => count($getIMG)
			];
			array_push($data_return['items'], $item_data);
		}
		return $data_return;
	}

	public function grid_3_json_rp ($start, $end) {
		$data_return['query'] = 'iamquery';
		$data_return['items'] = [];
		// 
		$d = ROOT_DIR.IMG_CDN_REAL_PHOTO;
		$images = array();                 
		$dir = opendir($d);

		while ( $f = readdir($dir) ) {
			if ( eregi(".jpg",$f) ) {
				array_push($images,"$f");
			}
		}
		closedir($dir);

		$images = array_reverse($images);
		// echo $start.' : '.$end.' | '.count($images);
		$images = array_slice($images, $start, $end);

		foreach ( $images as $image ) {
			$urlImage = URLBASE.IMG_CDN_REAL_PHOTO.'/'.$image;
			// SETUP DATA
			$item_data = [
				"id" => 0,
				"link" => '#',
				"imgUrl" => $urlImage,
				"multitab" => 0,
				"start" => $start,
				"end" => $end
			];
			array_push($data_return['items'], $item_data);
		}
		return $data_return;
	}
}
?>