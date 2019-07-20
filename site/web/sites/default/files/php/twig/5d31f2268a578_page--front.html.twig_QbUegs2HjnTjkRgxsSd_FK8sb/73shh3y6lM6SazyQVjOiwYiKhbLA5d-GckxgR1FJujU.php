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

/* themes/custom/edu/templates/system/page--front.html.twig */
class __TwigTemplate_464dbc4bf368fa1faa8a04436cb4ef931b621fe3d68c2f0b14daccbbdb599233 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 3];
        $filters = ["escape" => 6];
        $functions = ["attach_library" => 14];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                ['attach_library']
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
        // line 1
        echo "

";
        // line 3
        if (($context["logged_in"] ?? null)) {
            // line 4
            if ($this->getAttribute(($context["page"] ?? null), "header", [])) {
                // line 5
                echo "<header class=\"header\">
    ";
                // line 6
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
                echo "
</header>
";
            }
            // line 9
            echo "<div class=\"container\">
    ";
            // line 10
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
            echo "
 </div>

";
        } else {
            // line 14
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("edu/pagepilling-base"), "html", null, true);
            echo "
<div class=\"page-wrapper\" id=\"pagepiling\">
";
            // line 16
            if ($this->getAttribute(($context["page"] ?? null), "header", [])) {
                // line 17
                echo "<header>
    ";
                // line 18
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
                echo "
</header>
";
            }
            // line 21
            echo "
    ";
            // line 22
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
            echo "


</div>

";
        }
    }

    public function getTemplateName()
    {
        return "themes/custom/edu/templates/system/page--front.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 22,  98 => 21,  92 => 18,  89 => 17,  87 => 16,  82 => 14,  75 => 10,  72 => 9,  66 => 6,  63 => 5,  61 => 4,  59 => 3,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("

{% if logged_in %}
{% if page.header %}
<header class=\"header\">
    {{ page.header }}
</header>
{% endif %}
<div class=\"container\">
    {{ page.content }}
 </div>

{% else %}
{{ attach_library('edu/pagepilling-base') }}
<div class=\"page-wrapper\" id=\"pagepiling\">
{% if page.header %}
<header>
    {{ page.header }}
</header>
{% endif %}

    {{ page.content }}


</div>

{% endif %}", "themes/custom/edu/templates/system/page--front.html.twig", "/var/www/html/edu.local/public_html/site/web/themes/custom/edu/templates/system/page--front.html.twig");
    }
}
