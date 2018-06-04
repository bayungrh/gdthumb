<?php
/**
 * Google Drive Thumbnail Codeigniter Library
 * Digunakan untuk mendapatkan gambar thumbnail pada file dokumen (pdf, doc)
 * @author MuhBayu <bnugraha00@gmail.com>
 */
class Gdthumb
{
	protected static $gKey;
	protected $saveFilename;
	protected $savePath = FCPATH;
	function __construct($key=NULL)
	{
		if($key) Self::$gKey = $key;
	}
	public function setGoogleKey($key) {
		Self::$gKey = $key;
		return $this;
	}
	protected function drive_get($drive_id, $fields="*") {
		$devKey = Self::$gKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/drive/v3/files/$drive_id?fields=$fields&prettyPrint=true&key=$devKey");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	    $response    = curl_exec($ch);
	    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    $json      = json_decode($response);
	    curl_close($ch);
	    return $json;
	}
	public function thumbnail($drive_id, $params=NULL) {
		if($drive_id) {
			$drive = Self::drive_get($drive_id, "id,name,hasThumbnail,thumbnailLink");
			if(!isset($drive->error)) {
				if(isset($params['size'])) {
					$thumbnailLink = explode("=", $drive->thumbnailLink);
					$drive->thumbnailLink = "$thumbnailLink[0]=s$params[size]";
				}
				if(isset($params['path'])) {
					$this->savePath = $params['path'];
					if (isset($params['name'])) {
						$this->saveFilename = $params['name'];
					} else {
						$this->saveFilename = "$drive->id.png";
					}
					return Self::downloadContent($drive->thumbnailLink);
				} else {
					return print Self::getContent($drive->thumbnailLink);
				}
			}
		}
	}
	// Menyimpan gambar ke lokal
	protected function downloadContent($url) {
		$path = rtrim($this->savePath, '/');
		$ch = curl_init($url);
		$fp = fopen("$path/$this->saveFilename", 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		$exec = curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		return $exec;
	}
	// Menampilkan raw konten
	protected function getContent($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}