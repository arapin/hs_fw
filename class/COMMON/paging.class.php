<?
/***************************************************
* Page_Link
*  -> 많은수의 디비레코드를 일정수로 나누어 한페이지에 보여줄 때
*     다른 레코드의 모임으로 이동하고자 하는 class
*
* 작성자 : 손지성
* 작성날짜 : 2002/6/20
* 수정 1)2002/9/28
	   2)2004/2/6
	   3)2005/3/23


	$page = $thispage;
	$record = $total;
	$link = $limit_end;
	$linking = 5;
	$url_file = "list_log.html";
	$url_parameter = "id=$id";

	$paging = new Paging();
	$paging->Link($page,$record,$link,$linking,$url_file,$url_parameter);
***************************************************/
 class Paging {
	var $page_link; // 현재페이지
	var $page_link_total; // 페이지링크의 전체 갯수
	var $page_link_start; // 한페이지에 보여질 페이지링크의 시작페이지
	var $page_link_end; // 한페이지에 보여질 페이지링크의 마지막페이지
	var $page_link_minus; // -페이지링크수의 페이지
	var $page_link_plus; // +페이지링크수의 페이지
	var $page_link_totalstart; // 전체 페이지링크의 시작페이지
	var $page_link_totalend; // 전체 페이지링크의 마지막페이지

/***************************************************
* Page()
*  -> 페이지수를 구하는 함수.
*
* $page : 현재페이지를 나타내는 변수
***************************************************/
	function Page($page) {
		$this->page_link = (!$page) ? 1 : $page;
	}

/***************************************************
* Total_Page()
*  -> 전체페이지링크수를 구하는 함수.
*
* $record : 디비레코드
* $link : 한페이지에 보여질 페이지링크 갯수
***************************************************/
	function Total_Page($record,$link) {
		$this->page_link_total = (($record % $link) == 0) ? ($record / $link) : intval($record / $link)+1;
	}

/***************************************************
* Link()
*  -> 실제로 화면에 보여지는 함수.
*
* $page : 현재페이지
* $record : 전체 디비레코드 수
* $link : 한페이지에 보여질 페이지링크 수
* $url_file : 링크될 페이지
* $url_parameter : 링크될 페이지에서 참고할 파라미터값
***************************************************/
	function Link($page,$record,$link,$linking,$url_file,$url_parameter) {
		$this->Page($page);
		$this->Total_Page($record,$link);
		$this->Start_Page($page,$record,$linking);
		$this->End_Page($page,$record,$linking);

		// 링크할 경로와 파라미터값을 구한다.
		$url = (strlen($url_file) > 0) ? $url_file : $PHP_SELF;
		$url .= (strlen($url_parameter) > 0) ? "?".$url_parameter."&" : "?";

		$block = ceil($page/$linking);
		$this->page_link_totalstart = $this->page_link_start - 1; // -페이지링크 수
		$this->page_link_totalend = ($linking * $block) + 1; // +페이지링크 수

		$return = "";

		// 전체 페이지링크의 시작페이지를 보여준다.
		if($this->page_link > $linking) {
			$return .= "
				<a href=\"".$url."\"><input type=\"button\" value=\"<<\" /></a>
				<a href='".$url."page=".$this->page_link_totalstart."' class='pga'> <input type=\"button\" value=\"<\" /></a>
			";
		}

		// 페이지링크를 보여준다.
		for($i=$this->page_link_start; $i<=$this->page_link_end; $i++)
		{

			if($i == $this->page_link_end){
				$return_class = "bgn";
			}else{
				$return_class = "";
			}

			if($this->page_link == $i) $return .= "<input type=\"button\" value=\"".$i."\" class=\"paging_select\" />";
			else $return .= "<a href='".$url."page=$i'><input type=\"button\" value=\"".$i."\" /></a>";

			/*
			if($i == $this->page_link_end){
				$return .= " &nbsp; ";
			}else{
				$return .= " &nbsp;&nbsp;|&nbsp; ";
			}
			*/
		}

		// 전체 페이지링크의 마지막페이지를 보여준다.
		if($this->page_link_totalend <= $this->page_link_total) {
			$return .= "
                <a href='".$url."page=".$this->page_link_totalend."' class='pga'><input type=\"button\" value=\">\" /></a>
                <a href=\"".$url."page=".$this->page_link_total."\"><input type=\"button\" value=\">>\" /></a>
			";
		}


		return $return;
	}

/***************************************************
* Link_Search()
*  -> 실제로 화면에 보여지는 함수.
*
* $page : 현재페이지
* $record : 전체 디비레코드 수
* $link : 한페이지에 보여질 페이지링크 수
* $url_file : 링크될 페이지
* $url_parameter : 링크될 페이지에서 참고할 파라미터값
***************************************************/
	function Link_Search($page,$record,$link,$linking,$url_file,$url_parameter) {
		$this->Page($page);
		$this->Total_Page($record,$link);
		$this->Start_Page($page,$record,$linking);
		$this->End_Page($page,$record,$linking);

		// 링크할 경로와 파라미터값을 구한다.
		$url = (strlen($url_file) > 0) ? $url_file : $PHP_SELF;
		$url .= (strlen($url_parameter) > 0) ? "?".$url_parameter."&" : "?";

		$block = ceil($page/$linking);
		$this->page_link_totalstart = $this->page_link_start - 1; // -페이지링크 수
		$this->page_link_totalend = ($linking * $block) + 1; // +페이지링크 수

		$return = "";

		// 전체 페이지링크의 시작페이지를 보여준다.
		if($this->page_link > $linking) {
			$return .= "
				<a href='".$url."page=".$this->page_link_totalstart."' class='pga'> <button class=\"paging_btn\"><img src=\"/images/paging_prev.gif\" /></button></a>
			";
		}

		// 페이지링크를 보여준다.
		for($i=$this->page_link_start; $i<=$this->page_link_end; $i++)
		{

			if($i == $this->page_link_end){
				$return_class = "bgn";
			}else{
				$return_class = "";
			}

			if($this->page_link == $i) $return .= "<button class=\"paging_btn2\">".$i."</button>";
			else $return .= "<a href='".$url."page=$i'><button class=\"paging_btn\">".$i."</button></a>";

			/*
			if($i == $this->page_link_end){
				$return .= " &nbsp; ";
			}else{
				$return .= " &nbsp;&nbsp;|&nbsp; ";
			}
			*/
		}

		// 전체 페이지링크의 마지막페이지를 보여준다.
		if($this->page_link_totalend <= $this->page_link_total) {
			$return .= "
                <a href='".$url."page=".$this->page_link_totalend."' class='pga'><button class=\"paging_btn\"><img src=\"/images/paging_next.gif\" alt=\"\" /></button></a>
			";
		}


		return $return;
	}

/***************************************************
* Link_Search()
*  -> 실제로 화면에 보여지는 함수.
*
* $page : 현재페이지
* $record : 전체 디비레코드 수
* $link : 한페이지에 보여질 페이지링크 수
* $url_file : 링크될 페이지
* $url_parameter : 링크될 페이지에서 참고할 파라미터값
***************************************************/
	function Link_Memo($page,$record,$link,$linking,$url_file,$url_parameter) {
		$this->Page($page);
		$this->Total_Page($record,$link);
		$this->Start_Page($page,$record,$linking);
		$this->End_Page($page,$record,$linking);

		// 링크할 경로와 파라미터값을 구한다.
		$url = (strlen($url_file) > 0) ? $url_file : $PHP_SELF;
		$url .= (strlen($url_parameter) > 0) ? "?".$url_parameter."&" : "?";

		$block = ceil($page/$linking);
		$this->page_link_totalstart = $this->page_link_start - 1; // -페이지링크 수
		$this->page_link_totalend = ($linking * $block) + 1; // +페이지링크 수

		$return = "";

		// 전체 페이지링크의 시작페이지를 보여준다.
		if($this->page_link > $linking) {
			$return .= "
				<a href='".$url."memoPage=".$this->page_link_totalstart."' class='pga'> <button class=\"paging_btn\"><img src=\"/images/paging_prev.gif\" /></button></a>
			";
		}

		// 페이지링크를 보여준다.
		for($i=$this->page_link_start; $i<=$this->page_link_end; $i++)
		{

			if($i == $this->page_link_end){
				$return_class = "bgn";
			}else{
				$return_class = "";
			}

			if($this->page_link == $i) $return .= "<button class=\"paging_btn2\">".$i."</button>";
			else $return .= "<a href='".$url."memoPage=$i'><button class=\"paging_btn\">".$i."</button></a>";

			/*
			if($i == $this->page_link_end){
				$return .= " &nbsp; ";
			}else{
				$return .= " &nbsp;&nbsp;|&nbsp; ";
			}
			*/
		}

		// 전체 페이지링크의 마지막페이지를 보여준다.
		if($this->page_link_totalend <= $this->page_link_total) {
			$return .= "
                <a href='".$url."memoPage=".$this->page_link_totalend."' class='pga'><button class=\"paging_btn\"><img src=\"/images/paging_next.gif\" alt=\"\" /></button></a>
			";
		}


		return $return;
	}

/***************************************************
* Link_Search()
*  -> 실제로 화면에 보여지는 함수.
*
* $page : 현재페이지
* $record : 전체 디비레코드 수
* $link : 한페이지에 보여질 페이지링크 수
* $url_file : 링크될 페이지
* $url_parameter : 링크될 페이지에서 참고할 파라미터값
***************************************************/
	function Link_Mobile($page,$record,$link,$linking,$url_file,$url_parameter) {
		$this->Page($page);
		$this->Total_Page($record,$link);
		$this->Start_Page($page,$record,$linking);
		$this->End_Page($page,$record,$linking);

		// 링크할 경로와 파라미터값을 구한다.
		$url = (strlen($url_file) > 0) ? $url_file : $PHP_SELF;
		$url .= (strlen($url_parameter) > 0) ? "?".$url_parameter."&" : "?";

		$block = ceil($page/$linking);
		$this->page_link_totalstart = $this->page_link_start - 1; // -페이지링크 수
		$this->page_link_totalend = ($linking * $block) + 1; // +페이지링크 수

		$return = "";

		// 전체 페이지링크의 시작페이지를 보여준다.
		if($this->page_link > $linking) {
			$return .= "
				<a href='".$url."memoPage=".$this->page_link_totalstart."' class='pga'> <button class=\"paging_btn\"><img src=\"/images/mobile/paging_prev.gif\" /></button></a>
			";
		}

		// 페이지링크를 보여준다.
		for($i=$this->page_link_start; $i<=$this->page_link_end; $i++)
		{

			if($i == $this->page_link_end){
				$return_class = "bgn";
			}else{
				$return_class = "";
			}

			if($this->page_link == $i) $return .= "<button class=\"paging_btn2\">".$i."</button>";
			else $return .= "<a href='".$url."memoPage=$i'><button class=\"paging_btn\">".$i."</button></a>";

			/*
			if($i == $this->page_link_end){
				$return .= " &nbsp; ";
			}else{
				$return .= " &nbsp;&nbsp;|&nbsp; ";
			}
			*/
		}

		// 전체 페이지링크의 마지막페이지를 보여준다.
		if($this->page_link_totalend <= $this->page_link_total) {
			$return .= "
                <a href='".$url."memoPage=".$this->page_link_totalend."' class='pga'><button class=\"paging_btn\"><img src=\"/images/mobile/paging_next.gif\" alt=\"\" /></button></a>
			";
		}


		return $return;
	}
/***************************************************
* Start_Page()
*  -> 한페이지에 보여질 페이지링크의 시작페이지
*
* $page : 현재 페이지
* $record : 총 디비레코스 수
* $link : 한페이지에 보여질 페이지링크 수
***************************************************/
	function Start_Page($page,$record,$linking) {
		$this->page_link_start = intval(($this->page_link-1)/$linking+1)*$linking-($linking-1); //한페이지에 나타낼 페이지링크시작
	}

/***************************************************
* End_Page()
*  -> 한페이지에 보여질 페이지링크의 마지막페이지
*
* $page : 현재페이지
* $record : 총 디비레코드 수
* $link : 한페이지에 보여질 페이지링크 수
***************************************************/
	function End_Page($page,$record,$linking) {
		$this->page_link_end = $this->page_link_start+($linking-1);
		if($this->page_link_end > $this->page_link_total) $this->page_link_end = $this->page_link_total;
	}
}
?>