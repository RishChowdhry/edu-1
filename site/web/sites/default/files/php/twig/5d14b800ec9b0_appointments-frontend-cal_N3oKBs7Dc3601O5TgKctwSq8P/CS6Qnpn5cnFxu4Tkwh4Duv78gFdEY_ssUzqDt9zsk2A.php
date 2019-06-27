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

/* modules/contrib/appointments/templates/appointments-frontend-calendar.html.twig */
class __TwigTemplate_e6c186d520a3223c7333faae55cdd3501220a7d0898845dba16d4efe2dd64333 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 13, "t" => 20];
        $functions = ["attach_library" => 13];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 't'],
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
        // line 12
        echo "
";
        // line 13
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/jquery.validate"), "html", null, true);
        echo "
";
        // line 14
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/moment"), "html", null, true);
        echo "
";
        // line 15
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/fullcalendar"), "html", null, true);
        echo "
";
        // line 16
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/appointments_frontend_calendar"), "html", null, true);
        echo "
";
        // line 17
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/appointments_frontend_calendar.fullcalendar.overrides"), "html", null, true);
        echo "
";
        // line 18
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("appointments/appointments_frontend_calendar.fullcalendar.customize"), "html", null, true);
        echo "

<h3>";
        // line 20
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Request an appointment"));
        echo ":</h3>
<ul>
  <li>";
        // line 22
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Gray: not available"));
        echo "</li>
  <li>";
        // line 23
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar("Green: available|t");
        echo "</li>
</ul>
<p>";
        // line 25
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("WARNING: availability vary continuously: it is recommended to come back often on these pages to check for updates."));
        echo "</p>

<div class=\"appointments-wizard js-appointments\">
  <div id='calendar' class=\"appointments-wizard__panel--calendar\">
    <h2 class=\"appointments-wizard__step-title\">1 - ";
        // line 29
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Choose the day"));
        echo ":</h2>
    <div class=\"js-calendar\"></div>
  </div>
  <div id='day' class=\"appointments-wizard__panel--day is-hidden is-shifted--right\"></div>
  <div id='form' class=\"appointments-wizard__panel--form is-hidden is-shifted--right\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/contrib/appointments/templates/appointments-frontend-calendar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 29,  97 => 25,  92 => 23,  88 => 22,  83 => 20,  78 => 18,  74 => 17,  70 => 16,  66 => 15,  62 => 14,  58 => 13,  55 => 12,);
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
 * Default theme implementation to present frontend Availability calendar.
 *
 * Available variables:
 * - node:
 *
 * @ingroup themeable
 */
#}

{{ attach_library('appointments/jquery.validate') }}
{{ attach_library('appointments/moment') }}
{{ attach_library('appointments/fullcalendar') }}
{{ attach_library('appointments/appointments_frontend_calendar') }}
{{ attach_library('appointments/appointments_frontend_calendar.fullcalendar.overrides') }}
{{ attach_library('appointments/appointments_frontend_calendar.fullcalendar.customize') }}

<h3>{{ \"Request an appointment\"|t }}:</h3>
<ul>
  <li>{{ \"Gray: not available\"|t }}</li>
  <li>{{ \"Green: available|t\" }}</li>
</ul>
<p>{{ \"WARNING: availability vary continuously: it is recommended to come back often on these pages to check for updates.\"|t }}</p>

<div class=\"appointments-wizard js-appointments\">
  <div id='calendar' class=\"appointments-wizard__panel--calendar\">
    <h2 class=\"appointments-wizard__step-title\">1 - {{ \"Choose the day\"|t }}:</h2>
    <div class=\"js-calendar\"></div>
  </div>
  <div id='day' class=\"appointments-wizard__panel--day is-hidden is-shifted--right\"></div>
  <div id='form' class=\"appointments-wizard__panel--form is-hidden is-shifted--right\"></div>
</div>
", "modules/contrib/appointments/templates/appointments-frontend-calendar.html.twig", "/var/www/html/edu.local/public_html/site/web/modules/contrib/appointments/templates/appointments-frontend-calendar.html.twig");
    }
}
