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

/* newsletter/templates/blocks/unknownBlockFallback/block.hbs */
class __TwigTemplate_a8f24c23bc45f01c39d1f7d767c0887c5694b03fdf4f78117c7f22bcbb3ee57f extends \MailPoetVendor\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"mailpoet_tools\"></div>
<div class=\"mailpoet_content mailpoet_unknown_block_fallback\">
  <h2 class=\"mailpoet_unknown_block_fallback_heading\">";
        // line 3
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Unsupported block type");
        echo "</h2>
  <p>";
        // line 4
        echo \MailPoetVendor\twig_escape_filter($this->env, sprintf($this->extensions['MailPoet\Twig\I18n']->translate("\"%s\" block type is not supported and will not be included in the email. You can either delete this block, or enable a plugin that adds support for this block."), "{{blockType}}"), "html", null, true);
        echo "</p>
</div>
<div class=\"mailpoet_block_highlight\"></div>
";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/unknownBlockFallback/block.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/unknownBlockFallback/block.hbs", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/unknownBlockFallback/block.hbs");
    }
}
