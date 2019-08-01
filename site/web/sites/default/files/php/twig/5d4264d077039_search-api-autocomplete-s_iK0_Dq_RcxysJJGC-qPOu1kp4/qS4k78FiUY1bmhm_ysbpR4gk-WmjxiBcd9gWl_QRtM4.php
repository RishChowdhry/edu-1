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

/* modules/contrib/search_api_autocomplete/templates/search-api-autocomplete-suggestion.html.twig */
class __TwigTemplate_66eba2b9fa6c7929ee4876f96b365db36faa5aa1be0dae26d110b57bacb5f022 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 30, "spaceless" => 36];
        $filters = ["escape" => 31];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'spaceless'],
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
        // line 28
        echo "
<div class=\"search-api-autocomplete-suggestion\">
  ";
        // line 30
        if (($context["note"] ?? null)) {
            // line 31
            echo "    <span class=\"autocomplete-suggestion-note\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["note"] ?? null)), "html", null, true);
            echo "</span>
  ";
        }
        // line 33
        echo "  ";
        if (($context["label"] ?? null)) {
            // line 34
            echo "    <span class=\"autocomplete-suggestion-label\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null)), "html", null, true);
            echo "</span>
  ";
        }
        // line 36
        echo "  ";
        ob_start();
        // line 37
        echo "    ";
        if (($context["suggestion_prefix"] ?? null)) {
            // line 38
            echo "      <span class=\"autocomplete-suggestion-suggestion-prefix\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["suggestion_prefix"] ?? null)), "html", null, true);
            echo "</span>
    ";
        }
        // line 40
        echo "    ";
        if (($context["user_input"] ?? null)) {
            // line 41
            echo "      <span class=\"autocomplete-suggestion-user-input\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_input"] ?? null)), "html", null, true);
            echo "</span>
    ";
        }
        // line 43
        echo "    ";
        if (($context["suggestion_suffix"] ?? null)) {
            // line 44
            echo "      <span class=\"autocomplete-suggestion-suggestion-suffix\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["suggestion_suffix"] ?? null)), "html", null, true);
            echo "</span>
    ";
        }
        // line 46
        echo "  ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 47
        echo "  ";
        if (($context["results_count"] ?? null)) {
            // line 48
            echo "    <span class=\"autocomplete-suggestion-results-count\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["results_count"] ?? null)), "html", null, true);
            echo "</span>
  ";
        }
        // line 50
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/search_api_autocomplete/templates/search-api-autocomplete-suggestion.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 50,  112 => 48,  109 => 47,  106 => 46,  100 => 44,  97 => 43,  91 => 41,  88 => 40,  82 => 38,  79 => 37,  76 => 36,  70 => 34,  67 => 33,  61 => 31,  59 => 30,  55 => 28,);
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
 * Default theme implementation to display a search suggestion.
 *
 * Keywords suggestions (which will fill the keywords input field) can be
 * distinguished from direct results/links (which will take the user to a
 * different page) by checking whether the \"keys\" or the \"url\" key is set.
 *
 * Keywords suggestions will usually contain the keywords as a concatenation of
 * \"suggestion_prefix\", \"user_input\" and \"suggestion_suffix\".
 *
 * Available variables:
 * - keys: The fulltext keywords this suggestion will put into the search field.
 * - url: The URL (\\Drupal\\Core\\Url object) to which the suggestion will
 *   redirect the user.
 * - label: A complete label to display for the suggestion.
 * - note: Text to display in front of the label.
 * - results_count: The (approximate) number of results the suggested keywords
 *   will yield.
 * - suggestion_prefix: A suggested prefix for the entered user input.
 * - suggestion_suffix: A suggested suffix for the entered user input.
 * - user_input: The input entered by the user so far.
 *
 * @ingroup themeable
 */
#}

<div class=\"search-api-autocomplete-suggestion\">
  {% if note %}
    <span class=\"autocomplete-suggestion-note\">{{ note }}</span>
  {% endif %}
  {% if label %}
    <span class=\"autocomplete-suggestion-label\">{{ label }}</span>
  {% endif %}
  {% spaceless %}
    {% if suggestion_prefix %}
      <span class=\"autocomplete-suggestion-suggestion-prefix\">{{ suggestion_prefix }}</span>
    {% endif %}
    {% if user_input %}
      <span class=\"autocomplete-suggestion-user-input\">{{ user_input }}</span>
    {% endif %}
    {% if suggestion_suffix %}
      <span class=\"autocomplete-suggestion-suggestion-suffix\">{{ suggestion_suffix }}</span>
    {% endif %}
  {% endspaceless %}
  {% if results_count %}
    <span class=\"autocomplete-suggestion-results-count\">{{ results_count }}</span>
  {% endif %}
</div>
", "modules/contrib/search_api_autocomplete/templates/search-api-autocomplete-suggestion.html.twig", "/var/www/html/edu.local/public_html/site/web/modules/contrib/search_api_autocomplete/templates/search-api-autocomplete-suggestion.html.twig");
    }
}
