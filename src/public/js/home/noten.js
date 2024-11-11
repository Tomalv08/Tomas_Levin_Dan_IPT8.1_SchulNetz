document.addEventListener('DOMContentLoaded', function() {
    // Token aus dem LocalStorage abrufen
    const token = localStorage.getItem('api_token');

    // API-Aufruf, um Noten-Daten mit Authentifizierung abzurufen
    fetch('http://localhost:8000/api/grades', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`, // Bearer-Token für Authentifizierung
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('.grades-table tbody');

        // Prüfen, ob Daten für Schüler (grades) oder Lehrer (students) vorliegen
        if (data.grades && Array.isArray(data.grades)) {
            // Fall für Schüler: Noten nach Fächern gruppiert anzeigen
            const groupedData = data.grades.reduce((acc, grade) => {
                const subject = grade.subject.name;
                if (!acc[subject]) acc[subject] = [];
                acc[subject].push(grade);
                return acc;
            }, {});

            Object.keys(groupedData).forEach(subject => {
                const grades = groupedData[subject];

                // Hauptzeile für jedes Fach
                const row = document.createElement('tr');
                row.classList.add('expandable-row');
                row.innerHTML = `
                    <td>${subject}</td>
                    <td>${calculateAverage(grades)}</td>
                    <td>${grades.length}</td>
                    <td>${getLastGrade(grades)}</td>
                    <td><span class="trend down">↘</span></td>
                `;
                tableBody.appendChild(row);

                // Erweitertes Detail für jede Note innerhalb des Fachs
                const expandedRow = document.createElement('tr');
                expandedRow.classList.add('expanded-content');
                expandedRow.style.display = 'none';
                expandedRow.innerHTML = `
                    <td colspan="5">
                        <table class="grade-details-table">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Thema</th>
                                    <th>Note</th>
                                    <th>Gewichtung</th>
                                    <th>Klassenschnitt</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${grades.map(grade => `
                                    <tr>
                                        <td>${new Date(grade.created_at).toLocaleDateString()}</td>
                                        <td>${grade.description}</td>
                                        <td><span class="grade ${getGradeClass(grade.grade)}">${grade.grade}</span></td>
                                        <td>${grade.weight}</td>
                                        <td>4.0</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </td>
                `;
                tableBody.appendChild(row);
                tableBody.appendChild(expandedRow);
            });
        } else {
            console.error('Fehler: Keine Noten-Daten gefunden oder falsches Format.', data);
        }
    })
    .catch(error => console.error('Fehler beim Abrufen der Noten:', error));

    // Event Delegation für das Erweitern der Zeilen
    document.querySelector('.grades-table tbody').addEventListener('click', function(event) {
        const row = event.target.closest('.expandable-row');
        if (row) {
            const nextRow = row.nextElementSibling;
            if (nextRow && nextRow.classList.contains('expanded-content')) {
                row.classList.toggle('active');
                nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
            }
        }
    });

    // Hilfsfunktionen
    function calculateAverage(grades) {
        let summe = 0;
        let count = 0;
    
        // Überprüfen, ob die Note eine gültige Zahl ist
        for (let i = 0; i < grades.length; i++) {
            const grade = parseFloat(grades[i].grade); // Konvertiere die Note in eine Zahl
            if (!isNaN(grade)) {
                summe += grade; // Addiere zur Summe
                count++; // Zähle gültige Noten
            }
        }
    
        // Verhindern, dass durch null geteilt wird
        if (count > 0) {
            const durchschnitt = summe / count; // Berechne den Durchschnitt
            return durchschnitt.toFixed(2); // Runde auf 2 Dezimalstellen
        } else {
            return 'N/A'; // Falls keine gültigen Noten vorhanden sind
        }
    }
    

    function getLastGrade(grades) {
        const latestGrade = grades[grades.length - 1];
        return latestGrade ? latestGrade.grade : 'N/A';
    }

    function getGradeClass(grade) {
        if (grade >= 5) return 'good';
        if (grade >= 4) return 'medium';
        return 'bad';
    }
});
