jQuery(document).ready(function () {
  jQuery("body").on("click", "#add-social-icon", function () {
    jQuery("#wpm-6310-modal-add").fadeIn(500);
    jQuery("body").css({
      overflow: "hidden",
    });
    return false;
  });

  jQuery("body").on("click", ".wpm-6310-close, .wpm-btn-danger", function () {
    jQuery("#wpm-6310-modal-add, #wpm-6310-modal-edit-social-icon").fadeOut(
      500
    );
    jQuery("body").css({
      overflow: "initial",
    });
  });
  jQuery(window).click(function (event) {
    if (event.target == document.getElementById("wpm-6310-modal-add")) {
      jQuery("#wpm-6310-modal-add").fadeOut(500);
      jQuery("body").css({
        overflow: "initial",
      });
    } else if (
      event.target == document.getElementById("wpm-6310-modal-edit-social-icon")
    ) {
      jQuery("#wpm-6310-modal-edit-social-icon").fadeOut(500);
      jQuery("body").css({
        overflow: "initial",
      });
    }
  });

  jQuery("body").on("click", ".wpm-6310-social-icon-delete", function () {
    return confirm("Are you sure you want to delete?");
  });

  console.log(
    'jQuery(".wpm-6310-social-edit").length',
    jQuery(".wpm-6310-social-edit").length
  );

  if (jQuery("#wpm-6310-modal-edit-social-icon").length) {
    jQuery("#wpm-6310-modal-edit-social-icon").fadeIn(500);
    jQuery("body").css({
      overflow: "hidden",
    });
  }
});
