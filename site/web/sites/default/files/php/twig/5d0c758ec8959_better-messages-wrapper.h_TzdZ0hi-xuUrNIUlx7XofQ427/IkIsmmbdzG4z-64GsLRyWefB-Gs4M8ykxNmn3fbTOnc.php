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

/* modules/contrib/better_messages/templates/better-messages-wrapper.html.twig */
class __TwigTemplate_522c9eace8279296e83065baffb6f684c80709b74b18b42530d9e4eff67550fe extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'children' => [$this, 'block_children'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["block" => 15, "if" => 19];
        $filters = ["escape" => 13, "t" => 20];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['block', 'if'],
                ['escape', 't'],
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
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "modules/contrib/better_messages/templates/better-messages-wrapper.html.twig"));

        // line 13
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "setAttribute", [0 => "id", 1 => "better-messages-default"], "method")), "html", null, true);
        echo ">
  <div id=\"better-messages-inner\">
    ";
        // line 15
        $this->displayBlock('children', $context, $blocks);
        // line 23
        echo "  </div>
</div>
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    // line 15
    public function block_children($context, array $blocks = [])
    {
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453 = $this->env->getExtension("Drupal\\webprofiler\\Twig\\Extension\\ProfilerExtension");
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "children"));

        // line 16
        echo "      <div class=\"better-messages-content\">
        ";
        // line 17
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["children"] ?? null)), "html", null, true);
        echo "
      </div>
      ";
        // line 19
        if ($this->getAttribute(($context["attributes"] ?? null), "hasClass", [0 => "better-messages-overlay"], "method")) {
            // line 20
            echo "        <div class=\"better-messages-footer\"><span class=\"better-messages-timer\"></span><a class=\"better-messages-close\" href=\"#\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Close"));
            echo "<span></span></a></div>
      ";
        }
        // line 22
        echo "    ";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "modules/contrib/better_messages/templates/better-messages-wrapper.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  98 => 22,  92 => 20,  90 => 19,  85 => 17,  82 => 16,  76 => 15,  67 => 23,  65 => 15,  59 => 13,);
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
/**
 * @file
 * Default theme for better_messages_wrapper theme hook.
 *
 * Wrap the system messages into additional markup required for presenting the
 * messages in an overlay.
 *
 * Available variables:
 * - children: The system messages
 */
#}
<div{{ attributes.setAttribute('id', 'better-messages-default') }}>
  <div id=\"better-messages-inner\">
    {%block children%}
      <div class=\"better-messages-content\">
        {{ children }}
      </div>
      {% if attributes.hasClass('better-messages-overlay') %}
        <div class=\"better-messages-footer\"><span class=\"better-messages-timer\"></span><a class=\"better-messages-close\" href=\"#\">{{ 'Close' | t }}<span></span></a></div>
      {% endif %}
    {%endblock%}
  </div>
</div>
", "modules/contrib/better_messages/templates/better-messages-wrapper.html.twig", "/var/www/html/edu.local/public_html/site/web/modules/contrib/better_messages/templates/better-messages-wrapper.html.twig");
    }
}
