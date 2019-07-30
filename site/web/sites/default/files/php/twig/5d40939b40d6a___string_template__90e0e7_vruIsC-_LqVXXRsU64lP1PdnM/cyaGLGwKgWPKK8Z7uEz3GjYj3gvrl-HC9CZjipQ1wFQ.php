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

/* __string_template__90e0e72162608ff6b10dfe51b8805d75900d5c0d8cb1ab7a35cc8d70967b8a50 */
class __TwigTemplate_2d7bc5a585287a11261671b4a58be21728ce44e1000f351dad83893695d2e846 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 2];
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
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "__string_template__90e0e72162608ff6b10dfe51b8805d75900d5c0d8cb1ab7a35cc8d70967b8a50"));

        // line 1
        echo "<div class=\"row profile-header\">
   <div class=\" profile-bg col-lg-12 col-md-12\">";
        // line 2
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_profile_image"] ?? null)), "html", null, true);
        echo "</div>
   <div class=\"profile-img col-lg-2 col-md-2 \">
      ";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null)), "html", null, true);
        echo "
   </div>

   <div class=\"col-lg-9 col-md-9 profile-details\">
      <span class=\"profile-type pull-right\"></span>
      <span class=\"name\">";
        // line 9
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_full_name"] ?? null)), "html", null, true);
        echo "</span> 
      <span class=\"profile-university\">";
        // line 10
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_university"] ?? null)), "html", null, true);
        echo "</span>
    
   </div>
</div>
<div class=\"row profile-functional\">
                    
    <div class=\"col-lg-4 col-md-4\">
      <div class=\"profile-details-block\">
           <span class=\"profile-degree\">";
        // line 18
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_degree"] ?? null)), "html", null, true);
        echo "</span>
          <span class=\"profile-location\">";
        // line 19
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_address_locality"] ?? null)), "html", null, true);
        echo "</span>
          <span class=\"profile-years\">";
        // line 20
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_years_of_studying"] ?? null)), "html", null, true);
        echo "</span>
         <span class=\"profile-price\">";
        // line 21
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_hourly_rate"] ?? null)), "html", null, true);
        echo "</span>
      </div><br>
      <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
           <a class=\"btn  btn-primary  btn-md \" href=\"/private_message/create?recipient=";
        // line 24
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["uid"] ?? null)), "html", null, true);
        echo "\"> <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i>
            Message Me
          </a>
          <a class=\"btn btn-primary btn-md\" href=\"#\" >Hire me</a>
        
         <a  class=\"btn btn-primary btn-md\"  href=\"#\">Report issue</a>
       
      </div><br>
    
  </div>
  <div class=\"col-lg-8 col-md-8 profile-main-content\">
      <h3>About me</h3>
        ";
        // line 36
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_bio"] ?? null)), "html", null, true);
        echo "
      <h3>Modules able to teach</h3>
      <div class=\"name\">";
        // line 38
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_modules_can_teach"] ?? null)), "html", null, true);
        echo "</div> 
      <h3>Reviews</h3>
<a href=\"#\" class=\"btn btn-primary btn-md\">Leave a review</a>
       

</div>
</div>
                  
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "__string_template__90e0e72162608ff6b10dfe51b8805d75900d5c0d8cb1ab7a35cc8d70967b8a50";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 38,  122 => 36,  107 => 24,  101 => 21,  97 => 20,  93 => 19,  89 => 18,  78 => 10,  74 => 9,  66 => 4,  61 => 2,  58 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{# inline_template_start #}<div class=\"row profile-header\">
   <div class=\" profile-bg col-lg-12 col-md-12\">{{ field_profile_image }}</div>
   <div class=\"profile-img col-lg-2 col-md-2 \">
      {{ user_picture }}
   </div>

   <div class=\"col-lg-9 col-md-9 profile-details\">
      <span class=\"profile-type pull-right\"></span>
      <span class=\"name\">{{ field_full_name }}</span> 
      <span class=\"profile-university\">{{ field_university }}</span>
    
   </div>
</div>
<div class=\"row profile-functional\">
                    
    <div class=\"col-lg-4 col-md-4\">
      <div class=\"profile-details-block\">
           <span class=\"profile-degree\">{{ field_degree }}</span>
          <span class=\"profile-location\">{{ field_address_locality }}</span>
          <span class=\"profile-years\">{{ field_years_of_studying }}</span>
         <span class=\"profile-price\">{{ field_hourly_rate }}</span>
      </div><br>
      <div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">
           <a class=\"btn  btn-primary  btn-md \" href=\"/private_message/create?recipient={{ uid }}\"> <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i>
            Message Me
          </a>
          <a class=\"btn btn-primary btn-md\" href=\"#\" >Hire me</a>
        
         <a  class=\"btn btn-primary btn-md\"  href=\"#\">Report issue</a>
       
      </div><br>
    
  </div>
  <div class=\"col-lg-8 col-md-8 profile-main-content\">
      <h3>About me</h3>
        {{ field_bio }}
      <h3>Modules able to teach</h3>
      <div class=\"name\">{{ field_modules_can_teach }}</div> 
      <h3>Reviews</h3>
<a href=\"#\" class=\"btn btn-primary btn-md\">Leave a review</a>
       

</div>
</div>
                  
", "__string_template__90e0e72162608ff6b10dfe51b8805d75900d5c0d8cb1ab7a35cc8d70967b8a50", "");
    }
}
