<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Extension\SandboxExtension;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* subscribers/subscribers.html */
class __TwigTemplate_7bdeb36754963aa0837671753184e1950147cc274e1f36e05dc7af620870beb1 extends \MailPoetVendor\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
            'after_translations' => [$this, 'block_after_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html", "subscribers/subscribers.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "  <div id=\"subscribers_container\"></div>

  <script type=\"text/javascript\">
    var mailpoet_listing_per_page = ";
        // line 7
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["items_per_page"] ?? null), "html", null, true);
        echo ";
    var mailpoet_segments = ";
        // line 8
        echo json_encode(($context["segments"] ?? null));
        echo ";
    var mailpoet_custom_fields = ";
        // line 9
        echo json_encode(($context["custom_fields"] ?? null));
        echo ";
    var mailpoet_month_names = ";
        // line 10
        echo json_encode(($context["month_names"] ?? null));
        echo ";
    var mailpoet_date_formats = ";
        // line 11
        echo json_encode(($context["date_formats"] ?? null));
        echo ";
    var mailpoet_premium_active = ";
        // line 12
        echo json_encode(($context["premium_plugin_active"] ?? null));
        echo ";
    var mailpoet_max_confirmation_emails = ";
        // line 13
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["max_confirmation_emails"] ?? null), "html", null, true);
        echo ";
    var mailpoet_tracking_enabled = ";
        // line 14
        echo json_encode(($context["tracking_enabled"] ?? null));
        echo ";
    var mailpoet_beacon_articles = [
      '57ce07ffc6979108399a044b',
      '57ce079f903360649f6e56fc',
      '5d0a1da404286318cac46fe5',
      '5cbf19622c7d3a026fd3efe1',
      '58a5a7502c7d3a576d353c78',
    ];
    var mailpoet_mss_active = ";
        // line 22
        echo json_encode(($context["mss_active"] ?? null));
        echo ";
    var mailpoet_subscribers_limit = ";
        // line 23
        ((($context["subscribers_limit"] ?? null)) ? (print (\MailPoetVendor\twig_escape_filter($this->env, ($context["subscribers_limit"] ?? null), "html", null, true))) : (print ("false")));
        echo ";
    var mailpoet_subscribers_limit_reached = ";
        // line 24
        echo ((($context["subscribers_limit_reached"] ?? null)) ? ("true") : ("false"));
        echo ";
    var mailpoet_has_valid_api_key = ";
        // line 25
        echo ((($context["has_valid_api_key"] ?? null)) ? ("true") : ("false"));
        echo ";
    var mailpoet_mss_key_invalid = ";
        // line 26
        echo ((($context["mss_key_invalid"] ?? null)) ? ("true") : ("false"));
        echo ";
    var mailpoet_subscribers_count = ";
        // line 27
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["subscriber_count"] ?? null), "html", null, true);
        echo ";
    var mailpoet_has_premium_support = ";
        // line 28
        echo ((($context["has_premium_support"] ?? null)) ? ("true") : ("false"));
        echo ";
    var mailpoet_premium_link = ";
        // line 29
        echo json_encode(($context["link_premium"] ?? null));
        echo ";
  </script>
";
    }

    // line 33
    public function block_translations($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 34
        echo "  ";
        echo $this->extensions['MailPoet\Twig\I18n']->localize(["pageTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscribers"), "searchLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("Search"), "loadingItems" => $this->extensions['MailPoet\Twig\I18n']->translate("Loading subscribers..."), "noItemsFound" => $this->extensions['MailPoet\Twig\I18n']->translate("No subscribers were found."), "bouncedSubscribersHelp" => $this->extensions['MailPoet\Twig\I18n']->translate("Email addresses that are invalid or don't exist anymore are called \"bounced addresses\". It's a good practice not to send emails to bounced addresses to keep a good reputation with spam filters. Send your emails with MailPoet and we'll automatically ensure to keep a list of bounced addresses without any setup."), "bouncedSubscribersPremiumButtonText" => $this->extensions['MailPoet\Twig\I18n']->translate("Get premium version!"), "selectAllLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("All subscribers on this page are selected."), "selectedAllLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("All %d subscribers are selected."), "selectAllLink" => $this->extensions['MailPoet\Twig\I18n']->translate("Select all subscribers on all pages"), "clearSelection" => $this->extensions['MailPoet\Twig\I18n']->translate("Clear selection"), "permanentlyDeleted" => $this->extensions['MailPoet\Twig\I18n']->translate("%d subscribers were permanently deleted."), "selectBulkAction" => $this->extensions['MailPoet\Twig\I18n']->translate("Select bulk action"), "bulkActions" => $this->extensions['MailPoet\Twig\I18n']->translate("Bulk Actions"), "apply" => $this->extensions['MailPoet\Twig\I18n']->translate("Apply"), "filter" => $this->extensions['MailPoet\Twig\I18n']->translate("Filter"), "emptyTrash" => $this->extensions['MailPoet\Twig\I18n']->translate("Empty Trash"), "selectAll" => $this->extensions['MailPoet\Twig\I18n']->translate("Select All"), "edit" => $this->extensions['MailPoet\Twig\I18n']->translate("Edit"), "restore" => $this->extensions['MailPoet\Twig\I18n']->translate("Restore"), "trash" => $this->extensions['MailPoet\Twig\I18n']->translate("Trash"), "moveToTrash" => $this->extensions['MailPoet\Twig\I18n']->translate("Move to trash"), "deletePermanently" => $this->extensions['MailPoet\Twig\I18n']->translate("Delete Permanently"), "showMoreDetails" => $this->extensions['MailPoet\Twig\I18n']->translate("Show more details"), "previousPage" => $this->extensions['MailPoet\Twig\I18n']->translate("Previous page"), "firstPage" => $this->extensions['MailPoet\Twig\I18n']->translate("First page"), "nextPage" => $this->extensions['MailPoet\Twig\I18n']->translate("Next page"), "lastPage" => $this->extensions['MailPoet\Twig\I18n']->translate("Last page"), "currentPage" => $this->extensions['MailPoet\Twig\I18n']->translate("Current Page"), "pageOutOf" => $this->extensions['MailPoet\Twig\I18n']->translate("of"), "numberOfItemsSingular" => $this->extensions['MailPoet\Twig\I18n']->translate("1 item"), "numberOfItemsMultiple" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d items"), "subscribersInPlanCount" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("%\$1d / %\$2d", "count / total subscribers"), "subscribersInPlan" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("%s subscribers in your plan", "number of subscribers in a sending plan"), "subscribersInPlanTooltip" => $this->extensions['MailPoet\Twig\I18n']->translate("This is the total of subscribed, unconfirmed and inactive subscribers we count when you are sending with MailPoet Sending Service. The count excludes unsubscribed and bounced (invalid) email addresses."), "email" => $this->extensions['MailPoet\Twig\I18n']->translate("E-mail"), "firstname" => $this->extensions['MailPoet\Twig\I18n']->translate("First name"), "lastname" => $this->extensions['MailPoet\Twig\I18n']->translate("Last name"), "status" => $this->extensions['MailPoet\Twig\I18n']->translate("Status"), "unconfirmed" => $this->extensions['MailPoet\Twig\I18n']->translate("Unconfirmed"), "subscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscribed"), "unsubscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed"), "inactive" => $this->extensions['MailPoet\Twig\I18n']->translate("Inactive"), "bounced" => $this->extensions['MailPoet\Twig\I18n']->translate("Bounced"), "selectList" => $this->extensions['MailPoet\Twig\I18n']->translate("Select a list"), "unsubscribedOn" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed on %\$1s"), "subscriberUpdated" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscriber was updated successfully!"), "subscriberAdded" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscriber was added successfully!"), "welcomeEmailTip" => $this->extensions['MailPoet\Twig\I18n']->translate("This subscriber will receive Welcome Emails if any are active for your lists."), "unsubscribedNewsletter" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed at %\$1d, from newsletter [link]."), "unsubscribedManage" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed at %\$1d, using the “Manage my Subscription” page."), "unsubscribedAdmin" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed at %\$1d, by admin \"%\$2d\"."), "unsubscribedUnknown" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed at %\$1d, for an unknown reason."), "subscriber" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscriber"), "status" => $this->extensions['MailPoet\Twig\I18n']->translate("Status"), "lists" => $this->extensions['MailPoet\Twig\I18n']->translate("Lists"), "statisticsColumn" => $this->extensions['MailPoet\Twig\I18n']->translate("Score"), "subscribedOn" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscribed on"), "lastModifiedOn" => $this->extensions['MailPoet\Twig\I18n']->translate("Last modified on"), "oneSubscriberTrashed" => $this->extensions['MailPoet\Twig\I18n']->translate("1 subscriber was moved to the trash."), "multipleSubscribersTrashed" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were moved to the trash."), "oneSubscriberDeleted" => $this->extensions['MailPoet\Twig\I18n']->translate("1 subscriber was permanently deleted."), "multipleSubscribersDeleted" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were permanently deleted."), "oneSubscriberRestored" => $this->extensions['MailPoet\Twig\I18n']->translate("1 subscriber has been restored from the trash."), "multipleSubscribersRestored" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers have been restored from the trash."), "moveToList" => $this->extensions['MailPoet\Twig\I18n']->translate("Move to list..."), "multipleSubscribersMovedToList" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were moved to list <strong>%\$2s</strong>"), "addToList" => $this->extensions['MailPoet\Twig\I18n']->translate("Add to list..."), "multipleSubscribersAddedToList" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were added to list <strong>%\$2s</strong>."), "removeFromList" => $this->extensions['MailPoet\Twig\I18n']->translate("Remove from list..."), "multipleSubscribersRemovedFromList" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were removed from list <strong>%\$2s</strong>"), "removeFromAllLists" => $this->extensions['MailPoet\Twig\I18n']->translate("Remove from all lists"), "unsubscribe" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Unsubscribe", "This is an action on the subscribers page"), "unsubscribeConfirm" => $this->extensions['MailPoet\Twig\I18n']->translate("This action will unsubscribe %s subscribers from all lists. This action cannot be undone. Are you sure, you want to continue?"), "multipleSubscribersRemovedFromAllLists" => $this->extensions['MailPoet\Twig\I18n']->translate("%\$1d subscribers were removed from all lists."), "resendConfirmationEmail" => $this->extensions['MailPoet\Twig\I18n']->translate("Resend confirmation email"), "oneConfirmationEmailSent" => $this->extensions['MailPoet\Twig\I18n']->translate("1 confirmation email has been sent."), "listsToWhichSubscriberWasSubscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Lists to which the subscriber was subscribed."), "WPUsersSegment" => $this->extensions['MailPoet\Twig\I18n']->translate("WordPress Users"), "WPUserEditNotice" => $this->extensions['MailPoet\Twig\I18n']->translate("This subscriber is a registered WordPress user. [link]Edit his/her profile[/link] to change his/her email."), "allSendingPausedHeader" => $this->extensions['MailPoet\Twig\I18n']->translate("All sending is currently paused!"), "allSendingPausedBody" => $this->extensions['MailPoet\Twig\I18n']->translate("Your key to send with MailPoet is invalid."), "allSendingPausedLink" => $this->extensions['MailPoet\Twig\I18n']->translate("Purchase a key"), "statsListingActionTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Statistics"), "statsHeading" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Stats: %s", "This is a heading for the subscribers statistics page example: \"Stats: mailpoet@example.com\""), "statsSentEmail" => $this->extensions['MailPoet\Twig\I18n']->translate("Sent email"), "statsOpened" => $this->extensions['MailPoet\Twig\I18n']->translate("Opened"), "statsClicked" => $this->extensions['MailPoet\Twig\I18n']->translate("Clicked"), "statsNotClicked" => $this->extensions['MailPoet\Twig\I18n']->translate("Not opened"), "openedEmailsHeading" => $this->extensions['MailPoet\Twig\I18n']->translate("Opened emails"), "tip" => $this->extensions['MailPoet\Twig\I18n']->translate("Tip:"), "customFieldsTip" => $this->extensions['MailPoet\Twig\I18n']->translate("Need to add new fields, like a telephone number or street address? You can add custom fields by editing the subscription form on the Forms page."), "year" => $this->extensions['MailPoet\Twig\I18n']->translate("Year"), "month" => $this->extensions['MailPoet\Twig\I18n']->translate("Month"), "day" => $this->extensions['MailPoet\Twig\I18n']->translate("Day"), "new" => $this->extensions['MailPoet\Twig\I18n']->translate("Add New"), "import" => $this->extensions['MailPoet\Twig\I18n']->translate("Import"), "export" => $this->extensions['MailPoet\Twig\I18n']->translate("Export"), "save" => $this->extensions['MailPoet\Twig\I18n']->translate("Save"), "backToList" => $this->extensions['MailPoet\Twig\I18n']->translate("Back"), "premiumFeature" => $this->extensions['MailPoet\Twig\I18n']->translate("This is a Premium feature"), "upgradeRequired" => $this->extensions['MailPoet\Twig\I18n']->translate("Upgrade required"), "premiumRequired" => $this->extensions['MailPoet\Twig\I18n']->translate("Learn more about how each of your subscribers is engaging with your emails. See which emails they’ve opened, the links they clicked. If you’re a WooCommerce store owner, you’ll also see any purchases made as a result of your emails. [link]Learn more[/link]."), "freeLimitReached" => $this->extensions['MailPoet\Twig\I18n']->translate("Congratulations, you now have [subscribersCount] subscribers! Our free version is limited to [subscribersLimit] subscribers. You need to upgrade now to be able to continue using MailPoet."), "planLimitReached" => $this->extensions['MailPoet\Twig\I18n']->translate("Congratulations, you now have [subscribersCount] subscribers! Your plan is limited to [subscribersLimit] subscribers. You need to upgrade now to be able to continue using MailPoet."), "premiumBannerCtaFree" => $this->extensions['MailPoet\Twig\I18n']->translate("Sign Up for Free"), "premiumBannerCtaUpgrade" => $this->extensions['MailPoet\Twig\I18n']->translate("Upgrade Now"), "columnAction" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Action", "Table column label for subscriber actions e.g. email open, link clicked"), "columnActionOn" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Action on", "Table column label for date when subscriber action happened"), "columnCount" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Count", "Table column label for count of subscriber actions"), "unknownBadgeName" => $this->extensions['MailPoet\Twig\I18n']->translate("Unknown"), "unknownBadgeTooltip" => $this->extensions['MailPoet\Twig\I18n']->translate("Not enough data."), "tooltipUnknown" => $this->extensions['MailPoet\Twig\I18n']->translate("Fewer than 3 emails sent"), "excellentBadgeName" => $this->extensions['MailPoet\Twig\I18n']->translate("Excellent"), "excellentBadgeTooltip" => $this->extensions['MailPoet\Twig\I18n']->translate("Congrats!"), "tooltipExcellent" => $this->extensions['MailPoet\Twig\I18n']->translate("Read 50% or more of sent emails"), "goodBadgeName" => $this->extensions['MailPoet\Twig\I18n']->translate("Good"), "goodBadgeTooltip" => $this->extensions['MailPoet\Twig\I18n']->translate("Good stuff."), "tooltipGood" => $this->extensions['MailPoet\Twig\I18n']->translate("Read between 20 and 50% of sent emails"), "averageBadgeName" => $this->extensions['MailPoet\Twig\I18n']->translate("Low"), "averageBadgeTooltip" => $this->extensions['MailPoet\Twig\I18n']->translate("Something to improve."), "tooltipAverage" => $this->extensions['MailPoet\Twig\I18n']->translate("Read 20% or fewer of sent emails"), "engagementScoreDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Average percent of emails subscribers read in the last year")]);
        // line 162
        echo "
";
    }

    // line 165
    public function block_after_translations($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 166
        echo do_action("mailpoet_subscribers_translations_after");
        echo "
";
    }

    public function getTemplateName()
    {
        return "subscribers/subscribers.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 166,  143 => 165,  138 => 162,  135 => 34,  131 => 33,  124 => 29,  120 => 28,  116 => 27,  112 => 26,  108 => 25,  104 => 24,  100 => 23,  96 => 22,  85 => 14,  81 => 13,  77 => 12,  73 => 11,  69 => 10,  65 => 9,  61 => 8,  57 => 7,  52 => 4,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "subscribers/subscribers.html", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/subscribers/subscribers.html");
    }
}
