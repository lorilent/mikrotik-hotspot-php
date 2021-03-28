Vuoi una soluzione hotspot completa e dare internet ai tuoi amici, vicini di casa o estranei?Con questo progetto hai tutto quel che stai cercando, una soluzione completa, efficace e funzionante al 100%.

APPENA SCARICATO ANDARE NELLA ROOT DEL CLONE E DIGITARE IN UNA FINESTRA DI COMANDO PUNTATA SULLA DIRECTORY: composer require evilfreelancer/routeros-api-php

Il progetto è stato creato in PHP e integrato con le API di Mikrotik trovate sempre su Github.
Funzionamento del sistema:
1. Un utente accede al vostro WiFi e gli verranno richieste le credenziali per accedere, oppure in alto può scegliere la prova gratuita di quanti minuti volete voi sempre in base alla configurazione del router (profili)
2. Se l'utente sceglie la prova gratuita è costretto a inserire i suoi dati (Nome, Cognome, Email, Numero di telefono) e dopodiché gli verrà richiesto un codice OTP inviato tramite SMS.
3. Una volta inserito l’OTP corretto l’utente verrà reindirizzato ad una pagina che si occupa alla generazione delle relative credenziali e poi un’altra reindirizzazione verso la pagina d’accesso Mikrotik con le apposite credenziali già inserite nell’URL per evitare che l’utente le immetta.
4. Fine.

Il config.php (che è da modificare assolutamente sennò il sistema non funziona) richiede la configurazione di 16 campi (Database; Invio SMS tramite router Mikrotik; Credenziali del router Mikrotik con la rete hotspot configurata; IP dell’hotspot; il profilo dell’utente per durata e/o limitazioni di velocità; Il nome dell’hotspot).

Crediti:

EvilFreelancer (API MIKROTIK);
