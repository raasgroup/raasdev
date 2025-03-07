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

/* help.html */
class __TwigTemplate_6b137174f34221a57b1673a30fa730ee991bbf35310161d8107b123cf139f6fe extends \MailPoetVendor\Twig\Template
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
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html", "help.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "
<div id=\"mailpoet_help\">

  <script type=\"text/javascript\">
    var systemInfoData = ";
        // line 8
        echo json_encode(($context["systemInfoData"] ?? null));
        echo ";
    var systemStatusData = ";
        // line 9
        echo json_encode(($context["systemStatusData"] ?? null));
        echo ";
  </script>

  <div id=\"help_container\"></div>

</div>

";
    }

    // line 17
    public function block_translations($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 18
        echo $this->extensions['MailPoet\Twig\I18n']->localize(["tabKnowledgeBaseTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Knowledge Base"), "tabSystemInfoTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("System Info"), "tabSystemStatusTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("System Status"), "tabYourPrivacyTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Your Privacy"), "systemStatusIntroCron" => $this->extensions['MailPoet\Twig\I18n']->translate("For the plugin to work, it must be able to establish connection with the task scheduler."), "systemStatusIntroCronMSS" => $this->extensions['MailPoet\Twig\I18n']->translate("For the plugin to work, it must be able to establish connection with the task scheduler and the key activation/MailPoet sending service."), "systemStatusCronTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Task Scheduler"), "systemStatusMSSTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Key Activation and MailPoet Sending Service"), "systemStatusConnectionSuccessful" => $this->extensions['MailPoet\Twig\I18n']->translate("Connection successful."), "systemStatusConnectionUnsuccessful" => $this->extensions['MailPoet\Twig\I18n']->translate("Connection unsuccessful."), "systemStatusCronConnectionUnsuccessfulInfo" => $this->extensions['MailPoet\Twig\I18n']->translate("Please consult our [link]knowledge base article[/link] for troubleshooting tips."), "systemStatusMSSConnectionUnsuccessfulInfo" => $this->extensions['MailPoet\Twig\I18n']->translate("Please contact our technical support for assistance."), "knowledgeBaseIntro" => $this->extensions['MailPoet\Twig\I18n']->translate("Click on one of these categories below to find more information:"), "knowledgeBaseButton" => $this->extensions['MailPoet\Twig\I18n']->translate("Visit our Knowledge Base for more articles"), "systemInfoIntro" => $this->extensions['MailPoet\Twig\I18n']->translate("The information below is useful when you need to get in touch with our support. Just copy all the text below and paste it into a message to us."), "systemInfoDataError" => $this->extensions['MailPoet\Twig\I18n']->translate("Sorry, there was an error, please try again later."), "systemStatusCronStatusTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Cron"), "systemStatusQueueTitle" => $this->extensions['MailPoet\Twig\I18n']->translate("Sending Queue"), "yourPrivacyContent1" => $this->extensions['MailPoet\Twig\I18n']->translate("MailPoet respects your privacy. We don’t track any information about your website or yourself without your explicit consent."), "yourPrivacyContent2" => $this->extensions['MailPoet\Twig\I18n']->translate("Third-party services used within the plugin may track information such as your email & IP address."), "yourPrivacyContent3" => $this->extensions['MailPoet\Twig\I18n']->translate("If you send with MailPoet, we track data that is used to ensure that the service works correctly."), "yourPrivacyButton" => $this->extensions['MailPoet\Twig\I18n']->translate("Read our Privacy Notice"), "lastUpdated" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Last updated", "A label in a status table e.g. Last updated: 2018-10-18 18:50"), "lastRunStarted" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Last run started", "A label in a status table e.g. Last run started: 2018-10-18 18:50"), "lastRunCompleted" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Last run completed", "A label in a status table e.g. Last run completed: 2018-10-18 18:50"), "lastSeenError" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Last seen error", "A label in a status table e.g. Last seen error: Process timeout"), "lastSeenErrorDate" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Last seen error date", "A label in a status table e.g. Last seen error date: 2018-10-18 18:50"), "unknown" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("unknown", "An unknown state is a status table e.g. Last run started: unknown"), "accessible" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Accessible", "A label in a status table e.g. Accessible: yes"), "status" => $this->extensions['MailPoet\Twig\I18n']->translate("Status"), "yes" => $this->extensions['MailPoet\Twig\I18n']->translate("yes"), "no" => $this->extensions['MailPoet\Twig\I18n']->translate("no"), "none" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("none", "An empty state is a status table e.g. Error: none"), "running" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("running", "A state of a process."), "paused" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("paused", "A state of a process."), "cronWaiting" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("waiting for the next run", "A state of a process."), "startedAt" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Started at", "A label in a status table e.g. Started at: 2018-10-18 18:50"), "sentEmails" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Sent emails", "A label in a status table e.g. Sent emails: 50"), "retryAttempt" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Retry attempt", "A label in a status table e.g. Retry attempt: 2"), "retryAt" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Retry at", "A label in a status table e.g. Retry at: 2018-10-18 18:50"), "error" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Error", "A label in a status table e.g. Error: missing data"), "totalCompletedTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Total completed tasks"), "totalScheduledTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Total scheduled tasks"), "totalRunningTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Total running tasks"), "totalPausedTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Total paused tasks"), "scheduledTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Scheduled tasks"), "runningTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Running tasks"), "completedTasks" => $this->extensions['MailPoet\Twig\I18n']->translate("Completed tasks"), "type" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Type", "Table column heading for task type."), "email" => $this->extensions['MailPoet\Twig\I18n']->translate("Email"), "priority" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Priority", "Table column heading for task priority (number)."), "scheduledAt" => $this->extensions['MailPoet\Twig\I18n']->translate("Scheduled At"), "updatedAt" => $this->extensions['MailPoet\Twig\I18n']->translate("Updated At"), "nothingToShow" => $this->extensions['MailPoet\Twig\I18n']->translate("Nothing to show."), "preview" => $this->extensions['MailPoet\Twig\I18n']->translateWithContext("Preview", "Text of a link to email preview page.")]);
        // line 74
        echo "
";
    }

    public function getTemplateName()
    {
        return "help.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 74,  77 => 18,  73 => 17,  61 => 9,  57 => 8,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "help.html", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/help.html");
    }
}
