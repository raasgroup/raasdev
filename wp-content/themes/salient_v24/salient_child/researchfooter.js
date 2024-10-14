var bStatus = true;
var bFirst = true;
var nASX = 0;
var numSteps = 20.0;

const options={
    root:null,
    rootMargin:'0px',
    threshold:0.9
 };

window.top.postMessage('hello', '*');

const target = document.querySelector('.animated-text');

const observer = new IntersectionObserver(handleIntersection, options);
observer.observe(target);

const res = document.getElementById('result');

observer2 = new MutationObserver(mutationRecords => 
{
	if (bStatus && isInViewport(res))
    	LoadChildCategory();

//	if (bFirst)
//		observer.observe(target, handleIntersection);
});

var bSelectionView = false;
function handleIntersection(entries, observer) 
{
	entries.forEach(entry => {
	if (bStatus && entry.isIntersecting && bSelectionView) 
	 	LoadChildCategory();
	});
	bSelectionView = true;
}

// observe everything except attributes
observer2.observe(res, 
{
  childList: true, // observe direct children
  subtree: true, // and lower descendants too
  characterDataOldValue: true // pass old data to callback
});

function buildThresholdList() 
{
	var thresholds = [];
  
	for (var i=1.0; i<=numSteps; i++) {
	  var ratio = i/numSteps;
	  thresholds.push(ratio);
	}
  
	thresholds.push(0);
	return thresholds;
}

function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

var isRequestIdleCallbackScheduled = false;
var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

function LoadChildCategory() {

	// Only schedule the rIC if one has not already been set.
	if (isRequestIdleCallbackScheduled)
		return;

	isRequestIdleCallbackScheduled = true;

	if ('processLoadChildCategory' in window && !isSafari) 
	{
  		// Wait at most two seconds before processing events.
 	    console.log("Schedule Load Category");
   		requestIdleCallback(processLoadChildCategory, { timeout: 2000 });
	}
	else 
	{
		processLoadChildCategory();
	}
}

function processLoadChildCategory()
{
	if (bStatus == false)
		return;

	var cat_parent = jQuery('#search_cat_parent').val();
    var subcat_parent = jQuery('#child_of_childcategory').val(); 
	var child_of_child_cat = jQuery('#child_ofchild__childcategory').val();
    var sort_by_val="";
    var sort_by = jQuery('#sort_by').val();	
    var p_cat_val="true";

    get_ajax_record(cat_parent, subcat_parent, child_of_child_cat, sort_by, sort_by_val, p_cat_val, bFirst);

//    if (jQuery('#search_cat_parent').val() !== null)
	if (document.querySelector('#search_cat_parent').selectedIndex > 0)
	{
        document.getElementById('search_cat_sub').style.display = 'inline';
		if (document.querySelector('#child_of_childcategory').selectedIndex > 0)
        	document.getElementById('search_cat_sub2').style.display = 'inline';
    	else
        	document.getElementById('search_cat_sub2').style.display = 'none';

	}
    else
	{
		document.getElementById('search_cat_sub').style.display = 'none';
        document.getElementById('search_cat_sub2').style.display = 'none';
	}

	isRequestIdleCallbackScheduled = false;

	return bStatus;
}

jQuery('#search_cat_parent').on('change', function() 
{
	bStatus = true;
	CheckSelectionView();
	jQuery('#child_of_childcategory').val('');
	jQuery('#child_ofchild__childcategory').val('');
	jQuery('#result').html('');
});

jQuery('#child_of_childcategory').on('change', function() 
{
	bStatus = true;
	CheckSelectionView();
	jQuery('#child_ofchild__childcategory').val('');
	jQuery('#result').html('');
});

jQuery('#child_ofchild__childcategory').on('change', function() 
{
	bStatus = true;

	CheckSelectionView();
	jQuery('#result').html('');
}); 

function CheckSelectionView()
{
	//if (!isInViewport(res))
	//	bSelectionView = false;
}

function get_ajax_record(cat_parent='', subcat_parent='', child_of_child_cat='', sort_by='', sort_by_val='', p_cat_val=false)
{
	if ( jQuery('#asx1').length) 
	{
		nASX = document.getElementById("asx1").innerHTML;
		jQuery('#asx1').remove('');
	}

	var pdata = {
        action: "get_child_category_by_parent_id_func",
        parent_cat_id: cat_parent,
		sub_cat_id: subcat_parent,
		sub_child_cat_id: child_of_child_cat,
		sort_by:sort_by,
		sort_by_val:sort_by_val,
		p_cat_val: p_cat_val,
		b_first: bFirst,
		n_asx:nASX,
    }
	bFirst = false;
	var admin_url = "<?php echo admin_url('admin-ajax.php') ?>"; 

    jQuery('.loader_custom').show();
	
	var nSelected = document.querySelector('#child_of_childcategory').selectedIndex;
	if (nSelected < 0)
		nSelected = 0;

	var retStatus = true;
	jQuery.ajax({
		type: 'POST',
	      	url : admin_url,
	      	data : pdata,
	      	dataType: "json",
			async:false,
	      	success:  function (data) 
		{
			if(data['sel_data_key'] == 'true')
				jQuery('select.child-cat-cls').html(data['option_val']);
			else 
			{
				if(data['sel_data_key'] == 'true_sub_cat')
				{
					jQuery('select.child-cat-cls').html(data['option_val']);
					jQuery('select#child_ofchild__childcategory').html(data['option_val2']);
				}
			}
			if (data['status'] == false)
				retStatus = false;
			
			document.querySelector('#child_of_childcategory').selectedIndex = nSelected;
			if (nASX > 0)
			{
				document.getElementById('search_cat_sub').style.display = 'inline';
				if (nASX > 1)
				{
					document.querySelector('#child_of_childcategory').selectedIndex = 5;
				}		
				nASX= nASX - 1;
			}
			else
				document.querySelector('#child_of_childcategory').selectedIndex = nSelected;


			jQuery('.loader_custom').hide();
			jQuery('#result').append(data['post_val']);
	    },
		error: function(data) 
		{
			retStatus = false;
        },
	}); 
	return retStatus;
};

var maxHeight = -1;
jQuery(document).ready(function() 
{
    jQuery('.w3eden .srch-content').each(function() 
    {
        maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
    });

    jQuery('.w3eden .srch-content').each(function() 
    {
        jQuery(this).height(maxHeight);
    });
	console.log("maxheight:" + maxHeight);

	jQuery('#result').html('');
});

var maxWidth = 0;   // Stores the greatest width
jQuery(document).ready(function() 
{
	jQuery('.w3eden .srch-content').each(function() {    // Select the elements you're comparing

    var theWidth = jQuery(this).width();   // Grab the current width

    if( theWidth > maxWidth) {   // If theWidth > the greatestWidth so far,
        maxWidth = theWidth;     //    set greatestWidth to theWidth
    }
	console.log("maxWidth:" + maxWidth);
});

jQuery('.w3eden .srch-content').width(maxWidth);  
});

jQuery(document).ready( function() {

	var height = jQuery(window).height();
    var width = jQuery(window).width();

	var resHeight = jQuery('#result').height();
	var resWidth =  jQuery('#result').width();
	var pdata = {
        action: "set_window_size",
        width: width,
		height: height,
		resHeight: resHeight,
		resWidth:resWidth,
		recordSize:true,
    }

	var admin_url = "<?php echo admin_url('admin-ajax.php') ?>"; 
    jQuery.ajax({
        url: admin_url,
        type: 'post',
		data : pdata,
	    dataType: "json",
		async:false,
        success: function(response) {
            $("body").html(response);
        }
    });
});

jQuery(document).ready(function() {
  	var maxHeight = -1;
	var minWidth = -1;
   	jQuery('.srch-content .medias').each(function() {
    	maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
	});
	jQuery('.srch-content .medias').each(function() {
		jQuery(this).height(maxHeight);
 	});
 	console.log("maxheight B:" + maxHeight);
 	console.log("maxWidth B:" + maxWidth);
});

jQuery(document).ajaxComplete(function() {
  var maxHeight = -1;

    jQuery('#result .w3eden .srch-content').each(function() 
    {
    	maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 	});

  	jQuery('#result .w3eden .srch-content').each(function() {
    jQuery(this).height(maxHeight);
 	});
 	console.log("maxheight C:" + maxHeight);
});

 jQuery(document).ajaxComplete(function() {
  var maxHeight = -1;

   jQuery('#result .srch-content .medias').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('#result .srch-content .medias').each(function() {
    jQuery(this).height(maxHeight);
 });
 console.log("maxHeight D:" + maxHeight);
});

 jQuery(document).ajaxComplete(function() {
  	var maxHeight = -1;

   	jQuery('#result .srch-content .medias').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

	jQuery('#result .srch-content .medias').each(function() {
    	jQuery(this).height(maxHeight);
	});
	console.log("maxheight E:" + maxHeight);
});
