(function ($, Drupal) {

  Drupal.behaviors.appointmentsCustomize = {
    attach: function (context, settings) {
      function eventRenderfunction(event, element) {

        var tooltip = `Open: ${event.office.open}</br>
Close: ${event.office.close}</br>
Free slots: ${event.slots.free}</br>
Booked slots: ${event.slots.booked}`;

        element.attr('title', tooltip);
        $(element).tooltipster({
          delay: 100,
          contentAsHTML: true
        });
      }

      // Register the callback to alter day event render on fullcalendar.
      Drupal.behaviors.appointments.registerEventRenderCallback('eventRenderfunction', eventRenderfunction);
    }
  };

})(jQuery, Drupal);
