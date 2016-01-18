<?php 
  $fullname = $expert->user->firstname.' '.$expert->user->lastname;
  $fullname = preg_replace('/\s+/', ' ', $fullname);
  ?>
<section class="row">
  <div class="large-12 columns">
    <h1>UOIT EXPERT CENTRE</h1>
  </div>
</section>
<!-- ****************************
  *
  * HERO PANEL
  *
  ***************************** -->
<section class="row">
  <article class="large-12 columns section_content_wrapper" role="banner">
    <div class="small-4 medium-3 columns">
      <img class="expert_avatar_inner" src="
        <?php echo $expert->avatar->l->url; ?>" alt="
        <?php echo $fullname; ?>" />
    </div>
    <div class="small-8 medium-9 columns">
      <h2>
        <strong>
        <?php echo $fullname; ?>
        <br/>
        <small>
        <?php echo $expert->user->job_title ?> | 
        <?php echo $expert->user->location->city; ?>, 
        <?php echo $expert->user->location->state; ?>, 
        <?php echo $expert->user->location->country == 'CA' ? 'CAN' : $value->country; ?>
        </small>
        </strong>
      </h2>
      <p>
        <?php echo $expert->tagline; ?>
      </p>
      <?php if(count($expert->languages) > 0) :?>
      <p>
        <em>Languages spoken:</em>
        <?php foreach($expert->languages as $languages): ?>
        <span class="label">
        <?php echo htmlspecialchars($languages->name); ?>
        </span>
        <?php endforeach ?>
      </p>
      <?php endif ?>
      <p>
        <a href="//expertfile.com/experts/inquire/
          <?php echo urlencode($expert->user->username); ?>" target="new" class="button">
        <span class="fa fa-envelope"></span> Inquire
        </a>
        <?php if(!empty($expert->engagement->availability->keynote)||!empty($expert->engagement->availability->moderator)||!empty($expert->engagement->availability->panelist)||!empty($expert->engagement->availability->workshop)||!empty($expert->engagement->availability->host_mc)||!empty($expert->engagement->availability->appearance)||!empty($expert->engagement->availability->corptraining)): ?>
        &nbsp;Availability:
        <?php foreach($expert->engagement->availability as $key=>$value):
          if($value != '0'): ?>
        &nbsp;
        <a href="?a=
          <?php echo $key; ?>" class="label">
        <?php echo ($key !== 'host_mc') ? ucfirst($key): 'Host MC'; ?>
        </a>
        <?php endif;
          endforeach; ?>
        <?php endif; ?>
      </p>
      <section class="row">
        <?php if(count($expert->engagement->topics) > 0): ?>
        <div class="medium-6 columns">
          <h3>Research Topics (
            <?php echo count($expert->engagement->topics); ?>)
          </h3>
          <p>
            <?php foreach($expert->engagement->topics as $key=>$value): ?>
            <a href="?q=
              <?php echo urlencode($value->name); ?>" class="label">
            <?php echo $value->name; ?>
            </a>
            <?php endforeach ?>
          </p>
        </div>
        <?php endif ?>
        <?php if(count($expert->industry_expertise) > 0): ?>
        <div class="medium-6 columns">
          <h3>Industry Expertise (
            <?php echo count($expert->industry_expertise); ?>)
          </h3>
          <p>
            <?php foreach($expert->industry_expertise as $key=>$value): ?>
            <a href="?i=
              <?php echo urlencode($value->industry_id); ?>" class="label">
            <?php echo $value->industry; ?>
            </a>
            <?php endforeach ?>
          </p>
        </div>
        <?php endif ?>
      </section>
    </div>
    <div class="social_links">
      <?php if($expert->socialprofile->twitter): ?>
      <?php if(substr($expert->socialprofile->twitter, 0, 1) == '@'): ?>
      <a href="//www.twitter.com/
        <?php echo $expert->socialprofile->twitter; ?>" class="twitter" title="Follow 
        <?php echo $fullname; ?> on Twitter">
      <span class="fa fa-twitter-square"></span>
      </a>
      <?php else: ?>
      <a href="
        <?php echo $expert->socialprofile->twitter; ?>" class="twitter" title="Follow 
        <?php echo $fullname; ?> on Twitter">
      <span class="fa fa-twitter-square"></span>
      </a>
      <?php endif ?>
      <?php endif ?>
      <?php if($expert->socialprofile->facebook): ?>
      <a href="
        <?php echo $expert->socialprofile->facebook; ?>" class="facebook" title="Connect with 
        <?php echo $fullname; ?> on Facebook">
      <span class="fa fa-facebook-square"></span>
      </a>
      <?php endif ?>
      <?php if($expert->socialprofile->linkedin): ?>
      <a href="
        <?php echo $expert->socialprofile->linkedin; ?>" class="linkedin" title="Connect with 
        <?php echo $fullname; ?> on LinkedIn">
      <span class="fa fa-linkedin-square"></span>
      </a>
      <?php endif ?>
      <?php if($expert->socialprofile->gplus): ?>
      <a href="
        <?php echo $expert->socialprofile->gplus; ?>" class="gplus"  title="Visit 
        <?php echo $fullname; ?> on Facebook">
      <span class="fa fa-google-plus-square"></span>
      </a>
      <?php endif ?>
    </div>
  </article>
</section>
<section class="row">
  <!-- ****************************
    *
    * GALLERY PANEL
    *
    ***************************** -->
  <?php if(count($expert->photos) + count($expert->videos) + count($expert->youtube_videos) + count($expert->vimeo_videos) + count($expert->documents) + count($expert->slideshare_documents) + count($expert->audios) + count($expert->books) > 0): ?>
  <aside class="small-12 columns" id="media-gallery-filters">
    <dl class="sub-nav" role="toolbar" aria-controls="media-gallery">
      <dt>Viewing:</dt>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'all') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=all'; ?>">All
        </a>
      </dd>
      <?php if(count($expert->photos) > 0): ?>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'photos') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=photos'; ?>">Photos
        </a>
      </dd>
      <?php endif;
        if(count($expert->videos) > 0 || count($expert->youtube_videos) > 0 || count($expert->vimeo_videos) > 0): ?>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'videos') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=videos'; ?>">Videos
        </a>
      </dd>
      <?php endif;
        if(count($expert->documents) + count($expert->slideshare_documents) > 0): ?>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'docs') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=docs'; ?>">Documents
        </a>
      </dd>
      <?php endif;
        if(count($expert->audios) > 0): ?>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'audios') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=audio'; ?>">Audio
        </a>
      </dd>
      <?php endif;
        if(count($expert->books) > 0): ?>
      <dd 
        <?php echo (isset($_GET['media']) && $_GET['media'] == 'books') ? 'class="active"' : ''; ?>>
        <a class="media-filter" href="
          <?php echo '?expert='.$expert->user->username.'&media=books'; ?>">Books
        </a>
      </dd>
      <?php endif; ?>
    </dl>
  </aside>
  <article class="small-12 columns remove_pad" id="media-gallery">
    <div class="gallery gallery-nav" id="media-gallery-inner" role="slider">
      <!-- PHOTOS NAV -->
      <?php if(count($expert->photos) > 0 && (!isset($_GET['media']) || $_GET['media'] == 'all' || $_GET['media'] == 'photos') ): ?>
      <?php foreach($expert->photos as $key=>$value): ?>
      <?php if(isset($value->images->l->url)) : ?>
      <div class="gallery-cell" data-type="img" data-href="
        <?php echo $value->images->l->url; ?>">
        <img src="
          <?php echo $value->images->l->url; ?>" alt="Photo of 
          <?php echo $fullname; ?>">
      </div>
      <?php else: ?>
      <div class="gallery-cell" data-type="img" data-href="
        <?php echo $value->images->m->url; ?>">
        <img src="
          <?php echo $value->images->m->url; ?>" alt="Photo of 
          <?php echo $fullname; ?>">
      </div>
      <?php endif ?>
      <?php endforeach ?>
      <?php endif ?>
      <!-- VIDEOS NAV -->
      <?php if( (count($expert->videos) + count($expert->youtube_videos) + count($expert->vimeo_videos) > 0) && (!isset($_GET['media']) || $_GET['media'] == 'all' || $_GET['media'] == 'videos') ): ?>
      <?php foreach($expert->videos as $key=>$value): ?>
      <div class="gallery-cell" data-type="vid" data-href="
        <?php echo $value->url; ?>">
        <img src="https://shared.uoit.ca/shared/uoit/exprtfile/images/mediatype-video-sm.png" alt="Video of 
          <?php echo $fullname; ?>">
        <span class="fa fa-play vidIcon" aria-hidden="true"></span>
      </div>
      <?php endforeach ?>
      <?php foreach($expert->youtube_videos as $key=>$value): ?>
      <?php
        $videoTitle = str_replace("\n", "", $value->title);
        $videoTitle = str_replace("\r", "", $value->title);
        ?>
      <div class="gallery-cell video-cell" data-type="vid" data-href="
        <?php echo $value->flash_player_url; ?>">
        <img src="
          <?php echo $value->thumbnail_url; ?>" alt="Video of 
          <?php echo $fullname; ?>: &laquo;
          <?php echo $videoTitle; ?>&raquo;">
        <span class="fa fa-play vidIcon" aria-hidden="true"></span>
      </div>
      <?php endforeach ?>
      <?php foreach($expert->vimeo_videos as $key=>$value): ?>
      <div class="gallery-cell" data-type="vid" data-href="http://player.vimeo.com/video/
        <?php echo $value->external_id ?>?api=1" alt="Video of 
        <?php echo $fullname; ?>">
        <img src="
          <?php echo $value->thumbnail_small;  ?>">
        <span class="fa fa-play vidIcon" aria-hidden="true"></span>
      </div>
      <?php endforeach ?>
      <?php endif ?>
      <!-- BOOKS NAV -->
      <?php if(count($expert->books) > 0): ?>
      <?php foreach($expert->books as $key=>$value): ?>
      <?php if(isset($value->landing_url)) : ?>
      <div class="gallery-cell">
        <a href="
          <?php echo $value->landing_url; ?>">
        <img src="
          <?php echo $value->large_cover_url;  ?>" alt="Book by 
          <?php echo $fullname; ?>" />
        <span class="fa fa-book vidIcon" aria-hidden="true"></span>
        </a>
      </div>
      <?php else: ?>
      <div class="gallery-cell">
        <img src="
          <?php echo $value->large_cover_url;  ?>" alt="Book by 
          <?php echo $fullname; ?>" />
        <span class="fa fa-book vidIcon" aria-hidden="true"></span>
      </div>
      <?php endif ?>
      <?php endforeach ?>
      <?php endif ?>
      <?php if(count($expert->audios) > 0): ?>
      <?php foreach($expert->audios as $key=>$value): ?>
      <div class="gallery-cell" data-type="aud" data-href="
        <?php echo $value->url;  ?>">
        <img src="http://placehold.it/200x150/003c71/ffffff.png?text=Audio%0Afile" alt="Audio recording by 
          <?php echo $fullname; ?>" />
        <span class="fa fa-volume-up"></span>
      </div>
      <?php endforeach ?>
      <?php endif ?>
      <?php if(count($expert->documents) + count($expert->slideshare_documents) > 0): ?>
      <?php foreach($expert->documents as $key=>$value): ?>
      <div class="gallery-cell" data-type="doc">
        <a href="
          <?php echo $value->url;  ?>">
        <img src="http://placehold.it/200x150/003c71/ffffff.png?text=Document" alt="Document by 
          <?php echo $fullname; ?>" >
        <span class="fa fa-file-text vidIcon" aria-hidden="true"></span>
        </a>
      </div>
      <?php endforeach ?>
      <?php foreach($expert->slideshare_documents as $key=>$value): ?>
      <div class="gallery-cell" data-type="doc">
        <a href="
          <?php echo $value->embed; ?>">
        <img src="http://placehold.it/200x150/003c71/ffffff.png?text=Slideshare%0Adocument" alt="Slideshare document by 
          <?php echo $fullname; ?>">
        <span class="fa fa-file-text vidIcon" aria-hidden="true"></span>
        </a>
      </div>
      <?php endforeach ?>
      <?php endif ?>
    </div>
  </article>
  <?php endif ?>
  <!-- ****************************
    *
    * BIO PANEL AND INDEX
    *
    ***************************** -->
  <article class="medium-7 large-8 columns add_pad">
    <h3>Biography</h3>
    <p>
      <?php echo $expert->description; ?>
    </p>
  </article>
  <article class="medium-5 large-4 columns panel">
    <h3>Contents</h3>
    <hr/>
    <ul class="page_sidebar_navigation" role="local navigation" aria-label="Table of contents">
      <?php if($expert->socialprofile->twitter): ?>
      <li role="menuitem">
        <a href="#activity">
        <span class="fa fa-twitter"></span> &nbsp;Activity
        </a>
      </li>
      <?php endif; ?>
      <li class="has-children open">
        <a href="#expertise">
        <span class="fa fa-bookmark"></span> &nbsp;Expertise
        </a>
        <ul style="display:block;">
          <?php if(count($expert->accomplishments) > 0): ?>
          <li role="menuitem">
            <a href="#panel2-1">
            <span class="fa fa-trophy"></span> &nbsp;Accomplishments
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->accreditations) > 0): ?>
          <li role="menuitem">
            <a href="#panel2-2">
            <span class="fa fa-graduation-cap"></span> &nbsp;Education
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->research_grants) > 0): ?>
          <li role="menuitem">
            <a href="#panel2-3">
            <span class="fa fa-flask"></span> &nbsp;Research grants
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->affiliations) > 0): ?>
          <li role="menuitem">
            <a href="#panel2-4">
            <span class="fa fa-sitemap"></span> &nbsp;Affiliations
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->partnerships) > 0): ?>
          <li role="menuitem">
            <a href="#panel2-5">
            <span class="fa fa-users"></span> &nbsp;Partnerships
            </a>
          </li>
          <?php endif ?>
        </ul>
      </li>
      <?php if(count($expert->media_appearances) > 0 || count($expert->talks) > 0 || count($expert->past_talks) > 0 || count($expert->links) > 0) :?>
      <li class="has-children open">
        <a href="#involvement">
        <span class="fa fa-bullhorn"></span> &nbsp;Involvement
        </a>
        <ul style="display:block;">
          <?php if(count($expert->media_appearances) > 0): ?>
          <li role="menuitem">
            <a href="#involvement">
            <span class="fa fa-television"></span> &nbsp;Media appearances
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->talks) > 0): ?>
          <li role="menuitem">
            <a href="#involvement">
            <span class="fa fa-commenting"></span> &nbsp;Sample talks
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->past_talks) > 0): ?>
          <li role="menuitem">
            <a href="#involvement">
            <span class="fa fa-commenting-o"></span> &nbsp;Past speaking engagements
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->links) > 0): ?>
          <li role="menuitem">
            <a href="#involvement">
            <span class="fa fa-link"></span> &nbsp;Links
            </a>
          </li>
          <?php endif ?>
        </ul>
      </li>
      <?php endif; ?>
      <?php if(isset($expert->assessments)) :?>
      <li role="menuitem">
        <a href="#speaking">
        <span class="fa fa-microphone"></span> &nbsp;Speaking style
        </a>
      </li>
      <?php endif; ?>
      <?php if(count($expert->case_studies) > 0 || count($expert->patents) > 0 || count($expert->courses) > 0 || count($expert->articles) > 0) :?>
      <li class="has-children open">
        <a href="#related">
        <span class="fa fa-book"></span> &nbsp;Related materials
        </a>
        <ul style="display:block;">
          <?php if(count($expert->case_studies) > 0): ?>
          <li role="menuitem">
            <a href="#panel4-1">
            <span class="fa fa-bar-chart"></span> &nbsp;Case studies
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->patents) > 0): ?>
          <li role="menuitem">
            <a href="#panel4-2">
            <span class="fa fa-certificate"></span> &nbsp;Patents
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->courses) > 0): ?>
          <li role="menuitem">
            <a href="#panel4-3">
            <span class="fa fa-institution"></span> &nbsp;Courses
            </a>
          </li>
          <?php endif ?>
          <?php if(count($expert->articles) > 0): ?>
          <li role="menuitem">
            <a href="#panel4-4">
            <span class="fa fa-newspaper-o"></span> &nbsp;Articles
            </a>
          </li>
          <?php endif ?>
        </ul>
      </li>
      <?php endif; ?>
    </ul>
    <?php
      $jobTitle = strtolower($expert->user->job_title);
      if (strpos($jobTitle,'faculty of') !== false) {
        echo '
                                                    <p class="faculty_link">Visit the faculty of
                                                    </small>
                                                    <br/>';
        switch ($jobTitle) {
          case strpos($jobTitle,'graduate studies') !== false:
            echo '
                                                    <a href="http://gradstudies.uoit.ca/" class="grad">Graduate Studies &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of business and information technology') !== false:
            echo '
                                                    <a href="http://businessandit.uoit.ca/" class="fbit">Business and Information Technology &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of education') !== false:
            echo '
                                                    <a href="http://education.uoit.ca/" class="fed">Education</a>';
            break;
          case strpos($jobTitle,'faculty of energy systems and nuclear science') !== false:
            echo '
                                                    <a href="http://nuclear.uoit.ca/" class="fesns">Energy Systems and Nuclear Science &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of engineering and applied science') !== false:
            echo '
                                                    <a href="http://engineering.uoit.ca/" class="feas">Engineering and Applied Science &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of health science') !== false:
            echo '
                                                    <a href="http://healthsciences.uoit.ca/" class="fhs">Health Sciences &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of science') !== false:
            echo '
                                                    <a href="http://science.uoit.ca/" class="fsci">Science &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
          case strpos($jobTitle,'faculty of social science and humanities') !== false:
            echo '
                                                    <a href="http://socialscienceandhumanities.uoit.ca/" class="fssh">Social Science and Humanities &nbsp;
                                                        <span class="fa fa-external-link" aria-hidden="true"></span>
                                                    </a>';
            break;
        }
        echo '
                                                </p>';
      }
      ?>
  </article>
</section>
<!-- ****************************
  *
  * TWITTER FEED
  *
  ***************************** -->
<section class="row">
  <?php
    $tweets = NULL;
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
    
    if($expert->socialprofile->twitter):
      $username = str_replace("https://twitter.com/","",$expert->socialprofile->twitter);
      $tweets = get_twitter_feed($username);
    endif;
    
    if(isset($tweets) || count($tweets) > 0): ?>
  <article class="medium-4 large-3 columns">
    <div id="activity">
      <h3>Tweets 
        <small>from 
        <a href="
          <?php echo $expert->socialprofile->twitter; ?>" target="new" title="View 
          <?php echo "@".$username; ?> on twitter.com">@
        <?php echo $tweets[0]->user->screen_name; ?>
        </a>
        </small>
      </h3>
      <hr/>
      <div class="twitter_feed">
        <?php foreach ($tweets as $tweet):
          $url = $expert->socialprofile->twitter."/status/".$tweet->id."/"; ?>
        <div class="row tweet">
          <div class="small-2 columns">
            <a href="
              <?php echo $url; ?>" target="new">
            <img src="
              <?php echo $tweet->user->profile_image_url; ?>" alt="
              <?php echo "@".$username; ?>" />
            </a>
          </div>
          <div class="small-10 columns">
            <p>
              <?php
                $formatted_text = preg_replace('/(\b(www\.|http\:\/\/)\S+\b)/', "
                                                                <a target='new' href='$1'>$1</a>", $tweet->text);
                $formatted_text = preg_replace('/\#(\w+)/', "
                                                                <a target='new' href='https://twitter.com/search?q=$1'>#$1</a>", $formatted_text);
                $formatted_text = preg_replace('/\@(\w+)/', "
                                                                <a target='new' href='http://twitter.com/$1'>@$1</a>", $formatted_text);
                
                $formatted_date = $tweet->created_at;
                
                if (!is_null($formatted_date)) {
                   $formatted_date = date('F j, g:i a', strtotime($formatted_date));;
                }                    
                ?>
              <?php echo $formatted_text; ?>
              <br>
              <small>
              <em>
              <?php echo $formatted_date; ?>
              </em>
              </small>
            </p>
          </div>
        </div>
        <?php  endforeach ?>
        <div class="twitter-readmore"></div>
      </div>
      <div class="twitter_overlay"></div>
    </div>
  </article>
  <?php endif ?>
  <!-- ****************************
    *
    * EXPERTISE TABS
    *
    ***************************** -->
  <article class="
    <?php echo (isset($tweets) || count($tweets) > 0) ? 'medium-8 large-9' : 'small-12'; ?> columns add_pad">
    <h3>Expertise</h3>
    <hr/>
    <ul class="tabs" data-tab role="tablist">
      <?php if(count($expert->accomplishments) > 0): ?>
      <li class="tab-title active" role="presentation">
        <a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Accomplishments 
        <span class="label badge">
        <?php echo count($expert->accomplishments); ?>
        </span>
        </a>
      </li>
      <?php endif ?>
      <?php if(count($expert->accreditations) > 0): ?>
      <li class="tab-title 
        <?php echo count($expert->accomplishments) == 0 ? 'active' : ''; ?>" role="presentation">
        <a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">Education 
        <span class="label badge">
        <?php echo count($expert->accreditations); ?>
        </span>
        </a>
      </li>
      <?php endif ?>
      <?php if(count($expert->research_grants) > 0): ?>
      <li class="tab-title 
        <?php echo count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" role="presentation">
        <a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-3">Research Grants 
        <span class="label badge">
        <?php echo count($expert->research_grants); ?>
        </span>
        </a>
      </li>
      <?php endif ?>
      <?php if(count($expert->affiliations) > 0): ?>
      <li class="tab-title 
        <?php echo count($expert->research_grants) == 0 && count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" role="presentation">
        <a href="#panel2-4" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-4">Affiliations 
        <span class="label badge">
        <?php echo count($expert->affiliations); ?>
        </span>
        </a>
      </li>
      <?php endif ?>
      <?php if(count($expert->partnerships) > 0): ?>
      <li class="tab-title 
        <?php echo count($expert->affiliations) == 0 && count($expert->research_grants) == 0 && count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" role="presentation">
        <a href="#panel2-5" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-5">Partnerships 
        <span class="label badge">
        <?php echo count($expert->partnerships); ?>
        </span>
        </a>
      </li>
      <?php endif ?>
    </ul>
    <div class="tabs-content">
      <?php if(count($expert->accomplishments) > 0): ?>
      <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
        <ul class="
          <?php echo (isset($tweets) || count($tweets) > 0) ? 'small-block-grid-1 medium-block-grid-2 large-block-grid-3' : 'small-block-grid-2 medium-block-grid-3 large-block-grid-4'; ?>" data-equalizer="accomps">
          <?php foreach($expert->accomplishments as $key=>$value): ?>
          <li>
            <table class="fiche" data-equalizer-watch="accomps">
              <thead>
                <tr>
                  <th>
                    <span class="fa fa-trophy"></span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <h4>
                      <?php echo $value->title; ?>
                    </h4>
                  </td>
                </tr>
                <?php if ($value->start && $value->start != ''): ?>
                <tr>
                  <td class="date">
                    <?php 
                      if ($value->start != $value->end) {
                        echo date("F j, Y", $value->start).' - '.date("F j, Y", $value->end);
                      } else {
                        echo date("F j, Y", $value->start);
                      } 
                      ?>
                  </td>
                </tr>
                <?php endif ?>
                <tr>
                  <td>
                    <?php echo $value->description; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
      <?php endif ?>
      <?php if(count($expert->accreditations) > 0): ?>
      <section role="tabpanel" aria-hidden="true" class="content 
        <?php echo count($expert->accomplishments) == 0 ? 'active' : ''; ?>" id="panel2-2">
        <ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4" data-equalizer="edu">
          <?php foreach($expert->accreditations as $key=>$value): ?>
          <li>
            <table class="fiche" data-equalizer-watch="edu">
              <thead>
                <tr>
                  <th>
                    <span class="fa fa-graduation-cap"></span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <h4>
                      <?php echo $value->institution; ?>
                    </h4>
                    <h5>
                      <?php echo $value->date; ?>
                    </h5>
                  </td>
                </tr>
                <tr>
                  <td class="date">
                    <?php echo $value->degree; ?> - 
                    <?php echo $value->major; ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <?php echo $value->description; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
      <?php endif ?>
      <?php if(count($expert->research_grants) > 0): ?>
      <section role="tabpanel" aria-hidden="true" class="content 
        <?php echo count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" id="panel2-3">
        <ul class="block_list">
          <?php foreach($expert->research_grants as $key=>$value): ?>
          <li>
            <div class="row">
              <div class="small-12 medium-1 columns">
                <span class="fa fa-flask"></span>
              </div>
              <div class="small-12 medium-11 columns">
                <h4>
                  <?php echo $value->title; ?>
                </h4>
                <h5>
                  <?php echo ($value->amount == "0" ? "" : "$" . $value->amount); ?>
                  <?php if(date('Y-m-d', $value->date) != '1970-01-01') : ?>
                  &nbsp;|&nbsp;
                  <em>
                  <?php echo date('F j, Y', $value->date) ?>
                  </em>
                  <?php endif ?>
                </h5>
                <p>
                  <em>Awarded by: 
                  <?php echo $value->organization; ?>
                  </em>
                  <br/>
                  <?php echo $value->details; ?>
                </p>
              </div>
            </div>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
      <?php endif ?>
      <?php if(count($expert->affiliations) > 0): ?>
      <section role="tabpanel" aria-hidden="true" class="content 
        <?php echo count($expert->research_grants) == 0 && count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" id="panel2-4">
        <ul class="block_list">
          <?php foreach($expert->affiliations as $key=>$value): ?>
          <li>
            <?php echo $value->link ? '
              <a href="'.$value->link.'">' : ''; ?>
            <p>
              <?php echo $value->name; echo $value->notes ? '
                <br/>'.$value->notes : ''; ?>
            </p>
            <?php echo $value->link ? '
              </a>' : ''; ?>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
      <?php endif ?>
      <?php if(count($expert->partnerships) > 0): ?>
      <section role="tabpanel" aria-hidden="true" class="content 
        <?php echo count($expert->affiliations) == 0 && count($expert->research_grants) == 0 && count($expert->accreditations) == 0 && count($expert->accomplishments) == 0 ? 'active' : ''; ?>" id="panel2-5">
        <ul class="block_list">
          <?php foreach($expert->partnerships as $key=>$value): ?>
          <li>
            <div class="row">
              <div class="small-12 medium-1 columns">
                <span class="fa fa-users"></span>
              </div>
              <div class="small-12 medium-11 columns">
                <h4>
                  <?php echo $value->title; ?>
                </h4>
                <h5>
                  <?php echo $value->individual ?>, 
                  <?php echo $value->organization ?>
                  <?php if(date('Y-m-d', $value->date) != '1970-01-01') : ?>
                  &nbsp;|&nbsp;
                  <em>
                  <?php echo date('F j, Y', $value->date) ?>
                  </em>
                  <?php endif ?>
                </h5>
                <p>
                  <?php echo $value->details; ?>
                </p>
              </div>
            </div>
          </li>
          <?php endforeach ?>
        </ul>
      </section>
      <?php endif ?>
    </div>
  </article>
</section>
<!-- ****************************
  *
  * MEDIA APPEARANCES, TALKS, PAST TALKS, LINKS
  *
  ***************************** -->
<?php if(count($expert->media_appearances) > 0 || count($expert->talks) > 0 || count($expert->past_talks) > 0 || count($expert->links) > 0) :?>
<section class="row add_pad">
  <h3>Involvement</h3>
  <hr/>
  <ul class="accordion" role="tablist" id="involvement">
    <?php if(count($expert->media_appearances) > 0): ?>
    <li class="accordion-navigation">
      <a href="#panel3-1" role="tab" id="panel3-1-heading" aria-controls="panel3-1">
        <h3>Media appearances</h3>
      </a>
      <div id="panel3-1" class="content" role="tabpanel" aria-labelledby="panel3-1-heading">
        <ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-4">
          <?php foreach($expert->media_appearances as $key=>$media_appearance): ?>
          <li>
            <?php if(isset($media_appearance->cover_url) && $media_appearance->cover_url !=''): ?>
            <p>
              <img src="
                <?php echo $media_appearance->large_cover_url ?>" alt="
                <?php echo $media_appearance->title.': media appearance by'.$fullname; ?>" />
            </p>
            <?php else: ?>
            <p>
              <img src="http://placehold.it/300x200/003c71/ffffff.png?text=No+photo+available" alt="
                <?php echo $media_appearance->title.': media appearance by'.$fullname; ?>" />
            </p>
            <?php endif ?>
            <h4>
              <?php echo $media_appearance->title ?>
              <br/>
              <small>
              <?php echo $media_appearance->organization ?>&nbsp;
              <?php echo $media_appearance->type ?>
              </small>
            </h4>
            <?php echo (date('Y-m-d', $media_appearance->date) != '1970-01-01') ? '
              <p>'.date('F j, Y', $media_appearance->date).'</p>' : ''; ?>
            <?php echo $media_appearance->details ?>
            </p>
            <?php if($media_appearance->url != ''): ?>
            <p>
              <a href="
                <?php echo $media_appearance->url ?>" target="new" class="button">view more
              </a>
            </p>
            <?php endif ?>
          </li>
          <?php endforeach ?>
        </ul>
      </div>
    </li>
    <?php endif ?>
    <?php if(count($expert->past_talks) > 0): ?>
    <li class="accordion-navigation">
      <a href="#panel3-2" role="tab" id="panel3-2-heading" aria-controls="panel3-2">
        <h3>Past speaking engagements</h3>
      </a>
      <div id="panel3-2" class="content" role="tabpanel" aria-labelledby="panel3-2-heading">
        <ul class="block_list">
          <?php foreach($expert->past_talks as $key=>$value): ?>
          <li>
            <h4>
              <?php echo $value->title; ?>
            </h4>
            <h5>
              <?php echo $value->location; ?>
              <br/>
              <?php echo (date('Y-m-d', $value->date) != '1970-01-01') ? date('F j, Y', $value->date) : ''; ?>
            </h5>
            <p>
              <?php echo $value->event_name; ?>
            </p>
          </li>
          <?php endforeach ?>
        </ul>
      </div>
    </li>
    <?php endif ?>
    <?php if(count($expert->talks) > 0): ?>
    <li class="accordion-navigation">
      <a href="#panel3-3" role="tab" id="panel3-3-heading" aria-controls="panel3-3">
        <h3>Sample talks</h3>
      </a>
      <div id="panel3-3" class="content" role="tabpanel" aria-labelledby="panel3-3-heading">
        <ul class="block_list">
          <?php foreach($expert->talks as $key=>$value): ?>
          <div class="display_item">
            <h4>
              <?php echo $value->title; ?>
            </h4>
            <p>
              <?php echo $value->description; ?>
            </p>
          </div>
          <?php endforeach ?>
        </ul>
      </div>
    </li>
    <?php endif ?>
    <?php if(count($expert->links) > 0): ?>
    <li class="accordion-navigation">
      <a href="#panel3-4" role="tab" id="panel3-4-heading" aria-controls="panel3-4">
        <h3>Links</h3>
      </a>
      <div id="panel3-4" class="content" role="tabpanel" aria-labelledby="panel3-4-heading">
        <p>
        <ul class="inline-list">
          <?php foreach($expert->links as $key=>$value): ?>
          <li>
            <a href="
              <?php echo $value->url; ?>" target="new">
            <?php echo $value->name; ?> &nbsp;
            <span class="fa fa-external-link"></span>
            </a>
          </li>
          <?php endforeach ?>
        </ul>
        </p>
      </div>
    </li>
    <?php endif ?>
  </ul>
</section>
<?php endif ?>
<!-- ****************************
  *
  * SPEAKING STYLE
  *
  ***************************** -->
<?php if(isset($expert->assessments)) :?>
<section class="row">
  <article class="small-12 medium-6 columns" id="speaking">
    <h3 class="sectionheader">Speaking Style</h3>
    <hr/>
    <div class="panel">
      <?php foreach($expert->assessments as $key=>$assessment): ?>
      <?php if($key == 1):?>
      <div class="row">
        <div class="small-12 columns">
          <div class="progress">
            <span class="meter" style="width: 
              <?php echo $assessment; ?>%" title="
              <?php echo $assessment; ?> per cent 'Entertaining'" aria-labelledby="spk_entertaining">
            <label id="spk_entertaining">Entertaining</label>
            </span>
            <span class="meter secondary" style="width: 
              <?php echo (100 - $assessment); ?>%" title="
              <?php echo (100 - $assessment); ?> per cent 'Educational'" aria-labelledby="spk_educational">
            <label id="spk_educational">Educational</label>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php if($key == 2):?>
      <div class="row">
        <div class="small-12 columns">
          <div class="progress">
            <span class="meter" style="width: 
              <?php echo $assessment; ?>%" title="
              <?php echo $assessment; ?> per cent 'Tactical'" aria-labelledby="spk_tactical">
            <label id="spk_tactical">Tactical</label>
            </span>
            <span class="meter secondary" style="width: 
              <?php echo (100 - $assessment); ?>%" title="
              <?php echo (100 - $assessment); ?> per cent 'Strategic'" aria-labelledby="spk_strategic">
            <label id="spk_strategic">Strategic</label>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php if($key == 3):?>
      <div class="row">
        <div class="small-12 columns">
          <div class="progress">
            <span class="meter" style="width: 
              <?php echo $assessment; ?>%" title="
              <?php echo $assessment; ?> per cent 'Interactive'" aria-labelledby="spk_interactive">
            <label id="spk_interactive">Interactive</label>
            </span>
            <span class="meter secondary" style="width: 
              <?php echo (100 - $assessment); ?>%" title="
              <?php echo (100 - $assessment); ?> per cent 'Lecture'" aria-labelledby="spk_lecture">
            <label id="spk_lecture">Lecture</label>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php if($key == 4):?>
      <div class="row">
        <div class="small-12 columns">
          <div class="progress">
            <span class="meter" style="width: 
              <?php echo $assessment; ?>%" title="
              <?php echo $assessment; ?> per cent 'Relaxed'" aria-labelledby="spk_relaxed">
            <label id="spk_relaxed">Relaxed</label>
            </span>
            <span class="meter secondary" style="width: 
              <?php echo (100 - $assessment); ?>%" title="
              <?php echo (100 - $assessment); ?> per cent 'Formal'" aria-labelledby="spk_formal">
            <label id="spk_formal">Formal</label>
            </span>
          </div>
        </div>
      </div>
      <?php endif ?>
      <?php endforeach ?>
    </div>
  </article>
</section>
<?php endif ?>
<!-- ****************************
  *
  * CASE STUDIES, PATENTS, COURSES, ARTICLES
  *
  ***************************** -->
<?php if(count($expert->case_studies) > 0 || count($expert->patents) > 0 || count($expert->courses) > 0 || count($expert->articles) > 0) :?>
<article class="small-12
  <?php echo (isset($expert->assessments) && $expert->assessments > 0) ? ' medium-6' : ''; ?> columns add_pad">
  <h3>Related Materials</h3>
  <hr/>
  <ul class="tabs" data-tab role="tablist">
    <?php if(count($expert->case_studies) > 0): ?>
    <li class="tab-title active" role="presentation">
      <a href="#panel4-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel4-1">Case Studies 
      <span class="label badge">
      <?php echo count($expert->case_studies); ?>
      </span>
      </a>
    </li>
    <?php endif ?>
    <?php if(count($expert->patents) > 0): ?>
    <li class="tab-title 
      <?php echo count($expert->case_studies) == 0 ? 'active' : ''; ?>" role="presentation">
      <a href="#panel4-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel4-2">Patents 
      <span class="label badge">
      <?php echo count($expert->patents); ?>
      </span>
      </a>
    </li>
    <?php endif ?>
    <?php if(count($expert->courses) > 0): ?>
    <li class="tab-title 
      <?php echo count($expert->patents) == 0 && count($expert->case_studies) == 0 ? 'active' : ''; ?>" role="presentation">
      <a href="#panel4-3" role="tab" tabindex="0" aria-selected="false" aria-controls="panel4-3">Courses 
      <span class="label badge">
      <?php echo count($expert->courses); ?>
      </span>
      </a>
    </li>
    <?php endif ?>
    <?php if(count($expert->articles) > 0): ?>
    <li class="tab-title 
      <?php echo count($expert->courses) == 0 && count($expert->patents) == 0 && count($expert->case_studies) == 0 ? 'active' : ''; ?>" role="presentation">
      <a href="#panel4-4" role="tab" tabindex="0" aria-selected="false" aria-controls="panel4-4">Articles 
      <span class="label badge">
      <?php echo count($expert->articles); ?>
      </span>
      </a>
    </li>
    <?php endif ?>
  </ul>
  <div class="tabs-content">
  <?php if(count($expert->case_studies) > 0) :?>
  <section role="tabpanel" aria-hidden="true" class="content active" id="panel4-1">
    <?php foreach($expert->case_studies as $key=>$study): ?>
    <div class="row">
      <div class="small-2 large-1 columns">
        <?php if(isset($case_study->cover_url) && $case_study->cover_url !=''): ?>
        <a href="
          <?php echo $case_study->large_cover_url ?>" target="new">
        <img src="
          <?php echo $study->cover_url ?>" alt="
          <?php echo $study->title ?>" />
        </a>
        <?php else: ?>
        <span class="fa fa-certificate materIcon" aria-hidden="true"></span>
        <?php endif ?>
      </div>
      <div class="small-10 large-11 columns">
        <h4>
          <?php echo $study->title ?>
          <br/>
          <small>
          <?php echo $study->subtitle ?>
          </small>
        </h4>
        <?php if(date('Y-m-d', $study->date) != '1970-01-01') : ?>
        <h5>
          <?php echo date('F j, Y', $study->date) ?>
        </h5>
        <?php endif?>
      </div>
      <div class="small-12 columns">
        <p>
          <?php echo $study->details ?>
        </p>
        <?php if($study->url != ''): ?>
        <p>
          <a href="
            <?php echo $study->url ?>" class="buttonWhite" target="new">View this case study
          </a>
        </p>
        <?php endif?>
      </div>
    </div>
    <hr/>
    <?php endforeach ?>
  </section>
  <?php endif ?>
  <?php if(count($expert->patents) > 0) :?>
  <section role="tabpanel" aria-hidden="true" class="content 
    <?php echo count($expert->case_studies) == 0 ? 'active' : ''; ?>" id="panel4-2">
    <?php foreach($expert->patents as $key=>$patent): ?>
    <div class="row">
      <div class="small-2 large-1 columns">
        <span class="fa fa-certificate materIcon" aria-hidden="true"></span>
      </div>
      <div class="small-10 large-11 columns">
        <h4>
          <?php echo $patent->title ?>
          <br/>
          <small>
          <em>
          <?php echo $patent->number ?>
          </em>
          </small>
        </h4>
        <?php if(date('Y-m-d', $patent->date) != '1970-01-01') : ?>
        <h5>
          <?php echo date('F j, Y', $patent->date) ?>
        </h5>
        <?php endif?>
      </div>
      <div class="small-12 columns">
        <p>
          <?php echo $patent->detail ?>
        </p>
        <?php if($patent->url != ''): ?>
        <p>
          <a href="
            <?php echo $patent->url ?>" class="buttonWhite" target="new">View this patent
          </a>
        </p>
        <?php endif?>
      </div>
    </div>
    <hr/>
    <?php endforeach ?>
  </section>
  <?php endif ?>
  <?php if(count($expert->courses) > 0) :?>
  <section role="tabpanel" aria-hidden="true" class="content 
    <?php echo count($expert->patents) == 0 && count($expert->case_studies) == 0 ? 'active' : ''; ?>" id="panel4-3">
    <?php foreach($expert->courses as $key=>$course): ?>
    <div class="row">
      <div class="small-2 large-1 columns">
        <span class="fa fa-university materIcon" aria-hidden="true"></span>
      </div>
      <div class="small-10 large-11 columns">
        <h4>
          <?php echo $course->title ?>
        </h4>
        <h5>
          <?php echo $course->details ?>
        </h5>
        <?php if($course->url != ''): ?>
        <p>
          <a href="
            <?php echo $course->url ?>" class="buttonWhite" target="new">View this course
          </a>
        </p>
        <?php endif?>
      </div>
    </div>
    <hr/>
    <?php endforeach ?>
  </section>
  <?php endif ?>
  <?php if(count($expert->articles) > 0) :?>
  <section role="tabpanel" aria-hidden="true" class="content 
    <?php echo count($expert->courses) == 0 && count($expert->patents) == 0 && count($expert->case_studies) == 0 ? 'active' : ''; ?>" id="panel4-4">
    <?php foreach($expert->articles as $key=>$article): ?>
    <div class="row">
      <div class="small-2 large-1 columns">
        <span class="fa fa-thumb-tack materIcon" aria-hidden="true"></span>
      </div>
      <div class="small-10 large-11 columns">
        <h4>
          <?php echo $article->title ?>
        </h4>
        <h5>Published in 
          <em>
          <?php echo $article->publisher ?>
          </em>
          <?php echo (date('Y-m-d', $article->date) != '1970-01-01') ? ', '.date('F j, Y', $article->date) : ''; ?>
        </h5>
      </div>
      <div class="small-12 columns">
        <p>
          <?php echo $article->details ?>
        </p>
        <p>
          <a href="
            <?php echo $article->url ?>" class="buttonWhite" target="new">Read more
          </a>
        </p>
      </div>
    </div>
    <hr/>
    <?php endforeach ?>
  </section>
  <?php endif ?>
</article>
<?php endif ?>
</section>
<div id="socialShare">
  <div id="twitter" data-text="
    <?php echo 'I just found '.$fullname.' on UOIT\'s Expert Centre!' ?>" data-url="http://uoit.ca/expertcentre/?expert=
    <?php echo $expert->user->username; ?>" data-title="
    <span class='fa fa-twitter'></span>
    <span class='scl_title'>Tweet</span>">
  </div>
  <div id="facebook" data-text="
    <?php echo 'I just found '.$fullname.' on UOIT\'s Expert Centre!' ?>" data-url="http://uoit.ca/expertcentre/?expert=
    <?php echo $expert->user->username; ?>" data-title="
    <span class='fa fa-thumbs-up'></span>
    <span class='scl_title'>Like</span>">
  </div>
  <div id="googleplus" data-text="
    <?php echo 'I just found '.$fullname.' on UOIT\'s Expert Centre!'?>" data-url="http://uoit.ca/expertcentre/?expert=
    <?php echo $expert->user->username; ?>" data-title="
    <span class='fa fa-google-plus-square'></span>
    <span class='scl_title'>+1</span>">
  </div>
</div>
<!-- EMPTY MODAL -->
<div id="mediaDisplay" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" aria-live="assertive" role="dialog"></div>