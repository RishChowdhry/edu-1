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

/* __string_template__d42891020cff4639de065bd806fc5d2e1d458d052956a5db4533135e248eb634 */
class __TwigTemplate_da3b8c011d63ec3f5e97a77900ad7d1adea28b0b8dbbf16e6ebc27cf5ef18125 extends \Twig\Template
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
        echo "<ul class=\"nav navbar-nav pull-right profile-menu\">
   <li role=\"presentation\" class=\"dropdown\">
      <a class=\"dropdown-toggle avatar\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"true\">
         ";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null)), "html", null, true);
        echo "
        
      </a>
      <ul class=\"dropdown-menu\">
         <li>";
        // line 8
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["view_user"] ?? null)), "html", null, true);
        echo "</li>
         <li>";
        // line 9
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["edit_user"] ?? null)), "html", null, true);
        echo " </li>
         <li>";
        // line 10
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["view_profile"] ?? null)), "html", null, true);
        echo "</li>
         <li>";
        // line 11
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["edit_profile"] ?? null)), "html", null, true);
        echo "</li>
         <li>";
        // line 12
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nothing"] ?? null)), "html", null, true);
        echo "  </li>
      </ul>
   </li>
</ul>";
    }

    public function getTemplateName()
    {
        return "__string_template__d42891020cff4639de065bd806fc5d2e1d458d052956a5db4533135e248eb634";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 12,  79 => 11,  75 => 10,  71 => 9,  67 => 8,  60 => 4,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# inline_template_start #}<ul class=\"nav navbar-nav pull-right profile-menu\">
   <li role=\"presentation\" class=\"dropdown\">
      <a class=\"dropdown-toggle avatar\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"true\">
         {{ user_picture }}
        
      </a>
      <ul class=\"dropdown-menu\">
         <li>{{ view_user }}</li>
         <li>{{ edit_user }} </li>
         <li>{{ view_profile }}</li>
         <li>{{ edit_profile }}</li>
         <li>{{ nothing }}  </li>
      </ul>
   </li>
</ul>", "__string_template__d42891020cff4639de065bd806fc5d2e1d458d052956a5db4533135e248eb634", "");
    }
}
