<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/custom/edu/templates/system/page--user--register--student.html.twig */
class __TwigTemplate_299f16a8a005874929dd10f33de4e6952c46131b86891fcfe829da788238938d extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 11];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 6
        echo "<div class=\"page-wrapper register-page\">

    <div class=\"container\">

        <div class=\"register-box\">
        ";
        // line 11
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "messages", [])), "html", null, true);
        echo "

            <div class=\"row\">
                <div class=\"col-lg-4 col-md-6 register-info\">


                        ";
        // line 17
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar", [])), "html", null, true);
        echo "



                </div>
                <div class=\"col-lg-6 col-md-6 register-form\">
                     <h2>Student Account Registration</h2>
                        ";
        // line 24
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
                </div>
            </div>

        </div>

    </div>

</div>







";
    }

    public function getTemplateName()
    {
        return "themes/custom/edu/templates/system/page--user--register--student.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 24,  71 => 17,  62 => 11,  55 => 6,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{#
    @file:

    Simple page login page
#}
<div class=\"page-wrapper register-page\">

    <div class=\"container\">

        <div class=\"register-box\">
        {{ page.messages }}

            <div class=\"row\">
                <div class=\"col-lg-4 col-md-6 register-info\">


                        {{ page.sidebar }}



                </div>
                <div class=\"col-lg-6 col-md-6 register-form\">
                     <h2>Student Account Registration</h2>
                        {{ page.content }}
                </div>
            </div>

        </div>

    </div>

</div>







", "themes/custom/edu/templates/system/page--user--register--student.html.twig", "/var/www/html/edu.local/public_html/site/web/themes/custom/edu/templates/system/page--user--register--student.html.twig");
    }
}
