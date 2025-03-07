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

/* form/form_preview.html */
class __TwigTemplate_95861718e8040598dc275836d9f53df5248065bc322ac5dd7d76bcd6191b344f extends \MailPoetVendor\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->displayBlock('content', $context, $blocks);
    }

    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "  ";
        if ((($context["formType"] ?? null) == "others")) {
            // line 3
            echo "    <div id=\"mailpoet_widget_preview\" class=\"mailpoet_widget_preview\">
      <div id=\"sidebar\" class=\"sidebar widget-area si-sidebar-container\">
        <div class=\"widget si-widget\">
          ";
            // line 6
            echo ($context["form"] ?? null);
            echo "
        </div>
      </div>
    </div>
  ";
        } else {
            // line 11
            echo "    ";
            echo ($context["post"] ?? null);
            echo "
    ";
            // line 12
            echo ($context["form"] ?? null);
            echo "
  ";
        }
    }

    public function getTemplateName()
    {
        return "form/form_preview.html";
    }

    public function getDebugInfo()
    {
        return array (  66 => 12,  61 => 11,  53 => 6,  48 => 3,  45 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "form/form_preview.html", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/form/form_preview.html");
    }
}
