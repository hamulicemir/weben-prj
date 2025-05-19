README: Projekthinweise zur Inbetriebnahme
=================================================
GITHUB REPO: https://github.com/hamulicemir/weben-prj


Projektname: ICONIQ
Ersteller: Emir Hamulic, Jasmin Kerber, Simona Kimbere

1. Voraussetzungen
-------------------------------------------------
a) PHP (getestet mit Version 9.2.12 unter XAMPP)
b) MySQL
c) Composer (https://getcomposer.org)
d) Lokale Serverumgebung (XAMPP)

2. Composer-Abhängigkeiten
-------------------------------------------------
Bitte folgenden Befehl im Projektverzeichnis ausführen, um alle benötigten Abhängigkeiten zu installieren: 
> composer install

Falls Probleme mit der mPDF-Bibliothek auftreten, führen Sie bitte zusätzlich folgende Befehle aus:
> composer remove mpdf/mpdf
> composer clear-cache
> composer require mpdf/mpdf

3. MySQL-Datenbank
-------------------------------------------------
Importieren Sie die beigefügte SQL-Datei "weben-prj" in Ihre lokale MySQL-Datenbank, z.B. über phpMyAdmin oder über die Konsole:
> mysql -u root -p < datenbank.sql

4. Anwendung starten
-------------------------------------------------
a) Starten Sie Apache und MySQL (z.B. über XAMPP)
b) Rufen Sie das Projekt im Browser auf: 
> http://localhost/weben-prj/frontend/pages/index.php

5. Weitere Hinweise
-------------------------------------------------
a) Rechnungen werden serverseitig über mPDF generiert (-> backend/handlers/generate-invoice.php)
b) Es sind keine weiteren Konfigurationsschritte erforderlich

