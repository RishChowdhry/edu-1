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

/* core/modules/toolbar/templates/toolbar.html.twig */
class __TwigTemplate_1d6850504689917a91bece8d9c5c40644230e7f0fa5052b21f1ecb708681d635 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["for" => 28, "set" => 29, "spaceless" => 32, "if" => 34];
        $filters = ["escape" => 25];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'spaceless', 'if'],
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
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "core/modules/toolbar/templates/toolbar.html.twig"));

        // line 25
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => "toolbar"], "method")), "html", null, true);
        echo ">
  <nav";
        // line 26
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["toolbar_attributes"] ?? null), "addClass", [0 => "toolbar-bar"], "method")), "html", null, true);
        echo ">
    <h2 class=\"visually-hidden\">";
        // line 27
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["toolbar_heading"] ?? null)), "html", null, true);
        echo "</h2>
    ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tabs"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["tab"]) {
            // line 29
            echo "      ";
            $context["tray"] = $this->getAttribute(($context["trays"] ?? null), $context["key"], [], "array");
            // line 30
            echo "      <div";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($context["tab"], "attributes", []), "addClass", [0 => "toolbar-tab"], "method")), "html", null, true);
            echo ">
        ";
            // line 31
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["tab"], "link", [])), "html", null, true);
            echo "
        ";
            // line 32
            ob_start();
            // line 33
            echo "          <div";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["tray"] ?? null), "attributes", [])), "html", null, true);
            echo ">
            ";
            // line 34
            if ($this->getAttribute(($context["tray"] ?? null), "label", [])) {
                // line 35
                echo "              <nav class=\"toolbar-lining clearfix\" role=\"navigation\" aria-label=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["tray"] ?? null), "label", [])), "html", null, true);
                echo "\">
                <h3 class=\"toolbar-tray-name visually-hidden\">";
                // line 36
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["tray"] ?? null), "label", [])), "html", null, true);
                echo "</h3>
            ";
            } else {
                // line 38
                echo "              <nav class=\"toolbar-lining clearfix\" role=\"navigation\">
            ";
            }
            // line 40
            echo "            ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["tray"] ?? null), "links", [])), "html", null, true);
            echo "
            </nav>
          </div>
        ";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
            // line 44
            echo "      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['tab'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "  </nav>
  ";
        // line 47
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["remainder"] ?? null)), "html", null, true);
        echo "
</div>
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "core/modules/toolbar/templates/toolbar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  128 => 47,  125 => 46,  118 => 44,  110 => 40,  106 => 38,  101 => 36,  96 => 35,  94 => 34,  89 => 33,  87 => 32,  83 => 31,  78 => 30,  75 => 29,  71 => 28,  67 => 27,  63 => 26,  58 => 25,);
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
 * Default theme implementation for the administrative toolbar.
 *
 * Available variables:
 * - attributes: HTML attributes for the wrapper.
 * - toolbar_attributes: HTML attributes to apply to the toolbar.
 * - toolbar_heading: The heading or label for the toolbar.
 * - tabs: List of tabs for the toolbar.
 *   - attributes: HTML attributes for the tab container.
 *   - link: Link or button for the menu tab.
 * - trays: Toolbar tray list, each associated with a tab. Each tray in trays
 *   contains:
 *   - attributes: HTML attributes to apply to the tray.
 *   - label: The tray's label.
 *   - links: The tray menu links.
 * - remainder: Any non-tray, non-tab elements left to be rendered.
 *
 * @see template_preprocess_toolbar()
 *
 * @ingroup themeable
 */
#}
<div{{ attributes.addClass('toolbar') }}>
  <nav{{ toolbar_attributes.addClass('toolbar-bar') }}>
    <h2 class=\"visually-hidden\">{{ toolbar_heading }}</h2>
    {% for key, tab in tabs %}
      {% set tray = trays[key] %}
      <div{{ tab.attributes.addClass('toolbar-tab') }}>
        {{ tab.link }}
        {% spaceless %}
          <div{{ tray.attributes }}>
            {% if tray.label %}
              <nav class=\"toolbar-lining clearfix\" role=\"navigation\" aria-label=\"{{ tray.label }}\">
                <h3 class=\"toolbar-tray-name visually-hidden\">{{ tray.label }}</h3>
            {% else %}
              <nav class=\"toolbar-lining clearfix\" role=\"navigation\">
            {% endif %}
            {{ tray.links }}
            </nav>
          </div>
        {% endspaceless %}
      </div>
    {% endfor %}
  </nav>
  {{ remainder }}
</div>
", "core/modules/toolbar/templates/toolbar.html.twig", "/var/www/html/edu.local/public_html/site/web/core/modules/toolbar/templates/toolbar.html.twig");
    }
}