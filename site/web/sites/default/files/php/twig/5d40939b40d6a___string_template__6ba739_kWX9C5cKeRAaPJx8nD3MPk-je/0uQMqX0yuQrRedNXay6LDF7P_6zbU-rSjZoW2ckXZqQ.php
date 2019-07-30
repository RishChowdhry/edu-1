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

/* __string_template__6ba7394ec96ae6b480526b3a9ebf45db20e079287a9eecaaf98d4ec173ed1e4c */
class __TwigTemplate_a16759f1959c1fedba35416bb6742de1e92d182fc19da4fce365a4b08aa942a3 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 4];
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
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453 = $this->env->getExtension("Drupal\\webprofiler\\Twig\\Extension\\ProfilerExtension");
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "__string_template__6ba7394ec96ae6b480526b3a9ebf45db20e079287a9eecaaf98d4ec173ed1e4c"));

        // line 1
        echo "<h1>My Dashboard</h1><br>
<div class=\"dashboard-well row well well-lg \">
<div class=\"col-lg-4 col-md-4 col-sm-12\">
<h2>Welcome,  ";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_full_name"] ?? null)), "html", null, true);
        echo " !</h2>
</div>
<div class=\"col-lg-8 col-md-8 col-sm-12\">
<ul class=\"dashboard-nav-pills\">
  <li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">25</a></span></h3>
<span class=\"capture\">Booked lessons</span>
</li>

<li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">£870</a></span></h3>
<span class=\"capture\">Earned money</span>
</li>

<li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">£245</a></span></h3>
<span class=\"capture\">Available for withdraw</span>
</li>
</ul>

</div>

</div>";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "__string_template__6ba7394ec96ae6b480526b3a9ebf45db20e079287a9eecaaf98d4ec173ed1e4c";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 4,  58 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# inline_template_start #}<h1>My Dashboard</h1><br>
<div class=\"dashboard-well row well well-lg \">
<div class=\"col-lg-4 col-md-4 col-sm-12\">
<h2>Welcome,  {{ field_full_name }} !</h2>
</div>
<div class=\"col-lg-8 col-md-8 col-sm-12\">
<ul class=\"dashboard-nav-pills\">
  <li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">25</a></span></h3>
<span class=\"capture\">Booked lessons</span>
</li>

<li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">£870</a></span></h3>
<span class=\"capture\">Earned money</span>
</li>

<li>
<h3><span class=\"label label-info info-figure\"><a href=\"#\">£245</a></span></h3>
<span class=\"capture\">Available for withdraw</span>
</li>
</ul>

</div>

</div>", "__string_template__6ba7394ec96ae6b480526b3a9ebf45db20e079287a9eecaaf98d4ec173ed1e4c", "");
    }
}
