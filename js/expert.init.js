function loadMediaFilter(event) {
    event.preventDefault();
    var filter = $(this).attr('href');
    filter = filter.replace('?','');
    $('#media-gallery-filters dl dd, #media-gallery-filters dl dd a').removeClass('active');
    $(this).addClass('active');
		$( "#media-gallery" ).addClass("loading").load( "index.php #media-gallery-inner", filter, function() {
			$( "#media-gallery" ).removeClass("loading");
			initExpert();
		});
}

function loadFilter(event) {
    event.preventDefault();
    var filter = $(this).attr('href');
    filter = filter.replace('?','');

		$( "#expert-list" ).addClass("loading").load( "index.php #expert-list-inner", filter, function() {
			$( "#expert-list" ).removeClass("loading");
			$('.expert-filter').click(loadFilter);
		});
}

function loadMedia(event, pointer, cellElement, cellIndex) {
	// dismiss if cell was not clicked
  if ( !cellElement ) { return; }

  $(this).flickity('select', cellIndex);

  var url = $(cellElement).data('href');
  var type = $(cellElement).data('type');

  $(this).on( 'settle', function() {
  	switch(type) {
  		case 'img':
				$('#mediaDisplay').html('<img src="'+url+'"><a class="close-reveal-modal" aria-label="Close">&#215;</a>')
													.foundation('reveal','open');
				$(this).unbind('settle')
  			break;
  		case 'vid':
  			$('#mediaDisplay').html('<iframe src="'+url+'"></iframe><a class="close-reveal-modal" aria-label="Close">&#215;</a>')
													.foundation('reveal','open');
				$(this).unbind('settle')
  			break;
  		case 'book':

  			break;
  		case 'doc':

  			break;
  	}
	});
}

function initExpert () {

	$('#twitter').sharrre({
	  share: {
	    twitter: true
	  },
	  enableHover: false,
	  //enableTracking: true,
	  click: function(api, options){
	    api.simulateClick();
	    api.openPopup('twitter');
	  }
	});
	$('#facebook').sharrre({
	  share: {
	    facebook: true
	  },
	  enableHover: false,
	  //enableTracking: true,
	  click: function(api, options){
	    api.simulateClick();
	    api.openPopup('facebook');
	  }
	});
	$('#googleplus').sharrre({
	  share: {
	    googlePlus: true
	  },
	  enableHover: false,
	  //enableTracking: true,
	  click: function(api, options){
	    api.simulateClick();
	    api.openPopup('googlePlus');
	  }
	});

	$('.tabs').on('toggled', function (event, tab) {
    $(document).foundation('equalizer', 'reflow');
  });

	mediaCount = $('.gallery-nav .gallery-cell').size();
  mediaIndex = Math.floor( mediaCount / 2);
  mediaWrap = false;
  mediaContain = true;
  if (mediaCount > 7) {
  	mediaWrap = true;
  	mediaContain = false;
  }

	$('.gallery-nav').flickity({
			"cellAlign": 'center',
			initialIndex: mediaIndex,
			wrapAround: mediaWrap,
			contain: mediaContain
  });

	// *********************
	// *
	// * CLICK HANDLERS
	// *
	// *********************

  $('.expert-filter').on('click', loadFilter);
	$('.media-filter').on('click', loadMediaFilter);

	$('.gallery-nav').on( 'staticClick', loadMedia);
}

$(document).ready(initExpert);