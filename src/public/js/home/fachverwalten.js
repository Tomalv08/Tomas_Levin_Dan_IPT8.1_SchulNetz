const authToken = localStorage.getItem('api_token');
// Fächer abrufen und in die Tabelle einfügen
async function loadSubjects() {
    try {
        const response = await fetch('http://localhost:8000/api/subjects', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Content-Type': 'application/json'
            }
        });
        const subjects = await response.json();

        const table = document.getElementById('fach-list');
        table.innerHTML = ''; // Bestehende Zeilen löschen

        subjects.forEach(subject => {
            const newRow = table.insertRow();
            newRow.dataset.id = subject.id;

            const nameCell = newRow.insertCell(0);
            const typeCell = newRow.insertCell(1);
            const actionCell = newRow.insertCell(2);

            nameCell.textContent = subject.name;
            typeCell.textContent = subject.type;
            actionCell.innerHTML = `
                <button class="action-button edit-button" onclick="editSubject(this)">Bearbeiten</button>
                <button class="action-button delete-button" onclick="deleteSubject(${subject.id})">Löschen</button>
            `;
        });
    } catch (error) {
        console.error('Fehler beim Laden der Fächer:', error);
    }
}
// Fächer in der Tabelle filtern
function filterSubjects() {
    const input = document.querySelector('.filter-input');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#fach-list tr');

    rows.forEach(row => {
        const fachNameCell = row.cells[0];
        if (fachNameCell) {
            const fachNameText = fachNameCell.textContent || fachNameCell.innerText;
            row.style.display = fachNameText.toLowerCase().includes(filter) ? "" : "none";
        }
    });
}

// Neues Fach hinzufügen
async function addSubject() {
    const fachName = document.getElementById('new-fach-name').value;
    const fachType = document.getElementById('new-fach-type').value;

    if (fachName) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('http://localhost:8000/api/subjects', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name: fachName, type: fachType })
            });

            if (response.ok) {
                await loadSubjects(); // Tabelle neu laden
                document.getElementById('new-fach-name').value = '';
            } else {
                console.error('Fehler beim Hinzufügen des Fachs');
            }
        } catch (error) {
            console.error('Fehler beim Hinzufügen des Fachs:', error);
        }
    } else {
        alert("Bitte geben Sie einen Fachname ein.");
    }
}

// Fach bearbeiten
function editSubject(button) {
    const row = button.closest('tr');
    const fachName = row.cells[0].textContent;
    const fachType = row.cells[1].textContent;

    row.cells[0].innerHTML = `<input type="text" value="${fachName}" class="edit-input">`;
    row.cells[1].innerHTML = `
        <select class="edit-select">
            <option value="BM" ${fachType === 'BM' ? 'selected' : ''}>BM</option>
            <option value="Informatik" ${fachType === 'Informatik' ? 'selected' : ''}>Informatik</option>
        </select>
    `;
    button.textContent = "Speichern";
    button.onclick = function () {
        saveEdit(row, button);
    };
}

async function saveEdit(row, button) {
    const id = row.dataset.id;
    const newFachName = row.cells[0].querySelector('.edit-input').value;
    const newFachType = row.cells[1].querySelector('.edit-select').value;

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`http://localhost:8000/api/subjects/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ name: newFachName, type: newFachType })
        });

        if (response.ok) {
            row.cells[0].textContent = newFachName;
            row.cells[1].textContent = newFachType;
            button.textContent = "Bearbeiten";
            button.onclick = function () {
                editSubject(button);
            };
        } else {
            console.error('Fehler beim Speichern der Änderungen');
        }
    } catch (error) {
        console.error('Fehler beim Speichern der Änderungen:', error);
    }
}

// Fach löschen
async function deleteSubject(id) {
    if (confirm("Möchten Sie dieses Fach wirklich löschen?")) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`http://localhost:8000/api/subjects/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                await loadSubjects(); // Tabelle neu laden
            } else {
                console.error('Fehler beim Löschen des Fachs');
            }
        } catch (error) {
            console.error('Fehler beim Löschen des Fachs:', error);
        }
    }
}

// Initiale Daten laden
document.addEventListener('DOMContentLoaded', loadSubjects);