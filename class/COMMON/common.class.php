<?
	class Common {

		public function finalMove($type, $msg, $com, $pram,  $addPram=""){
			if($type == "lnd"){
				echo "
					<script>
						alert('".$msg."');
						location.href = \"/?com=".$com."&lnd=".$pram.$addPram."\";
					</script>
				";
			}else if($type == "pro"){
				echo "
					<script>
						alert('".$msg."');
						location.href = \"/?com=".$com."&pro=".$pram."\";
					</script>
				";
			}
		}

		public function finalMoveMng($type, $msg, $com, $pram, $addPram="",$url=""){
			if($type == "lnd"){
				echo "
					<script>
						alert('".$msg."');
						location.href = \"/?com=".$com."&lnd=".$pram.$addPram."&mng=Y\";
					</script>
				";
				exit;
			}else if($type == "pro"){
				echo "
					<script>
						alert('".$msg."');
						location.href = \"/?com=".$com."&pro=".$pram."&mng=Y\";
					</script>
				";
				exit;
			}else if($type == "url"){
				echo "
					<script>
						alert('".$msg."');
						location.href = \"".$url."\";
					</script>
				";
				exit;
			}
		}

		// ----------------------------------------------------------------------
		// 이미지 업로드
		// ----------------------------------------------------------------------
		function imageUploader($Image1, $Image1_name, $Image1_size, $fullpath_to_upload_dir, $max_width, $max_height, $max_size, $no_ext='')
		{
			$tmp_dir = '';
			$file_dir_arr = explode("/",  $fullpath_to_upload_dir);
			for ( $i = 0 ; $i < count($file_dir_arr); $i++ ) {
				//$tmp_dir .= "/"."$file_dir_arr[$i]";
				$tmp_dir .= "$file_dir_arr[$i]"."/";
				if(!is_dir($tmp_dir))
				{
					@mkdir($tmp_dir,0777);
					@chmod($tmp_dir,0755);
				}
			}

			if(!empty($Image1_name)) {

				######################
				#   1 = GIF,
				#   2 = JPG,
				#   3 = PNG,
				#   4 = SWF,
				#   5 = PSD,
				#   6 = BMP,
				#   7 = TIFF(intel byte order),
				#   8 = TIFF(motorola byte order),
				#   9 = JPC,
				#   10 = JP2,
				#   11 = JPX,
				#   12 = JB2,
				#   13 = SWC,
				#   14 = IFF,
				#   15 = WBMP,
				#   16 = XBM
				######################

				$pic = getimagesize($Image1); //$ext = exif_imagetype($Image1);
				//key_print($pic);
				if((($pic[2] >= 1) && ($pic[2] <= 4)) || $pic[2] == 13)
				{

					$pictmp = explode(".", $Image1_name); // 파일이름을 추출한다. '/'으로 구분후 맨마지막것을 가져옴
					$Image1Ext = $pictmp[count($pictmp)-1];

					//사용자 지정 확장자 필터링
					if($no_ext) {
						if($pic[2] == $no_ext){
							return "01";
							exit;
						}
					}

					//크기 검사(플래시 파일은 제외)
					/*if($pic[2] != 4)
					{
						if(($pic[0] > $max_width) || ($pic[1] > $max_height)) {
							@unlink($Image1); //파일 삭제한다
							return "02";
							exit;
						}
					}*/

					//용량 검사
					/*if($Image1_size > $max_size)
					{
						@unlink($Image1); //파일 삭제한다
						return "03";
						exit;
					}*/

					//파일명 생성 & 디렉토리 저장
					mt_srand((double)microtime()*1000000);
					$random_num = mt_rand(1, 100000);
					$Image1_name=time().'_'.$random_num.'.'.$Image1Ext;
					$Image1_path=$fullpath_to_upload_dir.'/'.$Image1_name;
					$a = move_uploaded_file($Image1, $Image1_path);

					if(!$a){
						return "04";
						exit;
					}

				}
				//확장자가 이미지가 아닌 경우
				else
				{
					@unlink($Image1); //파일 삭제한다
					return "05";
					exit;
				}
			}
			//return ($Image1_name) ? $Image1_name : 0;
			// 에러처리때문에 0은 될수 없다!
			return $Image1_name;
		}

		function fileUploader($file, $file_name, $file_size, $fullpath_to_upload_dir, $max_size, $no_ext='')
		{
			$tmp_dir = '';
			$file_dir_arr = explode("/",  $fullpath_to_upload_dir);
			for ( $i = 0 ; $i < count($file_dir_arr); $i++ ) {
				//$tmp_dir .= "/"."$file_dir_arr[$i]";
				$tmp_dir .= "$file_dir_arr[$i]"."/";
				if(!is_dir($tmp_dir))
				{
					@mkdir($tmp_dir,0777);
					@chmod($tmp_dir,0755);
				}
			}

			$pictmp = explode(".", $file_name); // 파일이름을 추출한다. '/'으로 구분후 맨마지막것을 가져옴
			$fileExt = strtolower($pictmp[count($pictmp)-1]);

			if( preg_match("/\.php|\.php3|\.phtml|\.htm|\.html|\.inc|\.class|\.htaccess|\.lib/i",$fileExt) ) {
					popup_msg(fileExt.' 파일은 업로드가 불가능한 파일입니다.', 'back');
			}

			if($file_size > $max_size)
			{
				popup_msg('파일 용량이 초과하였습니다.', 'back');
			}

			mt_srand((double)microtime()*1000000);
			$random_num = mt_rand(1, 100000);
			$file_name=time().'_'.$random_num.'.'.$fileExt;
			$file_path=$fullpath_to_upload_dir.'/'.$file_name;

			if(move_uploaded_file($file, $file_path))
			{
				@unlink($file);
				return $file_name;
			}
			else
			{
				@unlink($file);
				popup_msg('파일 업로드 오류입니다.', 'back');
			}
		}

		public function getAuthNum($authNumLength, $authNumString=""){

			$defaultString = "0123456789";
			srand((double)microtime()*1000000);

			if ( $authNumString == "" ){
				//$couponString의 값이 정해지지 않았다면 $defaultString 값으로 사용
				$authNumString = $defaultString;
			}

			$length = strlen($authNumString);

			for($i=0;$i<$authNumLength;$i++)
			{
				$authStr = rand(0,$length-1); //0에서 $defaultString또는 $couponString의 길이사이의 난수를 구한다
				$resultStr .= substr( $authNumString, $authStr, 1 );
			}

			return $resultStr;
		}

		// ----------------------------------------------------------------------
		// euc-kr 문자열 자르기
		// ----------------------------------------------------------------------
		public function cutstr($string, $max, $suffix='...')
		{
			if(strlen($string)<=$max+strlen($suffix)/2) return $string;
			for ($i=$max-1; ord($string[$i])>127 && $i >= 0; $i--);
			return ($max-$i)&1 ? trim(substr($string,0,$max)).$suffix : trim(substr($string,0,$max-1)).$suffix;
		}

		// ----------------------------------------------------------------------
		// UTF-8 글자 자르기
		// ----------------------------------------------------------------------
		public function strcut_utf8($str, $len, $checkmb=false, $tail='…') {
			// global $str,$len,$checkmb,$tail;
			preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
			$m    = $match[0];
			$slen = strlen($str);  // length of source string
			$tlen = strlen($tail); // length of tail string
			$mlen = count($m);    // length of matched characters

			if ($slen <= $len) return $str;
			if (!$checkmb && $mlen <= $len) return $str;

			$ret  = array();
			$count = 0;

			for ($i=0; $i < $len; $i++) {
				$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
				if ($count + $tlen > $len) break;
				$ret[] = $m[$i];
			}
			return join('', $ret).$tail;
		}

	}
?>