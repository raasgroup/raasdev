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

/* subscribers/importExport/import.html */
class __TwigTemplate_15927484fdb60a7dbd762919b25bed0eae22abe5d35893768b5530b5541dfbbc extends \MailPoetVendor\Twig\Template
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
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 2
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $context["csvDescription"] = $this->extensions['MailPoet\Twig\I18n']->translate("This file needs to be formatted in a CSV style (comma-separated-values). Look at some [link]examples on our support site[/link].");
        // line 2
        $this->parent = $this->loadTemplate("layout.html", "subscribers/importExport/import.html", 2);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "<div id=\"mailpoet_subscribers_import\" class=\"wrap\">
  <h1 class=\"mailpoet-h1 mailpoet-title\">
    <span>";
        // line 6
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Import");
        echo "</span>
    <a class=\"mailpoet-button button button-secondary button-small\" href=\"?page=mailpoet-subscribers#/\">";
        // line 7
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Back to Subscribers");
        echo "</a>
  </h1>
  <!-- STEP subscriber data manipulation -->
  ";
        // line 10
        $this->loadTemplate("subscribers/importExport/import/step_data_manipulation.html", "subscribers/importExport/import.html", 10)->display($context);
        // line 11
        echo "  <div id=\"import_container\" class=\"mailpoet-tab-content\"></div>
</div>

<script type=\"text/javascript\">
  var
    maxPostSize = '";
        // line 16
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["maxPostSize"] ?? null), "html", null, true);
        echo "',
    roleBasedEmails = ";
        // line 17
        echo ($context["role_based_emails"] ?? null);
        echo ",
    maxPostSizeBytes = '";
        // line 18
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["maxPostSizeBytes"] ?? null), "html", null, true);
        echo "',
    importData = {},
    mailpoetColumnsSelect2 = ";
        // line 20
        echo ($context["subscriberFieldsSelect2"] ?? null);
        echo ",
    mailpoetColumns = ";
        // line 21
        echo ($context["subscriberFields"] ?? null);
        echo ",
    mailpoetSegments = ";
        // line 22
        echo ($context["segments"] ?? null);
        echo ";
    ";
        // line 23
        $context["newUser"] = (((($context["is_new_user"] ?? null) == true)) ? ("true") : ("false"));
        // line 24
        echo "    var mailpoet_is_new_user = ";
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["newUser"] ?? null), "html", null, true);
        echo ";
    var mailpoet_beacon_articles = [
      '57ce07ffc6979108399a044b',
      '57ce079f903360649f6e56fc',
      '5b16db842c7d3a0fa9a2aa15',
      '5d96ecd204286364bc8ff8f5',
      '58a5a7502c7d3a576d353c78',
      '5d0a1da404286318cac46fe5'
    ];
</script>
";
    }

    // line 37
    public function block_translations($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 38
        echo $this->extensions['MailPoet\Twig\I18n']->localize(["noMailChimpLists" => $this->extensions['MailPoet\Twig\I18n']->translate("No active lists found"), "serverError" => $this->extensions['MailPoet\Twig\I18n']->translate("Server error:"), "select" => $this->extensions['MailPoet\Twig\I18n']->translate("Select", "Form input type"), "wrongFileFormat" => $this->extensions['MailPoet\Twig\I18n']->translate("Only comma-separated (CSV) file formats are supported."), "maxPostSizeNotice" => \MailPoetVendor\twig_replace_filter($this->extensions['MailPoet\Twig\I18n']->translate("Your CSV is over %s and is too big to process. Please split the file into two or more sections."), ["%s" =>         // line 43
($context["maxPostSize"] ?? null)]), "dataProcessingError" => $this->extensions['MailPoet\Twig\I18n']->translate("Your data could not be processed. Please make sure it is in the correct format."), "noValidRecords" => $this->extensions['MailPoet\Twig\I18n']->translate("No valid records were found. This file needs to be formatted in a CSV style (comma-separated). Look at some [link]examples on our support site.[/link]"), "importNoticeSkipped" => $this->extensions['MailPoet\Twig\I18n']->translate("%1\$s records had issues and were skipped."), "importNoticeInvalid" => $this->extensions['MailPoet\Twig\I18n']->translate("%1\$s emails are not valid: %2\$s"), "importNoticeRoleBased" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("%1\$s [link]role-based addresses[/link] are not permitted: %2\$s", "Error message when importing addresses like postmaster@domain.com"), "importNoticeDuplicate" => $this->extensions['MailPoet\Twig\I18n']->translate("%1\$s emails appear more than once in your file: %2\$s"), "hideDetails" => $this->extensions['MailPoet\Twig\I18n']->translate("Hide details"), "showDetails" => $this->extensions['MailPoet\Twig\I18n']->translate("Show more details"), "segmentSelectionRequired" => $this->extensions['MailPoet\Twig\I18n']->translate("Please select at least one list"), "addNewList" => $this->extensions['MailPoet\Twig\I18n']->translate("Add new list"), "addNewField" => $this->extensions['MailPoet\Twig\I18n']->translate("Add new field"), "addNewColumuserColumnsn" => $this->extensions['MailPoet\Twig\I18n']->translate("Add new list"), "userColumns" => $this->extensions['MailPoet\Twig\I18n']->translate("User fields"), "selectedValueAlreadyMatched" => $this->extensions['MailPoet\Twig\I18n']->translate("The selected value is already matched to another field."), "confirmCorrespondingColumn" => $this->extensions['MailPoet\Twig\I18n']->translate("Confirm that this field corresponds to the selected field."), "columnContainInvalidElement" => $this->extensions['MailPoet\Twig\I18n']->translate("One of the fields contains an invalid email. Please fix it before continuing."), "january" => $this->extensions['MailPoet\Twig\I18n']->translate("January"), "february" => $this->extensions['MailPoet\Twig\I18n']->translate("February"), "march" => $this->extensions['MailPoet\Twig\I18n']->translate("March"), "april" => $this->extensions['MailPoet\Twig\I18n']->translate("April"), "may" => $this->extensions['MailPoet\Twig\I18n']->translate("May"), "june" => $this->extensions['MailPoet\Twig\I18n']->translate("June"), "july" => $this->extensions['MailPoet\Twig\I18n']->translate("July"), "august" => $this->extensions['MailPoet\Twig\I18n']->translate("August"), "september" => $this->extensions['MailPoet\Twig\I18n']->translate("September"), "october" => $this->extensions['MailPoet\Twig\I18n']->translate("October"), "november" => $this->extensions['MailPoet\Twig\I18n']->translate("November"), "december" => $this->extensions['MailPoet\Twig\I18n']->translate("December"), "noDateFieldMatch" => $this->extensions['MailPoet\Twig\I18n']->translate("Do not match as a 'date field' if most of the rows for that field return the same error."), "emptyFirstRowDate" => $this->extensions['MailPoet\Twig\I18n']->translate("First row date cannot be empty."), "verifyDateMatch" => $this->extensions['MailPoet\Twig\I18n']->translate("Verify that the date in blue matches the original date."), "pm" => $this->extensions['MailPoet\Twig\I18n']->translate("PM"), "am" => $this->extensions['MailPoet\Twig\I18n']->translate("AM"), "dateMatchError" => $this->extensions['MailPoet\Twig\I18n']->translate("Error matching date"), "columnContainsInvalidDate" => $this->extensions['MailPoet\Twig\I18n']->translate("One of the fields contains an invalid date. Please fix before continuing."), "listCreateError" => $this->extensions['MailPoet\Twig\I18n']->translate("Error adding a new list:"), "columnContainsInvalidElement" => $this->extensions['MailPoet\Twig\I18n']->translate("One of the fields contains an invalid email. Please fix before continuing."), "customFieldCreateError" => $this->extensions['MailPoet\Twig\I18n']->translate("Custom field could not be created"), "subscribersCreated" => $this->extensions['MailPoet\Twig\I18n']->translate("%1\$s subscribers added to %2\$s."), "subscribersUpdated" => $this->extensions['MailPoet\Twig\I18n']->translate("%1\$s existing subscribers were updated and added to %2\$s."), "importNoAction" => $this->extensions['MailPoet\Twig\I18n']->translate("No subscribers were added or updated."), "importNoWelcomeEmail" => $this->extensions['MailPoet\Twig\I18n']->translate("Note: Imported subscribers will not receive any Welcome Emails"), "readSupportArticle" => $this->extensions['MailPoet\Twig\I18n']->translate("Read the support article."), "validationStepHeading" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Are you importing an existing list or contacts from your address book?", "Question for importing subscribers into MailPoet"), "validationStepRadio1" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Existing list", "User choice to import an existing email list"), "validationStepRadio2" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Contacts from my address book", "User choice to import his address book contacts"), "validationStepBlock1" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("You will need to ask your contacts to join your list instead of importing them. This is a standard practice to ensure good email deliverability.", "Paragraph explaining the user what to do when importing his contacts."), "validationStepBlock2" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("If you send with MailPoet, we will detect if you import subscribers without their explicit consent and suspend your account.", "Paragraph warning what happens if user imports his contacts and sends with MailPoet"), "validationStepBlockButton" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("How to ask your contacts to join your list", "Button to visit a support article"), "validationStepLastSentHeading" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("When did you last send an email to this list?", "Question for users importing their list"), "validationStepLastSentOption1" => $this->extensions['MailPoet\Twig\I18n']->translate("Over 2 years ago"), "validationStepLastSentOption2" => $this->extensions['MailPoet\Twig\I18n']->translate("Between 1 and 2 years ago"), "validationStepLastSentOption3" => $this->extensions['MailPoet\Twig\I18n']->translate("Within the last year"), "validationStepLastSentOption4" => $this->extensions['MailPoet\Twig\I18n']->translate("Within the last 3 months"), "validationStepLastSentNext" => $this->extensions['MailPoet\Twig\I18n']->translate("Next"), "previousStep" => $this->extensions['MailPoet\Twig\I18n']->translate("Previous step"), "nextStep" => $this->extensions['MailPoet\Twig\I18n']->translate("Next step"), "import" => $this->extensions['MailPoet\Twig\I18n']->translate("Import"), "seeVideo" => $this->extensions['MailPoet\Twig\I18n']->translate(" See video guide"), "importAgain" => $this->extensions['MailPoet\Twig\I18n']->translate("Import again"), "viewSubscribers" => $this->extensions['MailPoet\Twig\I18n']->translate("View subscribers"), "methodPaste" => $this->extensions['MailPoet\Twig\I18n']->translate("Paste the data into a text box"), "pickLists" => $this->extensions['MailPoet\Twig\I18n']->translate("Pick one or more list(s)"), "pickListsDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Pick the list that you want to import these subscribers to."), "select" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Select", " Verb"), "createANewList" => $this->extensions['MailPoet\Twig\I18n']->translate("Create a new list"), "updateExistingSubscribers" => $this->extensions['MailPoet\Twig\I18n']->translate("Update existing subscribers’ information, like first name, last name, etc."), "updateExistingSubscribersYes" => $this->extensions['MailPoet\Twig\I18n']->translate("Yes"), "updateExistingSubscribersNo" => $this->extensions['MailPoet\Twig\I18n']->translate("No"), "addSubscribersToSegment" => $this->extensions['MailPoet\Twig\I18n']->translate(" To add subscribers to a mailing segment, [link]create a list[/link]."), "methodUpload" => $this->extensions['MailPoet\Twig\I18n']->translate("Upload a file"), "methodMailChimp" => $this->extensions['MailPoet\Twig\I18n']->translate("Import from MailChimp"), "methodMailChimpLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("Enter your MailChimp API key"), "methodMailChimpDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("Find your MailChimp API key in our [link]documentation[/link]."), "methodMailChimpVerify" => $this->extensions['MailPoet\Twig\I18n']->translate("Verify"), "methodMailChimpSelectList" => $this->extensions['MailPoet\Twig\I18n']->translate("Select list(s)"), "methodMailChimpSelectPlaceholder" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Select", "Verb"), "matchData" => $this->extensions['MailPoet\Twig\I18n']->translate("Match data"), "showMoreDetails" => $this->extensions['MailPoet\Twig\I18n']->translate("Show more details"), "pasteLabel" => $this->extensions['MailPoet\Twig\I18n']->translate("Copy and paste your subscribers from Excel/Spreadsheets"), "pasteDescription" => $this->extensions['MailPoet\Twig\I18n']->translate("This file needs to be formatted in a CSV style (comma-separated-values.) Look at some [link]examples on our support site[/link]."), "methodSelectionHead" => $this->extensions['MailPoet\Twig\I18n']->translate("How would you like to import subscribers?"), "cleanListText1" => $this->extensions['MailPoet\Twig\I18n']->translate("We highly recommend cleaning your lists before importing them to MailPoet."), "cleanListText2" => $this->extensions['MailPoet\Twig\I18n']->translate("Lists can have up to 20% of invalid addresses after a year because people change jobs and stop using their addresses. If you send with MailPoet, we will pause your sending and ask you to clean your list if we detect over 10% of invalid addresses."), "tryListCleaning" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("How can I clean my list?", "CTA button label"), "listCleaningGotIt" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Got it, I’ll proceed to import", "Text in a link"), "subscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Subscribed"), "unsubscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Unsubscribed"), "inactive" => $this->extensions['MailPoet\Twig\I18n']->translate("Inactive"), "dontUpdate" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Don’t update", "This is a value in a select box for \"Set new subscribers’ status to\""), "newSubscribersStatus" => $this->extensions['MailPoet\Twig\I18n']->translate("Set new subscribers’ status to"), "consentSubscribed" => $this->extensions['MailPoet\Twig\I18n']->translate("Choose “Subscribed” only if you have explicit consent to send them bulk or marketing emails. [link]Why is consent important?[/link]"), "congratulationResult" => $this->extensions['MailPoet\Twig\I18n']->translate("Congratulations, you’ve imported your subscribers!"), "suppressionListReminder" => $this->extensions['MailPoet\Twig\I18n']->translate("Are you importing subscribers from another marketing service provider? You may need to separately import the list of bad or previously unsubscribed addresses to avoid contacting them. [link]See how to import a suppression list.[/link]"), "existingSubscribersStatus" => $this->extensions['MailPoet\Twig\I18n']->translate("Update existing subscribers’ status to")]);
        // line 139
        echo "
";
    }

    public function getTemplateName()
    {
        return "subscribers/importExport/import.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 139,  125 => 43,  124 => 38,  120 => 37,  104 => 24,  102 => 23,  98 => 22,  94 => 21,  90 => 20,  85 => 18,  81 => 17,  77 => 16,  70 => 11,  68 => 10,  62 => 7,  58 => 6,  54 => 4,  50 => 3,  45 => 2,  43 => 1,  36 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "subscribers/importExport/import.html", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/subscribers/importExport/import.html");
    }
}
