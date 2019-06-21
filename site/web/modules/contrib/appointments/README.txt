Appointments
============

Il modulo aggiunge al sito la possibilità di gestire Appuntamenti.
Nel file compose.json sono indicate le dipendenze del modulo.

Configurazione
==============

La pagina di configurazione del modulo è:
 - /admin/config/system/appointments

Il modulo per poter funzionare ha necessità di un content type dedicato.
E' possibile anche indicare due campi del profilo utente che il modulo usa per
completare il form di richiesta appuntamento  con nome e cognome
dell'utente, quando la richiesta viene fatta da un utente autenticato.

I permessi
===========

Gli utenti che devono gestire il tool, devono avere il permesso: 'manage appointments'

Per fare le richieste di appuntamento l'utente (autenticato o anonimo) deve
poter creare entità di tipo Appointment ed Applicant e deve avere il permesso
per l'utilizzo della transizione.

Traduzione
===========

La traduzione dei testi del modulo può essere fatta nel modo standard per drupal
dalla pagina: admin/config/regional/translate

Sviluppo
=========

Le librerie richieste dal frontend vengono caricate sui template twig utilizzati.
Per poter alterare l'aspetto ed il contenuto di una cella del calendario è possibile
registrare una callback su JS usando l'API del behaviors:
 - Drupal.behaviors.appointments.registerEventRenderCallback(id, callback)
