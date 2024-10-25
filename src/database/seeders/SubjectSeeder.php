<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = [
            ['name' => 'Deutsch', 'type' => 'BM'],
            ['name' => 'Französisch', 'type' => 'BM'],
            ['name' => 'Englisch', 'type' => 'BM'],
            ['name' => 'Mathematik', 'type' => 'BM'],
            ['name' => 'Finanz- und Rechnungswesen', 'type' => 'BM'],
            ['name' => 'Wirtschaft und Recht', 'type' => 'BM'],
            ['name' => 'Geschichte und Politik', 'type' => 'BM'],
            ['name' => 'Informatikstruktur für kleine Unternehmen', 'type' => 'Informatik'],
            ['name' => 'Abläufe mit einer Scriptsprache automatisieren', 'type' => 'Informatik'],
            ['name' => 'Daten analysieren und modellieren', 'type' => 'Informatik'],
            ['name' => 'Datenbanken erstellen und einfügen', 'type' => 'Informatik'],
            ['name' => 'NoSQL-Datenbanken einsetzen', 'type' => 'Informatik'],
            ['name' => 'Datenschutz und Datensicherheit anwenden', 'type' => 'Informatik'],
            ['name' => 'Webauftritt erstellen und veröffentlichen', 'type' => 'Informatik'],
            ['name' => 'Kleinprojekt im Berufsumfeld abwickeln', 'type' => 'Informatik'],
            ['name' => 'Applikationen entwerfen und implementieren', 'type' => 'Informatik'],
            ['name' => 'Objektorientiert programmieren', 'type' => 'Informatik'],
            ['name' => 'Benutzerschnittstellen entwerfen und implementieren', 'type' => 'Informatik'],
            ['name' => 'Cloud Lösungen konzipieren und realisieren', 'type' => 'Informatik'],
            ['name' => 'Dienst mit Container anwenden', 'type' => 'Informatik'],
            ['name' => 'Software mit agilen Methoden entwickeln', 'type' => 'Informatik'],
            ['name' => 'Aufträge im IT-Umfeld selbstständig durchführen', 'type' => 'Informatik'],
            ['name' => 'Berufskunde - überbetriebliche Kurse', 'type' => 'Informatik'],
            ['name' => 'Datenbanken abfragen, bearbeiten und warten', 'type' => 'Informatik'],
            ['name' => 'ICT-Arbeitsplatz mit OS in Betrieb nehmen', 'type' => 'Informatik'],
            ['name' => 'Internet of Everything-Endgeräte', 'type' => 'Informatik'],
            ['name' => 'ICT-Lösungen mit Machine Learning entwickeln', 'type' => 'Informatik'],
            ['name' => 'Frontend bei interaktiven Webapplikationen realisieren', 'type' => 'Informatik'],
            ['name' => 'Integrierte Praxisteile', 'type' => 'Informatik'],
            ['name' => 'Programmiergrundlagen', 'type' => 'Informatik'],
            ['name' => 'Algorithmen entwickeln', 'type' => 'Informatik'],
            ['name' => 'Webentwicklung I', 'type' => 'Informatik'],
            ['name' => 'Webentwicklung II', 'type' => 'Informatik'],
            ['name' => 'Objektorientierung', 'type' => 'Informatik'],
            ['name' => 'Datenbankanwendungen', 'type' => 'Informatik'],
            ['name' => 'Webentwicklung III', 'type' => 'Informatik'],
            ['name' => 'Sport', 'type' => 'BM'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
