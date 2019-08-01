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

/* __string_template__6c8e91975b864db3ffce4f80684dc5f3b11fb6fc859655c17691ba988d954308 */
class __TwigTemplate_38fde1912a020b492cfb471ef440e12cfabfc6c77a617858cab9e1bc7de3e7be extends \Twig\Template
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
        // line 1
        echo "<div class=\"search-result-item\">
<div class=\"media\">
  <div class=\"media-left\">
   ";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null)), "html", null, true);
        echo " 
  </div>
  <div class=\"media-body\">
    <h4 class=\"media-heading\">";
        // line 7
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_full_name"] ?? null)), "html", null, true);
        echo " </h4>
   <span class=\"university\">";
        // line 8
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_university"] ?? null)), "html", null, true);
        echo "</span> 
   <span class=\"modules\"> ";
        // line 9
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_modules_can_teach"] ?? null)), "html", null, true);
        echo "</span><br>
   <span class=\"location\">";
        // line 10
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_address_locality"] ?? null)), "html", null, true);
        echo "</span>
  </div>
<div class=\"media-contacts\">
<span class=\"rate\">";
        // line 13
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_hourly_rate"] ?? null)), "html", null, true);
        echo "</span>
<a class=\"btn btn-primary btn-md btn-view-profile\" href=\"";
        // line 14
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["view_user"] ?? null)), "html", null, true);
        echo "\">view profile</a>
";
        // line 15
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nothing"] ?? null)), "html", null, true);
        echo "

</div>
</div>

</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__6c8e91975b864db3ffce4f80684dc5f3b11fb6fc859655c17691ba988d954308";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 15,  88 => 14,  84 => 13,  78 => 10,  74 => 9,  70 => 8,  66 => 7,  60 => 4,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# inline_template_start #}<div class=\"search-result-item\">
<div class=\"media\">
  <div class=\"media-left\">
   {{ user_picture }} 
  </div>
  <div class=\"media-body\">
    <h4 class=\"media-heading\">{{ field_full_name }} </h4>
   <span class=\"university\">{{ field_university }}</span> 
   <span class=\"modules\"> {{ field_modules_can_teach }}</span><br>
   <span class=\"location\">{{ field_address_locality }}</span>
  </div>
<div class=\"media-contacts\">
<span class=\"rate\">{{ field_hourly_rate }}</span>
<a class=\"btn btn-primary btn-md btn-view-profile\" href=\"{{ view_user }}\">view profile</a>
{{ nothing }}

</div>
</div>

</div>", "__string_template__6c8e91975b864db3ffce4f80684dc5f3b11fb6fc859655c17691ba988d954308", "");
    }
}
