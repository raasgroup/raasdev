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

/* newsletter/templates/blocks/woocommerceHeading/block.hbs */
class __TwigTemplate_496ba6e7723e1010a266e094d6dfc1538c2bc2c9fb0e6234f2a7909dedd3d188 extends \MailPoetVendor\Twig\Template
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
<div class=\"mailpoet_woocommerce_heading_overlay\">
  <p>";
        // line 3
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Autogenerated content by WooCommerce");
        echo "</p>
</div>
<div class=\"mailpoet_content mailpoet_woocommerce_heading\" data-automation-id=\"woocommerce_heading\">
  <h1>{{ content }}</h1>
</div>
<div class=\"mailpoet_block_highlight\"></div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceHeading/block.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceHeading/block.hbs", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceHeading/block.hbs");
    }
}
