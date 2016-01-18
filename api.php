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
	   
	function getResults($currPage, $keyword, $availability, $industry){
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
		'page_number' => urlencode($currPage),
		'page_size' => 5,
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
		$pagination = '';
		
		if($numberOfPage == 1) return "";
		
		if($page != 1){
			if(isset($_GET["q"])){
				$pagination .= '<a data-page="1" href="?p=1">First</a><a data-page="' . ($page - 1) . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . ($page - 1) . '"><</a>';			
			}else{
				$pagination .= '<a data-page="1" href="?p=1">First</a><a data-page="' . ($page - 1) . '" href="?p=' . ($page - 1) . '"><</a>';
			}	
		}
		
		for($i = 1; $i <= $numberOfPage; $i++){
			if($i != $page){
				if(isset($_GET["q"])){
					$pagination .= '<a data-page="' . $i . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . $i . '">' . $i . '</a>';		
				}else{
					$pagination .= '<a data-page="' . $i . '" href="?p=' . $i . '">' . $i . '</a>';
				}				
			}else{
				$pagination .= '<strong>' . $i . '</strong>';
			}
		}
		
		if($page < $numberOfPage){
			if(isset($_GET["q"])){
				$pagination .= '<a data-page="' . ($page + 1) . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . ($page + 1) . '">></a><a data-page="' . $numberOfPage . '" href="?q=' . urlencode($_GET["q"]) . '&p=' . $numberOfPage . '">Last</a>';	
			}else{
				$pagination .= '<a data-page="' . ($page + 1) . '" href="?p=' . ($page + 1) . '">></a><a data-page="' . $numberOfPage . '" href="?p=' . $numberOfPage . '">Last</a>';
			}		
		}		
		
		return $pagination;
	}		
	function getSearchInfo($currPage, $total, $pageSize){
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

	if(isset($_GET["expert"])){
		$expertName = $_GET["expert"];
		$expert = getExpert($expertName);

		$expert = $expert->speaker;
	}else{
		$experts = array();
		$currPage = (isset($_GET["p"]) ? $_GET["p"] : 1);
		$keyword = (isset($_GET["q"]) ? $_GET["q"] : "");
		$availability = (isset($_GET["a"]) ? $_GET["a"] : "");
		$industry = (isset($_GET["i"]) ? $_GET["i"] : "");				

		$responseData = getResults($currPage, $keyword, $availability, $industry);
		$filters = getFilter($currPage,$keyword,$availability,$industry);
		$pagination = buildPagination($currPage,$responseData->total, 5);
		$searchDetail = getSearchInfo($currPage,$responseData->total, 5);

		$filter_availability = $availability;
		$filter_industry = $industry;
		$filter_keyword = $keyword;

		if($responseData->success){
			$experts = $responseData->speakers;
			$total = $responseData->total;
		}
	} 
	require_once("header.inc");
	?>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

	<body>
	  	<div class="container">
	  		<div class="expert row">
			<?php if(isset($_GET["expert"])):?>
			<div class="span12">
				<div class="expert_main clearfix">
					<div class="span3">
						<img src="<?php echo $expert->avatar->l->url; ?>" />
					</div>
					<div class="span7">
						<img src="<?php echo $expert->avatar->l->url; ?>" class="small"/>
						<h1><?php echo $expert->user->firstname . ' ' . $expert->user->lastname ; ?></h1>
						<h3><?php echo $expert->user->job_title ?> | <?php echo $expert->user->location->city; ?>, <?php echo $expert->user->location->state; ?>, <?php echo $expert->user->location->country; ?></h3>
						<p><?php echo $expert->tagline; ?></p>
						<div class="social_links">
							<?php if($expert->socialprofile->twitter): ?>
							<?php if(substr($expert->socialprofile->twitter, 0, 1) == '@'): ?>
							<a href="//www.twitter.com/<?php echo $expert->socialprofile->twitter; ?>" class="twitter">
								<em class="fa fa-twitter-square"></em>
							</a>
							<?php else: ?>
							<a href="<?php echo $expert->socialprofile->twitter; ?>" class="twitter">
								<em class="fa fa-twitter-square"></em>
							</a>
							<?php endif ?>
							<?php endif ?>
							<?php if($expert->socialprofile->facebook): ?>
							<a href="<?php echo $expert->socialprofile->facebook; ?>" class="facebook">
								<em class="fa fa-facebook-square"></em>
							</a>
							<?php endif ?>
							<?php if($expert->socialprofile->linkedin): ?>
							<a href="<?php echo $expert->socialprofile->linkedin; ?>" class="linkedin">
								<em class="fa fa-linkedin-square"></em>
							</a>
							<?php endif ?>
							<?php if($expert->socialprofile->gplus): ?>
							<a href="<?php echo $expert->socialprofile->gplus; ?>" class="gplus">
								<em class="fa fa-google-plus-square"></em>
							</a>
							<?php endif ?>
						</div>
						<a href="//expertfile.com/experts/inquire/<?php echo urlencode($expert->user->username); ?>" target="_blank" class="btn btn-default">
							<em class="fa fa-envelope"></em> Inquire
						</a>
					</div>
				</div>
			</div>	
			<div class="left-nav-contianer span3 clearfix">
				<div id="expert-profile-sidenav" class="bs-sidenav-wrapper clearfix" data-offset-bottom="500">
					<ul class="nav bs-sidenav"> 
						<li class="active clearfix">				
		                <a href="#media" class="header-nav">Expertise <em class="fa fa-chevron-down"></em></a>
			                <ul class="sub-nav clearfix">
				                <?php if(count($expert->photos) > 0 || count($expert->videos) > 0 || count($expert->youtube_videos) > 0 || count($expert->vimeo_videos) > 0 || count($expert->books) > 0  || count($expert->documents) > 0 || count($expert->slideshare_documents) > 0 || count($expert->audios) > 0 ) : ?>		  
				                <li class="clearfix">
				                	<a href="#media">Media</a>
				                	<em class="fa fa-cloud"></em>
								</li>
								<?php endif ?>					
								<?php if($expert->description) : ?>
				                <li class="clearfix">
				                	<a href="#biography">Biography</a>
				                	<em class="fa fa-file-text"></em>
								</li>  
								<?php endif ?>
								<?php if(count($expert->industry_expertise) > 0) : ?>
				                <li class="clearfix">
				                	<a href="#industry-expertise">Industry Expertise</a>
				                	<em class="fa fa-lightbulb-o"></em>
								</li>  
								<?php endif ?>
								<?php if(count($expert->engagement->topics) > 0) :?>
				                <li class="clearfix">
				                	<a href="#topics">Topics</a>
				                	<em class="fa fa-star"></em>
								</li>  
								<?php endif ?>
								<?php if(count($expert->accomplishments) > 0) :?>
				                <li class="clearfix">
				                	<a href="#accomplishments">Accomplishments</a>
				                	<em class="fa fa-trophy"></em> 
								</li> 		
								<?php endif ?>							
								<?php if(count($expert->accreditations) > 0) :?>	
				                <li class="clearfix">
				                	<a href="#education">Education</a>
				                	<em class="fa fa-certificate"></em>
								</li>  
								<?php endif ?>
								<?php if(count($expert->affiliations) > 0) :?>					
				                <li class="clearfix">
				                	<a href="#affiliations">Affiliations</a>
				                	<em class="fa fa-users"></em>
								</li> 
								<?php endif ?>		

								<?php if(count($expert->links) > 0) :?>					
				                <li class="clearfix"> 
				                	<a href="#links">Links</a> 
				                	<em class="fa fa-globe"></em>
								</li> 
								<?php endif ?>	
								
								<?php if(count($expert->languages) > 0) :?>					
				                <li class="clearfix"> 
				                	<a href="#languages">Languages</a> 
				                	<em class="fa fa-comment-o"></em>
								</li> 
								<?php endif ?>	

								<?php if(count($expert->testimonials) > 0) :?>	
				                <li class="clearfix">
				                	<a href="#testimonials">Testimonials</a>
				                	<em class="fa fa-comments"></em>
								</li> 	
								<?php endif ?>																															
							</ul>
						</li>
						<?php if(count($expert->media_appearances) > 0 || count($expert->past_talks) > 0 || count($expert->talks) > 0 || isset($expert->assessments) || ($expert->engagement->availability->keynote || $expert->engagement->availability->moderator || $expert->engagement->availability->panelist || $expert->engagement->availability->workshop || $expert->engagement->availability->host_mc || $expert->engagement->availability->appearance  || $expert->engagement->availability->corptraining)) :?>
						<li class="clearfix">				
		                	<a href="#media_appearances" class="header-nav">Speaking <em class="fa fa-chevron-down"></em></a>
			                <ul class="sub-nav clearfix">
								<?php if(count($expert->media_appearances) > 0) :?>	
				                <li class="clearfix">
				                	<a href="#media_appearances">Media Appearances</a>
				                	<em class="fa fa-microphone"></em>
								</li> 	
								<?php endif ?>	                	
								<?php if(count($expert->past_talks) > 0) :?>
				                <li class="clearfix">
				                	<a href="#past-talks">Event Appearances</a>
				                	<em class="fa fa-check-circle"></em>
								</li>  		
								<?php endif ?>		                	
								<?php if(count($expert->talks) > 0) :?>
				                <li class="clearfix">
				                	<a href="#talks">Sample Talks</a>
				                	<em class="fa fa-bullhorn"></em>
								</li>  
								<?php endif ?>							
								<?php if(isset($expert->assessments)) :?>			
				                <li class="clearfix">
				                	<a href="#style">Style</a>
				                	<em class="fa fa-bars"></em>
								</li>  		
								<?php endif ?>		
								<?php if($expert->engagement->availability->keynote || $expert->engagement->availability->moderator || $expert->engagement->availability->panelist || $expert->engagement->availability->workshop || $expert->engagement->availability->host_mc || $expert->engagement->availability->appearance  || $expert->engagement->availability->corptraining) :?>				
				                <li class="clearfix">
				                	<a href="#availability">Availability</a>
				                	<em class="fa fa-flag"></em>
								</li> 		
								<?php endif ?>											
							</ul>
						</li>
						<?php endif ?>	 		
						<?php if(count($expert->patents) > 0 || count($expert->research_grants) > 0 || count($expert->partnerships) > 0 || count($expert->case_studies) > 0) :?>
						<li class="clearfix">				
		                	<a href="#patents" class="header-nav">Research <em class="fa fa-chevron-down"></em></a>
			                <ul class="sub-nav clearfix">
								<?php if(count($expert->case_studies) > 0): ?>
				                <li class="clearfix">
				                	<a href="#case_studies">Case Studies</a>
				                	<em class="fa fa-folder-o"></em>
								</li> 		
								<?php endif ?>	                	
								<?php if(count($expert->patents) > 0) :?>
				                <li class="clearfix">
				                	<a href="#patents">Patents</a>
				                	<em class="fa fa-flask"></em>
								</li>  
								<?php endif ?>				
								<?php if(count($expert->research_grants) > 0) :?>
				                <li class="clearfix">
				                	<a href="#grants">Grants</a>
				                	<em class="fa fa-usd"></em>
								</li>  		
								<?php endif ?>				
								<?php if(count($expert->partnerships) > 0) :?>			
				                <li class="clearfix">
				                	<a href="#partnerships">Partnerships</a>
				                	<em class="fa fa-link"></em>
								</li>  		
								<?php endif ?>												
							</ul>
						</li>		
						<?php endif ?>			
						<?php if(count($expert->courses) > 0 || count($expert->articles) > 0) :?>
						<li class="clearfix">				
		                	<a href="#courses" class="header-nav">Academic <em class="fa fa-chevron-down"></em></a>
			                <ul class="sub-nav clearfix">
								<?php if(count($expert->courses) > 0) :?>
				                <li class="clearfix">
				                	<a href="#courses">Courses</a>
				                	<em class="fa fa-calendar"></em>
								</li>  
								<?php endif ?>				
								<?php if(count($expert->articles) > 0) :?>
				                <li class="clearfix">
				                	<a href="#articles">Articles</a>
				                	<em class="fa fa-file-text"></em>
								</li>  		
								<?php endif ?>																
							</ul>
						</li>						
						<?php endif ?>																														    
		        	</ul>        		        	
				</div>        	
			</div>				
			<div class="speaker_content  span9 ">
			<div  id="media" class="media-asset-wrap clearfix">
				<?php if(count($expert->photos) > 0): ?>
				<?php foreach($expert->photos as $key=>$value): ?>
				<?php if(isset($value->images->l->url)) : ?>
				<div class="span2 thumbnail" data-asset-type="photo" data-asset-url="<?php echo $value->images->l->url; ?>">
				<?php else: ?>
				<div class="span2 thumbnail" data-asset-type="photo" data-asset-url="<?php echo $value->images->m->url; ?>">
				<?php endif ?>
					<div class="media-wrap">
                        <em><span class="fa fa-picture-o"></span></em>
						<img src="<?php echo $value->images->m->url;  ?>">
					</div>
				</div>
				<?php endforeach ?>
				<?php endif ?>

				<?php if(count($expert->videos) + count($expert->youtube_videos) + count($expert->vimeo_videos) > 0): ?>
				<?php foreach($expert->videos as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="video" data-asset-url="<?php echo $value->url;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-video-camera"></span></em>
						<img src="https://shared.uoit.ca/shared/uoit/exprtfile/images/mediatype-video-sm.png" class="no_thumbnail">
					</div>
				</div>
				<?php endforeach ?>
				<?php foreach($expert->youtube_videos as $key=>$value): ?>
				<?php
				$videoTitle = str_replace("\n", "", $value->title);
				$videoTitle = str_replace("\r", "", $value->title);
				?>
				<div class="span2 thumbnail" data-asset-type="youtube_video" data-asset-url="<?php echo $value->flash_player_url;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-video-camera"></span></em>
						<img src="<?php echo $value->thumbnail_url;  ?>" class="small">
                        
					</div>
				</div>
				<?php endforeach ?>
				<?php foreach($expert->vimeo_videos as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="vimeo_video" data-asset-url="http://player.vimeo.com/video/<?php echo $value->external_id;  ?>?api=1">
					<div class="media-wrap">
                        <em><span class="fa fa-video-camera"></span></em>
						<img src="<?php echo $value->thumbnail_small;  ?>" class="small">
					</div>
				</div>
				<?php endforeach ?>
				<?php endif ?>
				<?php if(count($expert->books) > 0): ?>
				<?php foreach($expert->books as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="publication"  data-asset-url="<?php echo $value->landing_url;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-book"></span></em>
						<img src="<?php echo $value->cover_url ?>">
					</div>
				</div>
				<?php endforeach ?>
				<?php endif ?>
				<?php if(count($expert->audios) > 0): ?>
				<?php foreach($expert->audios as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="audio" data-asset-url="<?php echo $value->url;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-volume-up"></span></em>
						<img src="https://shared.uoit.ca/shared/uoit/exprtfile/images/mediatype-audio-sm.png" class="no_thumbnail">
					</div>
				</div>
				<?php endforeach ?>
				<?php endif ?>				
				<?php if(count($expert->documents) + count($expert->slideshare_documents) > 0): ?>
				<?php foreach($expert->documents as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="document" data-asset-url="<?php echo $value->url;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-file-text"></span></em>
						<img src="https://shared.uoit.ca/shared/uoit/exprtfile/images/mediatype-document-sm.png" class="no_thumbnail">
					</div>
				</div>
				<?php endforeach ?>				
				<?php foreach($expert->slideshare_documents as $key=>$value): ?>
				<div class="span2 thumbnail" data-asset-type="slideshare_document" data-asset-url="<?php echo $value->embed;  ?>">
					<div class="media-wrap">
                        <em><span class="fa fa-file-text"></span></em>
						<img src="https://shared.uoit.ca/shared/uoit/exprtfile/images/mediatype-document-sm.png" class="no_thumbnail">
					</div>
				</div>
				<?php endforeach ?>	
			<?php endif ?>
            </div>
			<?php if($expert->description != ''): ?>
			<div id="biography" class="nice_box">
				<h2 class="sectionheader">Biography</h2>
				<p class="display_item"><?php echo $expert->description; ?></p>
			</div>
			<?php endif ?>
            
            
            <?php 
			if($expert->socialprofile->twitter):
            function get_twitter_feed($username){
            
                    $twitteruser = $username;
                    $notweets = 30;
                    $consumerkey = "XguHk4IArzSaq108CmWtv8rFF";
                    $consumersecret = "r4AmdveanQilhEe8lofGH7fbtegFHQ3BccKJDiBoWby769WoQR";
                    $accesstoken = "131286593-b5Vo7Y8KbTqEQ0TC9wG1aXyzZ5UuE9GbXvf4QuHY";
                    $accesstokensecret = "6EXU53aejUWdBc4j3xkwg8HfPZKnKlJA7dkFIRROEj37d";
             
                    $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
            
                    $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=". $twitteruser ."&count=".$notweets);
                    return $tweets;
                }
				 //replace ExpertFile full Twitter URL with user name
				$username = str_replace("https://twitter.com/","",$expert->socialprofile->twitter);
                $tweets = get_twitter_feed($username);
				endif;
			?>
            
            <?php if(isset($tweets) || count($tweets) > 0): ?>    
            <div id="activity" class="nice_box">
                <div class="nice-content-wrapper">
                    <h2 class="nice-box-header">
                        Activity         
                    </h2>
                    <div class="twitter-activity">
                        <?php foreach ($tweets as $tweet): ?>
                        <div class="tweet-wrap clearfix">
                            <img src="<?php echo $tweet->user->profile_image_url; ?>" />
                            <p>
                                <?php 
                                  $formatted_text = preg_replace('/(\b(www\.|http\:\/\/)\S+\b)/', "<a target='_blank' href='$1'>$1</a>", $tweet->text);
                                    $formatted_text = preg_replace('/\#(\w+)/', "<a target='_blank' href='http://search.twitter.com/search?q=$1'>#$1</a>", $formatted_text);
                                    $formatted_text = preg_replace('/\@(\w+)/', "<a target='_blank' href='http://twitter.com/$1'>@$1</a>", $formatted_text);

                                    $formatted_date = $tweet->created_at;

                                    if (!is_null($formatted_date)) {
                                       $formatted_date = date('F jS, g:i a', strtotime($formatted_date));;
                                    }                    
                                ?>
                                <?php echo $formatted_text; ?>
                                <em><?php echo $formatted_date; ?></em>
                            </p>
                        </div>
                        <?php  endforeach ?>    
                    </div>
                    <div class="twitter-readmore">

                    </div>                            
                </div>
            </div>        
            <?php endif ?>
            
            
        
            
			<?php if(count($expert->industry_expertise) > 0): ?>
			<div id="industry-expertise" class="nice_box">
				<h2 class="sectionheader">Industry Expertise (<?php echo count($expert->industry_expertise); ?>)</h2>
				<p class="speaker_content clearfix">
				<?php foreach($expert->industry_expertise as $key=>$value): ?>
					<em class="tag"><?php echo $value->industry; ?></em>
				<?php endforeach ?>
				</p>
			</div>
			<?php endif ?>
            
            
            
			<?php if(count($expert->engagement->topics) > 0): ?>
			<div id="topics" class="nice_box">
				<h2 class="sectionheader">Topics (<?php echo count($expert->engagement->topics); ?>)</h2>
				<p class="speaker_content clearfix">
				<?php foreach($expert->engagement->topics as $key=>$value): ?>
					<em class="tag"><?php echo $value->name; ?></em>
				<?php endforeach ?>
				</p>
			</div>
			<?php endif ?>
			<?php if(count($expert->accreditations) > 0): ?>
			<div id="education" class="nice_box">
				<h2 class="sectionheader">Education (<?php echo count($expert->accreditations); ?>)</h2>
				<?php foreach($expert->accreditations as $key=>$value): ?>
				<div class="display_item">
					<h4><?php echo $value->institution; ?></h4>
					<?php echo $value->degree; ?>
					<?php echo $value->major; ?>
					<p><?php echo $value->description; ?></p>
				</div>
				<?php endforeach ?>
			</div>
			<?php endif ?>
			<?php if(count($expert->accomplishments) > 0): ?>
			<div id="accomplishments" class="nice_box">
				<h2 class="sectionheader">Accomplishments (<?php echo count($expert->accomplishments); ?>)</h2>
				<?php foreach($expert->accomplishments as $key=>$value): ?>
				<div class="display_item">
					<h4><?php echo $value->title; ?></h4>
					<p><?php echo $value->description; ?></p>
				</div>
				<?php endforeach ?>
			</div>
			<?php endif ?>
			<?php if(count($expert->affiliations) > 0): ?>
			<div id="affiliations" class="nice_box">
				<h2 class="sectionheader">Affiliations (<?php echo count($expert->affiliations); ?>)</h2>
				<p class="speaker_content clearfix">
				<?php foreach($expert->affiliations as $key=>$value): ?>
					<em class="tag"><?php echo $value->name; ?></em>
				<?php endforeach ?>
				</p>
			</div>	
			<?php endif ?>
			<?php if(count($expert->links) > 0): ?>
			<div id="links" class="nice_box">
				<h2 class="sectionheader">Links (<?php echo count($expert->links); ?>)</h2>
				<p class="speaker_content clearfix">
				<?php foreach($expert->links as $key=>$value): ?>
					<em class="tag"><a href="<?php echo $value->url?>"><?php echo $value->name; ?></a></em>
				<?php endforeach ?>
				</p>
			</div>	
			<?php endif ?>
			<?php if(count($expert->languages) > 0) :?>	
			<div id="languages" class="nice_box clearfix">
				<div class="nice-content-wrapper">				
					<h2 class="sectionheader">My Languages (<?php echo count($expert->languages) ?>)</h2>
					<div class="nice-box-content">
						<?php foreach($expert->languages as $languages): ?>
							<em class="tag"><?php echo htmlspecialchars($languages->name); ?></em>
						<?php endforeach ?>	
					</div>
				</div>
			</div>	
			<?php endif ?>	
			<div id="media_appearances" class="nice_box">
			<?php if(count($expert->media_appearances) > 0) :?>					
				<h2 class="sectionheader">
					Media Appearances (<?php echo count($expert->media_appearances) ?>)						
				</h3>				
				<?php foreach($expert->media_appearances as $key=>$media_appearance): ?>					
					<div class="display_item clearfix">										
						<h4><?php echo $media_appearance->title ?></h4>
						<strong><?php echo $media_appearance->organization ?>&nbsp;<?php echo $media_appearance->type ?></strong><br />
						<?php if($media_appearance->url != ''): ?>
						<a href="<?php echo $media_appearance->url ?>" target="_blank">view more</a>
						<?php endif ?>
						<?php if(date('Y-m-d', $media_appearance->date) != '1970-01-01') : ?>
							<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $media_appearance->date) ?></div>
						<?php endif?>
						<p>
							<?php echo $media_appearance->details ?>
						</p>
						<?php if(isset($media_appearance->cover_url) && $media_appearance->cover_url !=''): ?>
						<img class="thumbnail" src="<?php echo $media_appearance->cover_url ?>" data-asset-type="photo" data-asset-url="<?php echo $media_appearance->large_cover_url ?>" />	
						<?php endif ?>							
												
					</div>
				<?php endforeach ?>																	
			<?php endif ?>			
			</div>	
			<?php if(count($expert->past_talks) > 0): ?>
			<div id="past-talks" class="nice_box">
				<h2 class="sectionheader">Past Speaking Engagements (<?php echo count($expert->past_talks); ?>)</h2>
				<?php foreach($expert->past_talks as $key=>$value): ?>
				<div class="display_item">
					<h4><?php echo $value->title; ?></h4>
					<h5><?php echo $value->location; ?></h5>
					<p><?php echo $value->event_name; ?></p>
				</div>
				<?php endforeach ?>
				</div>
			<?php endif ?>									
			<?php if(count($expert->talks) > 0): ?>
			<div id="talks" class="nice_box">
				<h2 class="sectionheader">Sample Talks (<?php echo count($expert->talks); ?>)</h2>
				<?php foreach($expert->talks as $key=>$value): ?>
				<div class="display_item">
					<h4><?php echo $value->title; ?></h4>
					<p><?php echo $value->description; ?></p>
				</div>
				<?php endforeach ?>
			</div>
			<?php endif ?>	
			<?php if(isset($expert->assessments)) :?>			
			<div id="style" class="nice_box clearfix">
				<div class="nice-content-wrapper">
					<h2 class="sectionheader">
						Speaking Style
					</h2>					
					<div class="nice-box-content">
						<?php foreach($expert->assessments as $key=>$assessment): ?>
						<?php if($key == 1):?>
						<div class="row">
							<div class="span1"><label class="uppercase small">Educational</label></div>
							<div class="span6">
								<div class="progress">
									<div class="slider-handle" style="left: <?php echo ($assessment > 90 ? '93.5' :  $assessment); ?>%"></div>
								</div>
							</div>						
							<div class="span1"><label class="uppercase small">Entertaining</label></div>						
						</div>							
						<?php endif ?>
						<?php if($key == 2):?>
						<div class="row">
							<div class="span1"><label class="uppercase small">Strategic</label></div>
							<div class="span6">
								<div class="progress">
									<div class="slider-handle" style="left: <?php echo ($assessment > 90 ? '93.5' :  $assessment); ?>%"></div>
								</div>
							</div>						
							<div class="span1"><label class="uppercase small">Tactical</label></div>						
						</div>				
						<?php endif ?>		
						<?php if($key == 3):?>
						<div class="row">
							<div class="span1"><label class="uppercase small">Lecture</label></div>
							<div class="span6">
								<div class="progress">
									<div class="slider-handle" style="left: <?php echo ($assessment > 90 ? '93.5' :  $assessment); ?>%"></div>
								</div>
							</div>						
							<div class="span1"><label class="uppercase small">Interactive</label></div>						
						</div>										
						<?php endif ?>	
						<?php if($key == 4):?>
						<div class="row">
							<div class="span1"><label class="uppercase small">Formal</label></div>
							<div class="span6">
								<div class="progress">
									<div class="slider-handle" style="left: <?php echo ($assessment > 90 ? '93.5' :  $assessment); ?>%"></div>
								</div>
							</div>						
							<div class="span1"><label class="uppercase small">Relaxed</label></div>						
						</div>						
						<?php endif ?>	
						<?php endforeach ?>	
					</div>
				</div>
			</div>	
			<?php endif ?>	
            <?php if(!empty($expert->engagement->availability->keynote)||!empty($expert->engagement->availability->moderator)||!empty($expert->engagement->availability->panelist)||!empty($expert->engagement->availability->workshop)||!empty($expert->engagement->availability->host_mc)||!empty($expert->engagement->availability->appearance)||!empty($expert->engagement->availability->corptraining)): ?>
			<div id="availability" class="nice_box clearfix">	
				<h2 class="sectionheader">Availability</h2>
				<p class="speaker_content clearfix">
				<?php if($expert->engagement->availability->keynote): ?>
					<em class="tag">Keynote</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->moderator): ?>
					<em class="tag">Moderator</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->panelist): ?>
					<em class="tag">Panelist</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->workshop): ?>
					<em class="tag">Workshop Leader</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->host_mc): ?>
					<em class="tag">Host/MC</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->appearance): ?>
					<em class="tag">Author Appearance</em>
				<?php endif ?>
				<?php if($expert->engagement->availability->corptraining): ?>
					<em class="tag">Corporate Training</em>
				<?php endif ?>
				</p>
			</div>	
            <?php endif ?>
			<?php if(count($expert->case_studies) > 0) :?>	
			<div id="case_studies" class="nice_box">					
				<h2 class="sectionheader">
					Case Studies (<?php echo count($expert->case_studies) ?>)
				</h2>
				<?php foreach($expert->case_studies as $key=>$case_study): ?>										
					<div class="display_item row">					
						<h4><?php echo $case_study->title ?></h4>
						<strong><?php echo $case_study->subtitle ?></strong><br />
						<?php if($case_study->url != ''): ?>							
						<a href="<?php echo $case_study->url ?>" target="_blank">view more</a>
						<?php endif ?>
						<?php if(date('Y-m-d', $case_study->date) != '1970-01-01') : ?>
							<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $case_study->date) ?></div>
						<?php endif?>
						<p>
							<?php echo $case_study->details ?>
						</p>
						<?php if(isset($case_study->cover_url) && $case_study->cover_url !=''): ?>
						<img class="thumbnail" src="<?php echo $case_study->cover_url ?>" data-asset-type="photo" data-asset-url="<?php echo $case_study->large_cover_url ?>" />	
						<?php endif ?>
					</div>
				<?php endforeach ?>	
			</div>																	
			<?php endif ?>			
			<div id="patents" class="nice_box">
            <?php if(count($expert->patents) > 0) :?>	
								
				<h2 class="sectionheader">
					Patents (<?php echo count($expert->patents) ?>)						
				</h2>
			
				<?php foreach($expert->patents as $key=>$patent): ?>
				<div class="display_item clearfix">					
					<h4><?php echo $patent->title ?></h4>
					<strong><?php echo $patent->number ?></strong><br />
					<?php if($patent->url != ''): ?>	
					<a href="<?php echo $patent->url ?>" target="_blank">view more</a>
					<?php endif?>
					<?php if(date('Y-m-d', $patent->date) != '1970-01-01') : ?>
						<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $patent->date) ?></div>
					<?php endif?>
					<p>
						<?php echo $patent->detail ?>
					</p>
				</div>	
				<?php endforeach ?>
														
			<?php endif ?>
            </div>    
			<?php if(count($expert->research_grants) > 0) :?>
			<div id="research_grants" class="nice_box">											
				<h2 class="sectionheader">
					Research Grants (<?php echo count($expert->research_grants) ?>)						
				</h2>
			
				<?php foreach($expert->research_grants as $key=>$grant): ?>
				<div class="nice-box-content">					
					<div class="display_item">
						<h4><?php echo $grant->title ?></h4>
						<strong><?php echo $grant->organization ?>&nbsp;<?php echo ($grant->amount == "0" ? "" : "$" . $grant->amount) ?></strong><br />
						<?php if($grant->url != ''): ?>	
						<a href="<?php echo $grant->url ?>" target="_blank">view more</a>
						<?php endif?>
						<?php if(date('Y-m-d', $grant->date) != '1970-01-01') : ?>
							<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $grant->date) ?></div>
						<?php endif?>	
						<p>
							<?php echo $grant->details ?>
						</p>							
					</div>
				</div>
				<?php endforeach ?>	
			</div>														
			<?php endif ?>	
			<?php if(count($expert->partnerships) > 0) :?>
			<div id="partnerships" class="nice_box">										
				<h2 class="sectionheader">
					Partnerships (<?php echo count($expert->partnerships) ?>)						
				</h3>
			
				<?php foreach($expert->partnerships as $key=>$partnership): ?>				
					<div class="display_item">
						<h4><?php echo $partnership->title ?></h4>
						<strong><?php echo $partnership->individual ?>&nbsp;<?php echo $partnership->organization ?></strong><br />
						<?php if($partnership->url != ''): ?>	
						<a href="<?php echo $partnership->url ?>" target="_blank">view more</a>
						<?php endif?>	
						<?php if(date('Y-m-d', $partnership->date) != '1970-01-01') : ?>
							<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $partnership->date) ?></div>
						<?php endif?>	
						<p>
							<?php echo $partnership->details ?>
						</p>							
					</div>
				<?php endforeach ?>	
			</div>													
			<?php endif ?>	
			<?php if(count($expert->courses) > 0) :?>
			<div id="courses" class="nice_box">													
				<h2 class="sectionheader">
					Courses (<?php echo count($expert->courses) ?>)						
				</h2>
			
				<?php foreach($expert->courses as $key=>$course): ?>									
					<div class="display_item">
						<h4><?php echo $course->title ?></h4>
						<?php if($article->url != ''): ?>	
						<a href="<?php echo $article->url ?>" target="_blank">view more</a>
						<?php endif?>	
						<p>
							<?php echo $course->details ?>
						</p>							
					</div>
				<?php endforeach ?>	
			</div>													
			<?php endif ?>
			<?php if(count($expert->articles) > 0) :?>		
			<div id="articles" class="nice_box">											
				<h2 class="sectionheader">
					Articles (<?php echo count($expert->articles) ?>)						
				</h2>
			
				<?php foreach($expert->articles as $key=>$article): ?>										
					<div class="display_item">
						<h4><?php echo $article->title ?></h4>
						<strong><?php echo $article->publisher ?></strong><br />
						<a href="<?php echo $article->url ?>" target="_blank">view more</a>
						<?php if(date('Y-m-d', $article->date) != '1970-01-01') : ?>
							<div><em class="fa fa-calendar"></em> <?php echo date('Y-m-d', $article->date) ?></div>
						<?php endif?>	
						<p>
							<?php echo $article->details ?>
						</p>
					</div>
				<?php endforeach ?>	
			</div>													
			<?php endif ?>			
			</div>
			</div>	
			<?php else: ?>
            <div class="span12">
                <h2>Meet our experts</h2> 
            </div>
                 <p class="span12">
                 To keep pace with today's ever-changing news cycle, we have now launched our enhanced UOIT Expert Centre - your source to discover UOIT's diverse collection of faculty expertise and thought leadership. These expert profiles feature rich multimedia content, detailed biographies and trending topic tags that will help you find the appropriate expert to provide analysis, commentary and insight on today's most engaging industry trends and developments. 
                 </p>
                 <p class="span12"> 
                 Addressing qualified media and conference speaking requests is a priority for the UOIT media relations office. Please use the connect button on each expert profile to send us a direct inquiry and we will respond in a timely manner.
                 </p>
                 
			<?php if(isset($total) && $total > 0): ?>
			<div class="span12 expert expert_list">
			<div class="search-wrap clearfix">
			<div class="span3 search-header refine">
				Refine Results
			</div>				
			<div class="span9 search-header">
				<?php echo $searchDetail; ?>
			</div>
			<div class="search-results-container clearfix">
				<div class="span3">
					<div class="refine-search">
						<div class="category_wrap clearfix filter">
							<label>Industry Expertise</label>
							<div class="input-wrap">
								<select>
									<option value="">-- all industries --</option>
									<?php foreach($filters->filters->industries as $key=>$value): ?>
										<?php if($value->industry_id == $filter_industry): ?>
											<option selected="selected" value="<?php echo $value->industry_id; ?>"><?php echo $value->industry_name; ?> (<?php echo $value->count; ?>)</option>					
										<?php else: ?>
											<option value="<?php echo $value->industry_id; ?>"><?php echo $value->industry_name; ?> (<?php echo $value->count; ?>)</option>
										<?php endif ?>	
									<?php endforeach ?>								
								</select>
							</div>
						</div>	
						<div class="availability_wrap clearfix filter">
							<label>Speaking Availability</label>
							<div class="input-wrap">
								<select>
									<option value="">-- all availability --</option>		
									<?php foreach($filters->filters->availability as $key=>$value): ?>
										<?php if($key == $filter_availability): ?>
											<option selected="selected" value="<?php echo $value[0]; ?>"><?php echo $key; ?> (<?php echo $value[1]; ?>)</option>				
										<?php else: ?>
											<option value="<?php echo $value[0]; ?>"><?php echo $key; ?> (<?php echo $value[1]; ?>)</option>
										<?php endif ?>				
										
									<?php endforeach ?>									
								</select>
							</div>
						</div>	
						<div class="keyword_wrap clearfix filter">
							<label>Keyword</label>	
							<div class="input-wrap">
								<form method="get" name="sitesearch" action="" class="clearfix">
									<div class="input-append">
									<?php if($filter_keyword != ''): ?>
								    <input class="textfield" type="text" value="<?php echo $filter_keyword; ?>" maxlength="256" id="q" name="q" value="">
								    <?php else: ?>
								    <input class="textfield" type="text" placeholder="enter search term" maxlength="256" id="q" name="q" value="">
								    <?php endif ?>								
									 <button class="btn" type="button"><em class="icon icon-search">&nbsp;</em></button>
									</div> 						
								</form>	
							</div>
						</div>	
						<a href="/" class="btn btn-default filter_reset">Reset Filters</a>				
					</div>
				</div>
				<div class="span9">
					<?php foreach($experts as $key=>$value): ?>
					<div class="clearfix">
						<div class="expert-wrap clearfix">
							<?php if(isset($value->url)): ?>
								<img src="<?php echo $value->url; ?>" />
							<?php endif ?>
							<div class="meta-wrap">
								<h2><?php echo $value->firstname; ?> <?php echo $value->lastname; ?></h1>
								<strong>
									<?php echo $value->job_title ?> -- <?php echo $value->city?>,
									<?php echo $value->state?>, <?php echo $value->country?>
								</strong>
								<p><?php echo $value->tagline; ?></p>
							</div>
							<div class="topic-wrap clearfix">
								<?php foreach($value->topics as $t): ?>
									<em class="tag truncate">
										<?php echo $t->name; ?>
									</em>
							<?php endforeach ?>
							</div>	
							<div class="action-wrap clearfix">					
								<a href="?expert=<?php echo $value->username; ?>" class="btn btn-default"><em class="fa fa-search"></em> View Profile</a>
							</div>
	                        <a href="?expert=<?php echo $value->username; ?>" class="expert-wrap-link"></a>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
			<div class="span12 paginationWrapper clearfix">			
				<?php echo $pagination; ?>											
			</div>				
			<?php else: ?>
			<div class="span12">
				<p class="no_speakers_result"><strong>Sorry! </strong> No experts can be found, based on your criteria. Please try altering your query.</p>
			</div>
			<?php endif ?>
        
        <div class="row">
        <div class="span12 expert_footer">
            <h3>Can't find who you're looking for?</h3>
	
	        <h4>Contact us and we'll help you find the perfect expert</h4>
	
	        <div class="row contact">
	            <div class="span6 contact_left">
	                <p>Melissa Levy<br>
	                905.721.8668 ext. 6733<br>
	                <a href="mailto:melissa.levy@uoit.ca">melissa.levy@uoit.ca</a></p>
	            </div>	
	            <div class="span6 contact_right">
	                <p>Bryan Oliver<br>
	                905.721.8668 ext. 6709<br>
	                <a href="mailto:bryan.oliver@uoit.ca">bryan.oliver@uoit.ca</a></p>
	            </div>
	        </div>
	
	        <p>General inquiries to the department can also be emailed to <a href="mailto:communications@uoit.ca">communications@uoit.ca</a></p>
	
	        <p><a href="http://www.uoit.ca/faculty_staff/faculty-experts.php?noredirect">In addition, we offer a comprehensive list of researchers and subject matter topics, organized by specific faculty. Please visit this page to explore the list.</a></p>
	    </div>
        </div>
        
			<?php endif ?>
		</div>

	  	</div>
          
        

    
		<div id="dialog" title="">
			<div id="dialog_content">
				<img />
			</div>
		</div>
		<div id="dialog_flash" title="">
			<div id="dialog_flash_content">
				<div id="player"></div>
			</div>
		</div>
		<div id="dialog_external_asset" title="">
			<div id="dialog_external_asset_content">

			</div>
		</div>  	

 	


<script>
	setInterval(function(){
		if($('.tweet-wrap:visible').length > 3){
			$('.tweet-wrap:visible:first').slideUp();
		}
	}, 3000);
	
</script>

<?php
	require_once("footer.inc");
?>
