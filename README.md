README - Schulprojekt: Noten- und Stundenplan-Website
=====================================================

Projektbeschreibung
-------------------

Unser Projekt ist eine Website, die es Nutzern ermöglicht, ihre schulischen Leistungen zu verwalten und zu überwachen. Die Hauptfunktionen der Website umfassen:

1.  **Anmeldung und Registrierung**
    *   Benutzer können sich anmelden und registrieren.
    *   Unterstützung von Zwei-Faktor-Authentifizierung (2FA) für zusätzliche Sicherheit.
2.  **Notenübersicht**
    *   Anzeige von Noten in verschiedenen Fächern.
    *   Berechnung und Darstellung des Notenschnitts.
    *   Anzeige des aktuellen Promotionsstandes.
    *   Detaillierte Übersicht einzelner Noten.
3.  **Optionales Feature: Kalender**
    *   Personenspezifischer Kalender, der eingetragene Lektionen anzeigt.
    *   Möglichkeit zur Eintragung von Prüfungen, Zimmer- und Lektionenverschiebungen.
    *   Benachrichtigung über ausgefallene Lektionen und andere relevante Änderungen.

Technische Anforderungen
------------------------

*   **Front-End:** HTML, CSS, JavaScript
*   **Back-End:** PHP mit Laravel
*   **Datenbank:** MySQL
*   **Sicherheit:** Implementierung von Zwei-Faktor-Authentifizierung (2FA)
*   **Kalender-Integration (optional):** Kalender-API oder eigene Implementierung zur Verwaltung von Lektionen und Prüfungen

Schritte zum Klonen und Starten des Projekts
--------------------------------------------

### Voraussetzungen

*   **Git:** Zum Klonen des Repositories.
*   **Docker:** Zum Ausführen der Anwendung in Containern.
*   **Docker Compose:** Um mehrere Container einfach zu verwalten.

### Schritte

1.  **Repository klonen:**
    
        git clone https://github.com/benutzername/repositoryname.git
    
2.  **In das Projektverzeichnis wechseln:**
    
        cd repositoryname
    
3.  **Umgebungsdatei kopieren:**
    
    Kopiere die Beispiel-Umgebungsdatei `.env.example` und passe sie an:
    
        cp .env.example .env
    
4.  **Docker-Container starten:**
    
        docker-compose up -d
    
5.  **Mit dem Container interagieren:**
    
    Versuche, in den Container zu gelangen:
    
        docker exec -it laravel bash
    
    **Hinweis:** Falls du folgende Fehlermeldung erhältst:
    
        Error response from daemon: Container [container-id] is not running
    
    bedeutet dies, dass der Laravel-Service nicht läuft. In diesem Fall musst du den Laravel-Container neu starten:
    
        docker-compose up -d laravel
    
    Anschließend fahre mit Schritt 6 fort.
    
6.  **Composer installieren, wenn der Service "laravel" nicht läuft:**
    
    Falls du weiterhin Probleme hast oder Composer noch nicht installiert ist, kannst du einen temporären Container starten, um Composer auszuführen:
    
        docker-compose run --rm laravel composer install
    
7.  **Anwendung im Browser aufrufen:**
    
    Öffne den Browser und gehe zu **http://localhost:8000**, um die Anwendung zu nutzen.
    
8.  **Datenbankverwaltung:**
    
    Um die Datenbank zu verwalten, gehe zu **http://localhost:9001** und verwende die folgenden Zugangsdaten:
    
    *   **Benutzername:** root
    *   **Passwort:** root
9.  **Docker-Container stoppen:**
    
        docker-compose down
    

### Wichtige Hinweise

*   Stelle sicher, dass Docker und Docker Compose korrekt installiert sind.
*   Wenn der Container einen anderen Namen hat (z. B. `app` oder `web`), verwende diesen Namen anstelle von `laravel`.
*   Überprüfe die `docker-compose.yml` Datei auf spezifische Einstellungen und Umgebungsvariablen.
*   Wenn es spezielle Anweisungen in der README-Datei gibt, sollten diese ebenfalls befolgt werden.
