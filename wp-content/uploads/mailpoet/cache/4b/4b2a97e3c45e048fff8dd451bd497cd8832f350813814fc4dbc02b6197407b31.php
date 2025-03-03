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

/* emails/congratulatoryMssEmail.html */
class __TwigTemplate_58144d054fd340d8541bc0d600fc7f600c0e52f6471523aeca1e949a0064afab extends \MailPoetVendor\Twig\Template
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
        echo "<html lang=\"en\" style=\"margin:0;padding:0\">
<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
  <meta name=\"format-detection\" content=\"telephone=no\" />
  <title>";
        // line 7
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["subject"] ?? null), "html", null, true);
        echo "</title>
  <style type=\"text/css\">
  @media screen and (max-width: 599px) {
    div, .mailpoet_cols-two {
      max-width: 100% !important;
    }
  }
  </style>

</head>
<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" style=\"margin:0;padding:0;background-color:#f0f0f0\">
<table class=\"mailpoet_template\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0\">
  <tbody>
  <tr>
    <td align=\"center\" class=\"mailpoet-wrapper\" valign=\"top\" style=\"border-collapse:collapse;background-color:#f0f0f0\"><!--[if mso]>
      <table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"
             width=\"660\">
        <tr>
          <td class=\"mailpoet_content-wrapper\" align=\"center\" valign=\"top\" width=\"660\">
      <![endif]--><table class=\"mailpoet_content-wrapper\" border=\"0\" width=\"660\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse;background-color:#ffffff;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;max-width:660px;width:100%\">
        <tbody>

        <tr>
          <td class=\"mailpoet_content\" align=\"center\" style=\"border-collapse:collapse\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0\">
              <tbody>
              <tr>
                <td style=\"border-collapse:collapse;padding-left:0;padding-right:0\">
                  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"mailpoet_cols-one\" style=\"border-collapse:collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;margin-left:auto;margin-right:auto;padding-left:0;padding-right:0\">
                    <tbody>
                    <tr>
                      <td class=\"mailpoet_spacer\" height=\"36\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_image mailpoet_padded_vertical mailpoet_padded_side\" align=\"center\" valign=\"top\" style=\"border-collapse:collapse;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px\">
                        <img src=\"";
        // line 42
        echo $this->extensions['MailPoet\Twig\Assets']->generateCdnUrl("logo-orange-400x122.png");
        echo "\" width=\"80\" alt=\"new_logo_orange\" style=\"height:auto;max-width:100%;-ms-interpolation-mode:bicubic;border:0;display:block;outline:none;text-align:center\" />
                      </td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_spacer\" height=\"26\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_text mailpoet_padded_vertical mailpoet_padded_side\" valign=\"top\" style=\"border-collapse:collapse;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;word-break:break-word;word-wrap:break-word\">
                        <h1 style=\"margin:0 0 12px;color:#111111;font-family:'Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;font-size:40px;line-height:64px;margin-bottom:0;text-align:center;padding:0;font-style:normal;font-weight:normal\"><strong>";
        // line 50
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Congrats!");
        echo "<br />";
        echo $this->extensions['MailPoet\Twig\I18n']->translate("MailPoet is now sending your emails");
        echo "</strong></h1>
                      </td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_spacer\" height=\"41\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_text mailpoet_padded_vertical mailpoet_padded_side\" valign=\"top\" style=\"border-collapse:collapse;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;word-break:break-word;word-wrap:break-word\">
                        <table style=\"border-collapse:collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0\" width=\"100%\" cellpadding=\"0\">
                          <tr>
                            <td class=\"mailpoet_paragraph\" style=\"border-collapse:collapse;color:#000000;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:16px;line-height:25.6px;word-break:break-word;word-wrap:break-word;text-align:center\">
                              ";
        // line 61
        echo $this->extensions['MailPoet\Twig\I18n']->translate("This email was sent automatically with the MailPoet Sending Service after you activated your key in your MailPoet settings.");
        echo "
                            </td>
                          </tr></table>
                      </td>
                    </tr>
                    <tr>
                      <td class=\"mailpoet_spacer\" height=\"55\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                    </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class=\"mailpoet_content-cols-two\" align=\"left\" style=\"border-collapse:collapse;background-color:#fe5301!important\" bgcolor=\"#fe5301\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0\">
              <tbody>
              <tr>
                <td align=\"center\" style=\"border-collapse:collapse;font-size:0\"><!--[if mso]>
                  <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
                    <tbody>
                    <tr>
                      <td width=\"330\" valign=\"top\">
                  <![endif]--><div style=\"display:inline-block; max-width:330px; vertical-align:top; width:100%;\">
                    <table width=\"330\" class=\"mailpoet_cols-two\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" style=\"border-collapse:collapse;width:100%;max-width:330px;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;margin-left:auto;margin-right:auto;padding-left:0;padding-right:0\">
                      <tbody>
                      <tr>
                        <td class=\"mailpoet_spacer\" bgcolor=\"#fe5301\" height=\"22\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                      </tr>
                      <tr>
                        <td class=\"mailpoet_image mailpoet_padded_vertical mailpoet_padded_side\" align=\"left\" valign=\"top\" style=\"border-collapse:collapse;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px\">
                          <img src=\"";
        // line 95
        echo $this->extensions['MailPoet\Twig\Assets']->generateCdnUrl("logo-white-400x122.png");
        echo "\" width=\"130\" alt=\"new_logo_white\" style=\"height:auto;max-width:100%;-ms-interpolation-mode:bicubic;border:0;display:block;outline:none;text-align:center\" />
                        </td>
                      </tr>
                      <tr>
                        <td class=\"mailpoet_spacer\" height=\"26\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                      </tr>
                      </tbody>
                    </table>
                  </div><!--[if mso]>
                  </td>
                  <td width=\"330\" valign=\"top\">
                  <![endif]--><div style=\"display:inline-block; max-width:330px; vertical-align:top; width:100%;\">
                    <table width=\"330\" class=\"mailpoet_cols-two\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"left\" style=\"border-collapse:collapse;width:100%;max-width:330px;border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;table-layout:fixed;margin-left:auto;margin-right:auto;padding-left:0;padding-right:0\">
                      <tbody>
                      <tr>
                        <td class=\"mailpoet_spacer\" bgcolor=\"#fe5301\" height=\"20\" valign=\"top\" style=\"border-collapse:collapse\"></td>
                      </tr>
                      <tr>
                        <td class=\"mailpoet_header_footer_padded mailpoet_footer\" style=\"border-collapse:collapse;padding:10px 20px;line-height:25.6px;text-align:right;color:#222222;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:16px\">

                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div><!--[if mso]>
                  </td>
                  </tr>
                  </tbody>
                  </table>
                  <![endif]--></td>
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        </tbody>
      </table><!--[if mso]>
      </td>
      </tr>
      </table>
      <![endif]--></td>
  </tr>
  </tbody>
</table>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "emails/congratulatoryMssEmail.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 95,  110 => 61,  94 => 50,  83 => 42,  45 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "emails/congratulatoryMssEmail.html", "/home/customer/www/raasgroup.com/public_html/wp-content/plugins/mailpoet/views/emails/congratulatoryMssEmail.html");
    }
}
