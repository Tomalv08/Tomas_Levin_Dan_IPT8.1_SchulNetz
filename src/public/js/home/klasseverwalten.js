document.addEventListener("DOMContentLoaded", () => {
    loadStudentList();
    loadStudentOptions();  // Lade die Liste der verfügbaren Schüleroptionen für das Hinzufügen
});

function loadStudentList() {
    const token = localStorage.getItem('api_token');
    
    fetch('http://localhost:8000/api/class/list', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => {
        console.log('Response Status:', response.status); // Status-Code anzeigen
        if (!response.ok) {
            throw new Error(`HTTP-Fehler ${response.status}`);
        }
        return response.json(); // Versuche, die JSON-Antwort zu parsen
    })
    .then(data => {
        const studentList = document.getElementById('student-list');
        studentList.innerHTML = '';

        // Prüfen, ob die Daten in einem Array sind oder ob das Array in einer anderen Eigenschaft steckt
        const students = Array.isArray(data) ? data : data.students;

        // Fallback: Wenn students kein Array ist, Fehler anzeigen
        if (!Array.isArray(students)) {
            console.error('Erwartetes Array in der API-Antwort:', data);
            return;
        }

        students.forEach(student => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.name}</td>
                <td>${student.email}</td>
                <td><button class="delete-btn" onclick="removeStudent(${student.id})">Löschen</button></td>
            `;
            studentList.appendChild(row);
        });
    })
    .catch(error => console.error('Fehler beim Laden der Schüler:', error));
}

function loadStudentOptions() {
    const token = localStorage.getItem('api_token');

    fetch('http://localhost:8000/api/students', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP-Fehler ${response.status}`);
        }
        return response.json();
    })
    .then(students => {
        const studentSelect = document.getElementById('student-select');
        studentSelect.innerHTML = ''; // Alte Optionen löschen

        students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.id;
            option.textContent = `${student.name} (${student.email})`;
            studentSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Fehler beim Laden der Schülerliste:', error));
}

function toggleAddStudentForm() {
    const form = document.getElementById("student-form");
    form.classList.toggle("hidden");
}

function addStudent() {
    const token = localStorage.getItem('api_token');
    const studentId = document.getElementById('student-select').value;  // ID des ausgewählten Schülers
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!studentId) {
        alert("Bitte einen Schüler auswählen");
        return;
    }

    fetch('http://localhost:8000/api/class/assign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ student_ids: [studentId] }) // Übergebe die ID des ausgewählten Schülers
    })
    .then(response => {
        console.log('Response Status:', response.status); // Status-Code anzeigen
        if (!response.ok) {
            throw new Error(`HTTP-Fehler ${response.status}`);
        }
        return response.json(); // Versuche, die JSON-Antwort zu parsen
    })
    .then(data => {
        console.log('Daten:', data); // Die Antwortdaten anzeigen
        loadStudentList(); // Aktualisiert die Liste
        toggleAddStudentForm();  
    })
    .catch(error => {
        console.error('Fehler beim Hinzufügen des Schülers:', error);
    });
}

function removeStudent(studentId) {
    const token = localStorage.getItem('api_token');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://localhost:8000/api/class/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ student_ids: [studentId] })
    })
    .then(() => loadStudentList())
    .catch(error => console.error('Fehler beim Entfernen des Schülers:', error));
}

function filterStudents() {
    const filter = document.getElementById('filter-input').value.toLowerCase();
    const rows = document.querySelectorAll('#student-list tr');
    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        row.style.display = name.includes(filter) || email.includes(filter) ? '' : 'none';
    });
}
