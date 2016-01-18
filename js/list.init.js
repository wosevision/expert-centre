var experts = [];

var giantArrayOfStuff = [];

/*!
 * Main scripts
 */

function loadSearch(event) {
    var query = $('#expert-search').val();

		$( "#expert-list" ).addClass("loading").load( "index.php #expert-list-inner", "q="+query, function() {
			$( "#expert-list" ).removeClass("loading");
		});

    // stop the form from submitting the normal way and refreshing the page
    event.preventDefault();
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

function initList () {

	$('.stickyNav').stickyNav({
    additionalMarginTop: 80
  });
	
	$.getJSON( "search.php", function( data ) {

		experts = data;

		for (var i = 0; i <= experts.length; i++) {

			if (experts[i]) {
				if (giantArrayOfStuff.indexOf(experts[i].city) == -1) {
					giantArrayOfStuff.push(experts[i].city);
				}

				var st = experts[i].firstname;
				var sp = st.split(" ");
				for (var j = 0; j <= sp.length; j++) {
					if (giantArrayOfStuff.indexOf(sp[j]) == -1 && sp[j] != "") {
						giantArrayOfStuff.push(sp[j]);
					}
				}

				if (giantArrayOfStuff.indexOf(experts[i].lastname) == -1) {
					giantArrayOfStuff.push(experts[i].lastname);
				}

				st = experts[i].job_title;
				sp = st.split(" ");
				for (var j = 0; j <= sp.length; j++) {
					if (giantArrayOfStuff.indexOf(sp[j]) == -1 && sp[j] != "" && sp[j] != "." &&  sp[j] != ",") {
						giantArrayOfStuff.push(sp[j]);
					}
				}

				st = experts[i].tagline;
				sp = st.split(" ");
				for (var j = 0; j <= sp.length; j++) {
					if (giantArrayOfStuff.indexOf(sp[j]) == -1 && sp[j] != "" && sp[j] != "." &&  sp[j] != ",") {
						giantArrayOfStuff.push(sp[j]);
					}
				} //endfor
			} //endif
		} //endfor

	});

	var input = document.getElementById("expert-search");

	new Awesomplete(input, {
		list: giantArrayOfStuff
	});

	// *********************
	// *
	// * FILTERING
	// *
	// *********************
  $('#expert-searchform').submit(loadSearch);

  $('.expert-filter').click(loadFilter);

	$('select#availability').change(function(event){
		var filter = "a=" + $(this).val();
		$( "#expert-list" ).addClass("loading").load( "index.php #expert-list-inner", filter, function() {
			$( "#expert-list" ).removeClass("loading");
		});
	});	
	
	$('select#expertise').change(function(event){
		var filter = "i=" + $(this).val();
		$( "#expert-list" ).addClass("loading").load( "index.php #expert-list-inner", filter, function() {
			$( "#expert-list" ).removeClass("loading");
		});
	});

}

$(document).ready(initList);