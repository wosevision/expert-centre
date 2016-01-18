<?php 
  const KEY = "gznwwcp0";
  const SECRET = "6b0b2bbf-3df9-4fa2-b5c0-251f1d1db2ee";
  const ID = "4844";

	function getAccessToken($key, $secret, $uri){
		$consumer_key = urlencode($key);
		$consumer_secret = urlencode($secret);
		$req_url = urlencode($uri);

		$ch = curl_init("https://public-api.expertfile.com/v1/" . ID . "/accessToken?oauth_consumer_key=" . $consumer_key . "&oauth_consumer_secret=" . $consumer_secret . "&request_uri=" . $req_url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$responsefromwcf = curl_exec($ch);

		curl_close($ch);

		$responseData = json_decode($responsefromwcf);

		if($responseData->success){
			return $responseData->data->authorization;
		}
		else{
			return $responseData->msg;
		}
	}
	   
	function getResults($currPage, $keyword, $availability, $industry, $sort, $pagesize){
		$consumer_key = KEY;
		$consumer_secret = SECRET;
		$req_url = 'https://public-api.expertfile.com/v1/organization/' . ID . '/search';

		$oauth = getAccessToken($consumer_key,$consumer_secret,$req_url);

		$parameters = array(
		'fields' => urlencode('user:username,user:firstname,user:lastname,user:job_title,tagline,user:location:city,avatar:l:url,user:location:state,user:location:country,engagement:topics'),
		'keywords' => urlencode(''),
		'location' => urlencode(''),
		'industry' => urlencode($industry),
		'portfolio' => urlencode(''),
		'availability' => urlencode($availability),
		'fee_min' => urlencode(''),
		'fee_max' => urlencode(''),
		'sort' => urlencode($sort),
		'page_number' => urlencode($currPage),
		'page_size' => $pagesize,
		'keyword' => urlencode($keyword),
		);

		$req_url = $req_url;
		$params = http_build_query($oauth) . '&' .http_build_query($parameters);

		$ch = curl_init($req_url . '?' . $params);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$responsefromwcf = curl_exec($ch);

		curl_close($ch);

		$responseData = json_decode($responsefromwcf);

		return $responseData;
	}

	function getExpert($username){
		$consumer_key = KEY;
		$consumer_secret = SECRET;
		$req_url = 'https://public-api.expertfile.com/v1/organization/' . ID . '/speaker/' . $username;

		$oauth = getAccessToken($consumer_key,$consumer_secret,$req_url);
		$parameters = array();
		$req_url = $req_url;
		$params = http_build_query($oauth) . '&' .http_build_query($parameters);

		$ch = curl_init($req_url . '?' . $params);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$responsefromwcf = curl_exec($ch);

		curl_close($ch);

		$responseData = json_decode($responsefromwcf);

		return $responseData;
	}
	function getFilter($currPage, $keyword,$availability,$industry){		
		$consumer_key = KEY;
		$consumer_secret = SECRET;
		$req_url = 'https://public-api.expertfile.com/v1/organization/' . ID . '/getfilters';		
		
		$oauth = getAccessToken($consumer_key,$consumer_secret,$req_url);

		$req_url = $req_url;
		$params = http_build_query($oauth);

		$ch = curl_init($req_url . '?' . $params);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		$responsefromwcf = curl_exec($ch);

		curl_close($ch);
		
		$responseData = json_decode(urldecode($responsefromwcf));	
		
		return $responseData;
	}
	function buildPagination($page, $total, $size){
		$numberOfPage = ceil($total/$size);
		$pagination = '<div class="pagination-centered"><ul class="pagination" role="menubar" aria-label="Pagination">';
		
		if($numberOfPage == 1) return "";
		
		if($page != 1){
			if(isset($_GET["q"])){
				$pagination .= '<li><a data-page="1" href="?p=1">First</a></li>
					<li class="arrow"><a data-page="' . ($page - 1) . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . ($page - 1) . '">&laquo; Previous</a>';			
			}else{
				$pagination .= '<li><a data-page="1" href="?p=1">First</a></li>
					<li class="arrow"><a data-page="' . ($page - 1) . '" href="?p=' . ($page - 1) . '">&laquo; Previous</a></li>';
			}	
		}
		
		for ($i = 1; $i <= $numberOfPage; $i++) {
			if ($i != $page){
				if(isset($_GET["q"])){
					$pagination .= '<li><a data-page="' . $i . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . $i . '">' . $i . '</a></li>';		
				} else {
					$pagination .= '<li><a data-page="' . $i . '" href="?p=' . $i . '">' . $i . '</a></li>';
				}				
			} else {
				$pagination .= '<li class="current"><a disabled>' . $i . '</a></li>';
			}
		}
		
		if ($page < $numberOfPage) {
			if(isset($_GET["q"])){
				$pagination .= '<li><a data-page="' . ($page + 1) . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . ($page + 1) . '">Next &raquo;</a></li>
					<li><a data-page="' . $numberOfPage . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . $numberOfPage . '">Last</a></li>';	
			} else {
				$pagination .= '<li><a data-page="' . ($page + 1) . '" href="?p=' . ($page + 1) . '">Next &raquo;</a></li>
					<li><a data-page="' . $numberOfPage . '" href="?p=' . $numberOfPage . '">Last</a></li>';
			}		
		}
		$pagination .= '</ul></div>';
		
		return $pagination;
	}		
	function getSearchInfo($currPage, $total, $pageSize) {
		$p = 1;
		$o = $pageSize; 
		if($currPage != 1){
			$p = (($currPage - 1) * $pageSize) + 1;
			$o = (($currPage - 1) * $pageSize) + $pageSize;
			
			if($o > $total){
				$o = $total;
			}
		}else{
			if($total <= $o){
				$o = $total;
			}		
		}

		return 'Showing <strong>' . $p . '</strong> - <strong>' . $o . '</strong>' . ' of <strong>' . $total . '</strong>';
	}
