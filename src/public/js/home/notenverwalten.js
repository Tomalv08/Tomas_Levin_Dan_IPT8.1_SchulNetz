const API_BASE_URL = 'http://localhost:8000/api/grades';
const BEARER_TOKEN = localStorage.getItem('api_token');

// Funktion zum Abrufen aller Noten von der API
async function fetchGrades() {
    try {
        const response = await fetch(API_BASE_URL, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`,
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Fehler beim Abrufen der Noten: ${response.statusText}`);
        }

        const data = await response.json();
        console.log('API Antwort:', data); // Logge die Antwort, um die Struktur zu überprüfen
        
        // Überprüfe, ob "students" existiert und ein Array ist
        if (Array.isArray(data.students)) {
            populateGrades(data); // Stelle sicher, dass die komplette "data" übergeben wird
        } else {
            console.error("Ungültiges Datenformat: 'students' fehlt oder ist kein Array");
        }
    } catch (error) {
        console.error(error);
        alert('Es gab ein Problem beim Abrufen der Noten.');
    }
}

// Lädt die Schüler und Fächer in die Dropdown-Menüs
async function loadStudentsAndSubjects() {
    try {
        // Schülerdaten laden
        const studentsResponse = await fetch('http://localhost:8000/api/students', {
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`
            }
        });
        const students = await studentsResponse.json();

        const studentSelect = document.getElementById("new-user-id");
        students.forEach(student => {
            const option = document.createElement("option");
            option.value = student.id; // ID als Wert verwenden
            option.textContent = student.name; // Namen des Schülers anzeigen
            studentSelect.appendChild(option);
        });

        // Fächerdaten laden
        const subjectsResponse = await fetch('http://localhost:8000/api/subjects', {
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`
            }
        });
        const subjects = await subjectsResponse.json();

        const subjectSelect = document.getElementById("new-subject-id");
        subjects.forEach(subject => {
            const option = document.createElement("option");
            option.value = subject.id; // ID als Wert verwenden
            option.textContent = subject.name; // Namen des Fachs anzeigen
            subjectSelect.appendChild(option);
        });

    } catch (error) {
        console.error("Fehler beim Laden der Schüler oder Fächer:", error);
        alert("Es gab ein Problem beim Laden der Schüler- oder Fächer-Liste.");
    }
}

// Rufe die Funktion beim Laden der Seite auf
document.addEventListener("DOMContentLoaded", loadStudentsAndSubjects);


// Funktion zum Hinzufügen einer neuen Note
async function addNote() {
    const userIdElem = document.getElementById("new-user-id");
    const subjectIdElem = document.getElementById("new-subject-id");
    const gradeElem = document.getElementById("new-grade");
    const descriptionElem = document.getElementById("new-description");
    const weightElem = document.getElementById("new-weight");

    if (!userIdElem || !subjectIdElem || !gradeElem || !descriptionElem || !weightElem) {
        console.error("Ein oder mehrere Eingabefelder konnten nicht gefunden werden.");
        alert("Ein oder mehrere Eingabefelder fehlen.");
        return;
    }

    const userId = parseInt(userIdElem.value);
    const subjectId = parseInt(subjectIdElem.value);
    const grade = parseFloat(gradeElem.value);
    const description = descriptionElem.value;
    const weight = parseInt(weightElem.value);

    const newGrade = {
        user_id: userId,
        subject_id: subjectId,
        grade: grade,
        description: description,
        weight: weight
    };

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        const response = await fetch(API_BASE_URL, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`,
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(newGrade)
        });

        if (!response.ok) {
            throw new Error(`Fehler beim Hinzufügen der Note: ${response.statusText}`);
        }

        const createdGrade = await response.json();
        appendGradeToDOM(createdGrade);
        clearInputFields();
    } catch (error) {
        console.error(error);
        alert('Es gab ein Problem beim Hinzufügen der Note.');
    }
}

// Funktion, um eine neue Note im DOM anzuzeigen
function appendGradeToDOM(grade) {
    const noteListContainer = document.getElementById("note-list-container");

    // Neues Element für die Note erstellen
    const gradeElement = document.createElement("div");
    gradeElement.classList.add("grade-item");
    gradeElement.innerHTML = `
        <p><strong>Benutzer ID:</strong> ${grade.user_id}</p>
        <p><strong>Fach ID:</strong> ${grade.subject_id}</p>
        <p><strong>Note:</strong> ${grade.grade}</p>
        <p><strong>Beschreibung:</strong> ${grade.description}</p>
        <p><strong>Gewichtung:</strong> ${grade.weight}</p>
    `;

    // Note zum Container hinzufügen
    noteListContainer.appendChild(gradeElement);
}

// Funktion zum Aktualisieren einer Note
async function updateNote(gradeId, updatedData) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        const response = await fetch(`${API_BASE_URL}/${gradeId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`,
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(updatedData)
        });

        if (!response.ok) {
            throw new Error(`Fehler beim Aktualisieren der Note: ${response.statusText}`);
        }

        const updatedGrade = await response.json();
        updateGradeInDOM(updatedGrade);
    } catch (error) {
        console.error(error);
        alert('Es gab ein Problem beim Aktualisieren der Note.');
    }
}

function updateGradeInDOM(updatedGrade) {
    // Find the table row that needs to be updated
    const row = document.querySelector(`tr[data-grade-id="${updatedGrade.id}"]`);
    
    if (row) {
        // Update the table cells with the new data
        row.querySelector(".grade-cell").textContent = updatedGrade.grade;
        row.querySelector("td:nth-child(2)").textContent = updatedGrade.description;
        row.querySelector("td:nth-child(3)").textContent = updatedGrade.weight;
    }
}


// Funktion zum Löschen einer Note
async function deleteNoteFromAPI(gradeId, button) {
    if (!confirm('Bist du sicher, dass du diese Note löschen möchtest?')) {
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        const response = await fetch(`${API_BASE_URL}/${gradeId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${BEARER_TOKEN}`,
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Zusätzliche Fehlerausgabe, um mehr Details zu bekommen
        const responseText = await response.text();  // Hole den Text der Antwort
        if (!response.ok) {
            throw new Error(`Fehler beim Löschen der Note: ${responseText}`);
        }

        const row = button.closest("tr");
        row.remove();
    } catch (error) {
        console.error('Fehler beim Löschen:', error);
        alert('Es gab ein Problem beim Löschen der Note: ' + error.message);
    }
}


// Funktion zum Bearbeiten einer Note
async function handleEditNote(gradeId, button) {
    const row = button.closest("tr");
    const gradeCell = row.querySelector(".grade-cell");
    const descriptionCell = row.querySelector("td:nth-child(2)");
    const weightCell = row.querySelector("td:nth-child(3)");

    const newGrade = prompt("Neue Note:", gradeCell.dataset.grade);
    const newDescription = prompt("Neue Beschreibung:", descriptionCell.textContent);
    const newWeight = prompt("Neue Gewichtung:", weightCell.textContent);

    if (newGrade !== null && newDescription !== null && newWeight !== null) {
        const updatedData = {
            grade: parseFloat(newGrade),
            description: newDescription,
            weight: parseInt(newWeight)
        };

        await updateNote(gradeId, updatedData);
    }
}

// Funktion zum Leeren der Eingabefelder
function clearInputFields() {
    document.getElementById("new-user-id").value = '';
    document.getElementById("new-subject-id").value = '';
    document.getElementById("new-grade").value = '';
    document.getElementById("new-description").value = '';
    document.getElementById("new-weight").value = '';
}

// Deine bestehenden Funktionen bleiben unverändert
function filterNotes() {
    const searchTerm = document.getElementById("search-name").value.toLowerCase();
    const students = document.getElementsByClassName("student-notes");

    for (let student of students) {
        const studentName = student.querySelector("h3").textContent.toLowerCase();
        if (studentName.includes(searchTerm)) {
            student.style.display = "block";
        } else {
            student.style.display = "none";
        }
    }
}

function setGradeColor(cell, grade) {
    if (grade < 4) {
        cell.style.color = "red";
    } else if (grade >= 4 && grade < 5) {
        cell.style.color = "orange";
    } else {
        cell.style.color = "green";
    }
}

// Funktion zum Befüllen des DOM mit den abgerufenen Noten
// Funktion zum Befüllen des DOM mit den abgerufenen Noten
// Funktion zum Befüllen des DOM mit den abgerufenen Noten
function populateGrades(data) {
    const noteListContainer = document.getElementById("note-list-container");
    noteListContainer.innerHTML = ''; // Leere den Container

    if (!Array.isArray(data.students)) {
        console.error("Ungültiges Datenformat: 'students' fehlt oder ist kein Array");
        return;
    }

    data.students.forEach(student => {
        let studentNotes = document.getElementById(`student-${student.student_name}`);
        if (!studentNotes) {
            studentNotes = document.createElement("div");
            studentNotes.classList.add("student-notes");
            studentNotes.id = `student-${student.student_name}`;

            const studentHeader = document.createElement("h3");
            studentHeader.textContent = `Student: ${student.student_name}`;
            studentNotes.appendChild(studentHeader);

            const table = document.createElement("table");
            table.classList.add("note-table");

            const tableHeader = document.createElement("thead");
            const headerRow = document.createElement("tr");
            const headers = ["Note", "Beschreibung", "Gewichtung", "Fach", "Typ", "Aktionen"];
            headers.forEach(header => {
                const th = document.createElement("th");
                th.textContent = header;
                headerRow.appendChild(th);
            });
            tableHeader.appendChild(headerRow);
            table.appendChild(tableHeader);

            const tableBody = document.createElement("tbody");
            table.appendChild(tableBody);

            studentNotes.appendChild(table);
            noteListContainer.appendChild(studentNotes);
        }

        const tableBody = studentNotes.querySelector("tbody");
        
        student.grades.forEach(grade => {
            const row = document.createElement("tr");
            row.dataset.gradeId = grade.id; // Speichere die Grade-ID für spätere Referenzen

            const gradeCell = document.createElement("td");
            gradeCell.classList.add("grade-cell");
            gradeCell.textContent = grade.grade;
            gradeCell.dataset.grade = grade.grade;
            setGradeColor(gradeCell, grade.grade);
            row.appendChild(gradeCell);

            const descriptionCell = document.createElement("td");
            descriptionCell.textContent = grade.description;
            row.appendChild(descriptionCell);

            const weightCell = document.createElement("td");
            weightCell.textContent = grade.weight;
            row.appendChild(weightCell);

            const subjectCell = document.createElement("td");
            subjectCell.textContent = grade.subject.name; // Fachname anzeigen
            row.appendChild(subjectCell);

            const typeCell = document.createElement("td");
            typeCell.textContent = grade.subject.type || 'Standard'; // Typ, falls vorhanden
            row.appendChild(typeCell);

            const actionsCell = document.createElement("td");
            actionsCell.innerHTML = `
                <button class="action-button edit-button" onclick="handleEditNote(${grade.id}, this)">Bearbeiten</button>
                <button class="action-button delete-button" onclick="deleteNoteFromAPI(${grade.id}, this)">Löschen</button>
            `;
            row.appendChild(actionsCell);

            tableBody.appendChild(row);
        });
    });
}





// Event Listener, um beim Laden der Seite die Noten zu laden
document.addEventListener("DOMContentLoaded", fetchGrades);
