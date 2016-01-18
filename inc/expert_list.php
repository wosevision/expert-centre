<!-- ****************************
*
* HERO PANEL
*
***************************** --> 
<section class="row">
  <div class="large-12 columns add_pad">

    <h1>UOIT EXPERT CENTRE</h1><hr/>   
    <h2>Meet Our Experts</h2>
    <p>To keep pace with today's ever-changing news cycle, we have now launched our enhanced UOIT Expert Centre - your source to discover UOIT's diverse collection of faculty expertise and thought leadership. These expert profiles feature rich multimedia content, detailed biographies and trending topic tags that will help you find the appropriate expert to provide analysis, commentary and insight on today's most engaging industry trends and developments.</p>
    <p>Addressing qualified media and conference speaking requests is a priority for the UOIT media relations office. Please use the connect button on each expert profile to send us a direct inquiry and we will respond in a timely manner.</p>
  </div>
</section>

<br/>
   
<section class="row">
<!-- ****************************
*
* FILTER PANEL
*
***************************** -->    
  <aside class="medium-3 columns section_content_wrapper stickyNav">
    <h3>FILTERS</h3>
    <hr>
    <?php 
      $industrySort = array();
      $availabilitySort = array();
      foreach ($filters->filters->industries as $key => $value) {
        $industrySort[$key] = $value->industry_name;
      }
      array_multisort($industrySort, SORT_ASC, $filters->filters->industries);
    ?>
    <div class="section-container vertical-nav" data-section data-options="deep_linking: false; one_up: true">
      <section class="section">
        <label for="expertise"><h4>Industry Expertise</h4></label>
        <select id="expertise">
          <option value="">-- all industries --</option>
          <?php foreach($filters->filters->industries as $key=>$value): ?>
            <?php if($value->industry_id == $filter_industry): ?>
              <option selected="selected" value="<?php echo $value->industry_id; ?>"><?php echo $value->industry_name; ?> (<?php echo $value->count; ?>)</option>         
            <?php else: ?>
              <option value="<?php echo $value->industry_id; ?>"><?php echo $value->industry_name; ?> (<?php echo $value->count; ?>)</option>
            <?php endif ?>  
          <?php endforeach ?>               
        </select>
      </section>
      <section class="section">
        <label for="availability"><h4>Speaking Availability</h4></label>
        <select id="availability">
          <option value="">-- all availability --</option>    
          <?php foreach($filters->filters->availability as $key=>$value): ?>
            <?php if($value[0] == $filter_availability): ?>
              <option selected="selected" value="<?php echo $value[0]; ?>"><?php echo ($key !== 'host_mc') ? ucfirst($key): 'Host MC'; ?> (<?php echo $value[1]; ?>)</option>        
            <?php else: ?>
              <option value="<?php echo $value[0]; ?>"><?php echo ($key !== 'host_mc') ? ucfirst($key): 'Host MC'; ?> (<?php echo $value[1]; ?>)</option>
            <?php endif ?>        
            
          <?php endforeach ?>                 
        </select>
      </section>
      <section class="section">
        <label for="expert-search" class="search_label"><h4>Keyword</h4></label>
         
        <form method="get" name="sitesearch" id="expert-searchform" action="" class="clearfix">
          <div class="row collapse">
              <div class="small-10 columns">
              <?php if($filter_keyword != ''): ?>
                <input class="textfield" type="text" value="<?php echo $filter_keyword; ?>" maxlength="256" id="expert-search" name="q">
                <?php else: ?>
                <input class="textfield" type="text" placeholder="Enter search term" maxlength="256" id="expert-search" name="q" value="">
                <?php endif ?>
              </div>
              <div class="small-2 columns">
                <button type="button" class="button postfix" onclick="loadSearch();"><span class="fa fa-search" title="Search" aria-hidden="true"></span></button>
              </div>
          </div>            
        </form>

      </section>
      <hr>
      <section class="section">
        <a href="" class="button">Reset Filters</a>
      </section>
    </div>
  </aside>

   
<!-- ****************************
*
* EXPERTS PANEL
*
***************************** -->
  <section class="medium-6 columns add_pad" id="expert-list">
    <div id="expert-list-inner">
      <span class="fa fa-spinner loader" aria-hidden="true"></span>

      <?php if(isset($total) && $total > 0): ?>
      <!-- RESULT COUNT AND NARROWING OPTIONS -->
      <div class="row">
        <dl class="sub-nav">
          <dt style="margin-left:0;">Sort by:</dt>
          <dd class="<?php echo ($_GET['s'] == 'name') ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['n'])) ? 'n='.$_GET['n'].'&' : ''; ?>s=name">A - Z</a>
          </dd>
          <dd class="<?php echo ($_GET['s'] == 'featured') ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['n'])) ? 'n='.$_GET['n'].'&' : ''; ?>s=featured">Featured</a>
          </dd>
          <dd class="<?php echo ($_GET['s'] == 'updated') ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['n'])) ? 'n='.$_GET['n'].'&' : ''; ?>s=updated">Recently updated</a>
          </dd>
        </dl>
        <dl class="sub-nav">
          <dt>Page size:</dt>
          <dd class="<?php echo ($_GET['n'] == 5) ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['s'])) ? 's='.$_GET['s'].'&' : ''; ?>n=5">5</a>
          </dd>
          <dd class="<?php echo ($_GET['n'] == 10) ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['s'])) ? 's='.$_GET['s'].'&' : ''; ?>n=10">10</a>
          </dd>
          <dd class="<?php echo ($_GET['n'] == 20) ? 'active' : ''; ?>">
            <a class="expert-filter" href="?<?php echo (isset($_GET['s'])) ? 's='.$_GET['s'].'&' : ''; ?>n=20">20</a>
          </dd>
        </dl>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <p class="right"><?php echo $searchDetail; ?></p>
        </div>
      </div>

      <br/>

      <?php foreach($experts as $key=>$value):
        $fullname =  $value->firstname.' '.$value->lastname; 
        $fullname = preg_replace('/\s+/', ' ', $fullname);
        $topicData = array();
        foreach($value->topics as $k=>$t) { $topicData[] = intval($t->id); }
        $topicData = json_encode($topicData);
      ?>
        <article class="row expert" data-topics="<?php echo $topicData; ?>">
          <div class="small-3 columns">
            <?php if(isset($value->url)): ?>
              <a href="?expert=<?php echo $value->username; ?>">
                <img class="expert_avatar" src="<?php echo $value->url; ?>" alt="<?php echo $fullname; ?>"/>
              </a>
            <?php endif ?>
          </div>
          <div class="small-9 columns">
            <h4><strong><?php echo $fullname; ?><br/>
            <small><?php echo $value->job_title ?> | <?php echo $value->city?>, <?php echo $value->state?>, <?php echo $value->country == 'CA' ? 'CAN' : $value->country; ?></small></strong></h4>
            <p><?php echo $value->tagline; ?></p>
            <a href="?expert=<?php echo $value->username; ?>" class="button" title="View <?php echo $fullname; ?>'s profile">View Profile</a>&nbsp;
            <a href="//expertfile.com/experts/inquire/<?php echo urlencode($value->username); ?>" class="buttonWhite" title="Inquire on expertfile.com" target="new"><span class="fa fa-envelope" aria-hidden="true"></span> Inquire</a>
            <hr/>
            <h5>RESEARCH TOPICS</h5>
            <div class="row">
              <div class="small-12 columns">
                <?php foreach($value->topics as $k=>$t) {
                    echo '<a href="?q='.urlencode($t->name).'" class="label expert-filter">'.$t->name.'</a>';
                  } 
                ?>
              </div>
            </div>
          </div>
        </article>
        
        <hr/>

      <?php endforeach;
        echo $pagination;
        else: ?>
        <section class="row">
          <article class="small-12 columns">
            <h3 class="text-center">SORRY!<br/>
              <small>No experts found based on your criteria. Please try altering your query.</small>
            </h3>
          </article>
        </section>
      <?php endif ?>
    </div>
  </section>


       
<!-- ****************************
*
* CONTACT PANEL
*
***************************** -->
  <aside class="medium-3 columns section_content_wrapper text-center stickyNav">
    <h4>Can't find who you're<br aria-hidden="true" />looking for?<br/>
    <small>Contact us and we'll help you find the perfect expert!</small></h4>
    <hr/>
    <div class="row">
      <div class="small-6 medium-12 columns">
        <p>
          <strong>Melissa Levy</strong><br/>
          905.721.8668 ext. 6733<br/>
          <a href="mailto:melissa.levy@uoit.ca">melissa.levy@uoit.ca</a>
        </p>
      </div>
      <div class="small-6 medium-12 columns">
        <p>
          <strong>Bryan Oliver</strong><br/>
          905.721.8668 ext. 6709<br/>
          <a href="mailto:bryan.oliver@uoit.ca">bryan.oliver@uoit.ca</a>
        </p>
      </div>
    </div>
    <p>General inquiries to the department can also be emailed to <a href="mailto:communications@uoit.ca">communications@uoit.ca</a>.</p>
  </aside>

</section>