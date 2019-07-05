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

/* themes/custom/edu/templates/system/block--system-menu-block.html.twig */
class __TwigTemplate_fb97cf6f1064bc9f118460a8dc6dfd0dc4a43f71d1bf78e0e9dcefd4c23e5b18 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 37, "block" => 42];
        $filters = ["clean_id" => 37, "escape" => 38, "without" => 38];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'block'],
                ['clean_id', 'escape', 'without'],
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
        // line 36
        echo "
";
        // line 37
        $context["heading_id"] = ($this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "id", [])) . \Drupal\Component\Utility\Html::getId("-menu"));
        // line 38
        echo "<nav role=\"navigation\" aria-labelledby=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["heading_id"] ?? null)), "html", null, true);
        echo "\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->withoutFilter($this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null)), "role", "aria-labelledby"), "html", null, true);
        echo ">
  ";
        // line 40
        echo "
  ";
        // line 42
        echo "  ";
        $this->displayBlock('content', $context, $blocks);
        // line 45
        echo "</nav>
";
    }

    // line 42
    public function block_content($context, array $blocks = [])
    {
        // line 43
        echo "    ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null)), "html", null, true);
        echo "
  ";
    }

    public function getTemplateName()
    {
        return "themes/custom/edu/templates/system/block--system-menu-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 43,  79 => 42,  74 => 45,  71 => 42,  68 => 40,  61 => 38,  59 => 37,  56 => 36,);
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
 * Default theme implementation for a menu block.
 *
 * Available variables:
 * - plugin_id: The ID of the block implementation.
 * - label: The configured label of the block if visible.
 * - configuration: A list of the block's configuration values.
 *   - label: The configured label for the block.
 *   - label_display: The display settings for the label.
 *   - provider: The module or other provider that provided this block plugin.
 *   - Block plugin specific settings will also be stored here.
 * - content: The content of this block.
 * - attributes: HTML attributes for the containing element.
 *   - id: A valid HTML ID and guaranteed unique.
 * - title_attributes: HTML attributes for the title element.
 * - content_attributes: HTML attributes for the content element.
 * - title_prefix: Additional output populated by modules, intended to be
 *   displayed in front of the main title tag that appears in the template.
 * - title_suffix: Additional output populated by modules, intended to be
 *   displayed after the main title tag that appears in the template.
 *
 * Headings should be used on navigation menus that consistently appear on
 * multiple pages. When this menu block's label is configured to not be
 * displayed, it is automatically made invisible using the 'visually-hidden' CSS
 * class, which still keeps it visible for screen-readers and assistive
 * technology. Headings allow screen-reader and keyboard only users to navigate
 * to or skip the links.
 * See http://juicystudio.com/article/screen-readers-display-none.php and
 * http://www.w3.org/TR/WCAG-TECHS/H42.html for more information.
 *
 * @ingroup themeable
 */
#}

{% set heading_id = attributes.id ~ '-menu'|clean_id %}
<nav role=\"navigation\" aria-labelledby=\"{{ heading_id }}\"{{ attributes|without('role', 'aria-labelledby') }}>
  {# Label. If not displayed, we still provide it for screen readers. #}

  {# Menu. #}
  {% block content %}
    {{ content }}
  {% endblock %}
</nav>
", "themes/custom/edu/templates/system/block--system-menu-block.html.twig", "/var/www/html/edu.local/public_html/site/web/themes/custom/edu/templates/system/block--system-menu-block.html.twig");
    }
}
