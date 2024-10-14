var poppedTile = null;

function Popup(id) {
    jQuery("#footer-outer").css("z-index", "9");

    poppedTile = document.getElementById("popTile" + id);
    imageTile = document.getElementById("imageTile" + id);
    if (poppedTile != null) {
        var rect = imageTile.getBoundingClientRect();
        var pos = rect.right + poppedTile.clientWidth;
        var pos2 = window.innerWidth || document.documentElement.clientWidth;
/*        if (pos2 - pos > 0) {
            //            poppedTile.classList.add('pop--right');
        } else {
            if (rect.left > poppedTile.clientWidth) {
                poppedTile.classList.remove("pop--right");
                poppedTile.classList.add("pop--left");
            } else {
                poppedTile.classList.remove("pop--right");
                poppedTile.classList.add("pop--over");
            }
        }
*/
        poppedTile.style.visibility = "visible";
    }
}
function Popdown() {
    if (poppedTile != null) {
        poppedTile.style.visibility = "hidden";
/*        poppedTile.className = "";
        poppedTile.classList.add("pop");
        poppedTile.classList.add("pop--top");
        poppedTile = null;
*/
    }
}

var bStatus = true;
var bFirst = true;

var isRequestIdleCallbackScheduled = false;
var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

function LoadChild() {
    // Only schedule the rIC if one has not already been set.
    if (isRequestIdleCallbackScheduled) return;

    isRequestIdleCallbackScheduled = true;

    if ("processLoadChild" in window && !isSafari) {
        // Wait at most two seconds before processing events.
        console.log("Schedule Load");
        requestIdleCallback(processLoadChild, { timeout: 2000 });
    } else {
        processLoadChild();
    }
}

function processLoadChild() {
    if (bStatus == false) return;

    var sort_by_val = "";
    var sort_by = jQuery("#sort_by").val();
    var p_cat_val = "true";

    bStatus = get_ajax_record(sort_by, sort_by_val);

    isRequestIdleCallbackScheduled = false;

    return bStatus;
}
jQuery(document).ready(function () { });

function get_ajax_record(sort_by = "", sort_by_val = "") {
    var pdata = {
        action: "get_team_members",
    };
    bFirst = false;
    var admin_url = "<?php echo admin_url('admin-ajax.php') ?>";

    jQuery(".loader_custom").show();

    var retStatus = false;

    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: {
            action: "get_team_members",
            mode: "POST",
            term_Title: "Test Term Alpha",
        },
        dataType: "json",
        async: true,
        success: function (data) {
            retStatus = data["status"];
            jQuery("#result").html(data["post_val"]);
        },
        error: function (xhr, status, error) {
            var errorMessage = xhr.status + ": " + xhr.statusText;
            jQuery("#result").html("Error:" + errorMessage);
            retStatus = false;
        },
    });
    jQuery(".loader_custom").hide();
    return retStatus;
}

jQuery(document).ready(function () {
    LoadChild();
});

var timeOut = null;

var func = function () {
    var height = jQuery(window).height();
    var width = jQuery(window).width();

    var resHeight = jQuery("#result").height();
    var resWidth = jQuery("#result").width();

    console.log(
        "resized h:" +
        height +
        " w:" +
        width +
        " rh:" +
        resHeight +
        " rw:" +
        resWidth
    );
};

window.onresize = function () {
    if (timeOut != null) clearTimeout(timeOut);
    timeOut = setTimeout(func, 100);
};
