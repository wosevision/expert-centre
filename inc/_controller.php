<?php
if (isset($_GET["expert"])) {
	$expertName = $_GET["expert"];
	$expert = getExpert($expertName);

	$expert = $expert->speaker;
} else {
	$experts = array();
	$currPage = (isset($_GET["p"]) ? $_GET["p"] : 1);
	$keyword = (isset($_GET["q"]) ? $_GET["q"] : "");
	$availability = (isset($_GET["a"]) ? $_GET["a"] : "");
	$industry = (isset($_GET["i"]) ? $_GET["i"] : "");
	$sort  = (isset($_GET["s"]) ? $_GET["s"] : "name");
	$pagesize = (isset($_GET["n"]) ? $_GET["n"] : 10);				

	$responseData = getResults($currPage, $keyword, $availability, $industry, $sort, $pagesize);
	$filters = getFilter($currPage,$keyword,$availability,$industry, $sort, $pagesize);
	$pagination = buildPagination($currPage,$responseData->total, $pagesize);
	$searchDetail = getSearchInfo($currPage,$responseData->total, $pagesize);

	$filterArray = array();
	if ($sort !== 'name') { $filterArray[] = 's='.$sort; }
	if ($pagesize !== 10) { $filterArray[] = 'n='.$pagesize; }
	if (!empty($filterArray)) {
		$filterString = implode('&', $filterArray);
	}

	$filter_availability = $availability;
	$filter_industry = $industry;
	$filter_keyword = $keyword;

	if($responseData->success){
		$experts = $responseData->speakers;
		//$experts = usort($experts, array("expertSorter", "sortByLastname"));
		$total = $responseData->total;
	}
} 