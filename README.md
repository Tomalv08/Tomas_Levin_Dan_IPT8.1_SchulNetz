  README - Schulprojekt: Noten- und Stundenplan-Website

# README - Schulprojekt: Noten- und Stundenplan-Website

## Projektbeschreibung

Unser Projekt ist eine Website, die es Nutzern ermöglicht, ihre schulischen Leistungen zu verwalten und zu überwachen. Die Hauptfunktionen der Website umfassen:

1.  **Anmeldung und Registrierung**
    *   Benutzer können sich anmelden und registrieren.
    *   Unterstützung von Zwei-Faktor-Authentifizierung (2FA) für zusätzliche Sicherheit.
2.  **Notenübersicht Schüler**
    *   Anzeige von Noten in verschiedenen Fächern.
    *   Berechnung und Darstellung des Notenschnitts.
    *   Anzeige des aktuellen Promotionsstandes.
    *   Detaillierte Übersicht einzelner Noten.
3.  **Notenübersicht Lehrer**
    *   Verwaltung der Schüler in den zugewiesenen Klassen.
    *   Notenvergabe und Bearbeitung einzelner Noten pro Schüler.
    *   Verwaltung und Hinzufügen neuer Fächer, die in der Klasse unterrichtet werden.
    *   Unterstützung einer Suchfunktion, um Schüler oder Fächer schnell zu finden..
    *   Übersicht über alle Schüler und ihre E-Mail-Adressen sowie die Möglichkeit, Schüler hinzuzufügen oder zu entfernen.
4.  **Optionales Feature: Kalender**
    *   Personenspezifischer Kalender, der eingetragene Lektionen anzeigt.
    *   Möglichkeit zur Eintragung von Prüfungen, Zimmer- und Lektionenverschiebungen.
    *   Benachrichtigung über ausgefallene Lektionen und andere relevante Änderungen.

## Technische Anforderungen

*   **Front-End:** HTML, CSS, JavaScript
*   **Back-End:** PHP mit Laravel
*   **Datenbank:** MySQL
*   **Sicherheit:** Implementierung von Zwei-Faktor-Authentifizierung (2FA)
*   **Kalender-Integration (optional):** Kalender-API oder eigene Implementierung zur Verwaltung von Lektionen und Prüfungen

## Schritte zum Klonen und Starten des Projekts

### Voraussetzungen

*   **Git:** Zum Klonen des Repositories.
*   **Docker:** Zum Ausführen der Anwendung in Containern.
*   **Docker Compose:** Um mehrere Container einfach zu verwalten.

### Schritte

1.  **Repository klonen:**
    
    ```
    git clone https://github.com/benutzername/repositoryname.git
    ```
    
2.  **In das Projektverzeichnis wechseln:**
    
    ```
    cd repositoryname
    ```
    
3.  **Umgebungsdatei kopieren:**
    
    ```
    cp .env.example .env
    ```
    
4.  **Docker-Container starten:**
    
    ```
    docker-compose up -d
    ```
    
    Hiermit wird der Container im Hintergrund ausgeführt.
    
5.  **Composer-Abhängigkeiten installieren:**
    
    ```
    docker-compose run --rm laravel composer install
    ```
    
    Dieser Schritt muss unbedingt ausgeführt werden, bevor du mit dem Container interagierst.
    
6.  **Mit dem Container interagieren:**
    
    ```
    docker exec -it laravel bash
    ```
    
    Da der Container im Hintergrund ausgeführt wird (mit `-d`), musst du diesen Befehl verwenden, um mit dem Container zu kommunizieren. Nach der erfolgreichen Ausführung dieses Befehls kannst du die Migrationen und Seeder durchführen.
    
7.  **Migrations und Seeder ausführen:**
    
    Führe nach der Installation der Abhängigkeiten die Datenbankmigrationen und Seeder aus:
    
    *   **Migrations ausführen:**
        
        ```
        php artisan migrate
        ```
        
    *   **Seeder ausführen:**
        
        ```
        php artisan db:seed
        ```
        
    *   **Migrations und Seeder gemeinsam ausführen:**
        
        ```
        php artisan migrate --seed
        ```
        
    *   **Migration Refresh:**
        
        ```
        php artisan migrate:refresh
        ```
        
        (Dieser Befehl setzt die Datenbank zurück und führt die Migrationen neu aus.)
    *   **Migration Refresh mit Seed:**
        
        ```
        php artisan migrate:refresh --seed
        ```
        
        (Setzt die Datenbank zurück, führt Migrationen aus und seeded die Daten.)
8.  **Anwendung im Browser aufrufen:**
    
    Öffne den Browser und gehe zu **[http://localhost:8000](http://localhost:8000)**, um die Anwendung zu nutzen.

    Lehrer Login-Daten:
    E-Mail: Tomas_TeixeiraAlves@sluz.ch
    Passwort: password123
    
    Schüler Login-Daten:
    E-Mail: Levin_Linder@sluz.ch
    Passwort: password123
    
    E-Mail: Dan_Krummenacher@sluz.ch
    Passwort: password123
    
10.  **Datenbankverwaltung:**
    
    Um die Datenbank zu verwalten, gehe zu **[http://localhost:9001](http://localhost:9001)** und verwende die folgenden Zugangsdaten:
    
    *   **Benutzername:** root
    *   **Passwort:** root
    

11.  **Docker-Container stoppen:**
    
    ```
    docker-compose down
    ```
    

### Wichtige Hinweise

*   Stelle sicher, dass Docker und Docker Compose korrekt installiert sind.
*   Wenn der Container einen anderen Namen hat (z.B. `app` oder `web`), verwende diesen Namen anstelle von `laravel`.
*   Überprüfe die `docker-compose.yml` Datei auf spezifische Einstellungen und Umgebungsvariablen.
*   Wenn es spezielle Anweisungen in der README-Datei gibt, sollten diese ebenfalls befolgt werden.
