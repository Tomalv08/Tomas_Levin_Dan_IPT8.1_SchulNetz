async function fetchPromotionData() {
    const bmUrl = 'http://localhost:8000/api/promotion/check';
    const informatikUrl = 'http://localhost:8000/api/promotion/informatik';
    const token = localStorage.getItem('api_token');;  

    try {
        // Fetch BM Promotion Data
        const bmResponse = await fetch(bmUrl, {
            headers: { 'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json' 
                    }
        });
        const bmData = await bmResponse.json();

        // Fetch Informatik Promotion Data
        const informatikResponse = await fetch(informatikUrl, {
            headers: { 'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json' }
        });
        const informatikData = await informatikResponse.json();

        // Display Data
        displayPromotionData(bmData.students, 'bm-table');
        displayPromotionData(informatikData.students, 'informatik-table');
    } catch (error) {
        console.error('Error fetching promotion data:', error);
    }
}

function displayPromotionData(students, tableId) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    tableBody.innerHTML = ''; // Clear any existing data

    students.forEach(student => {
        const row = document.createElement('tr');

        let subjectsBelow4 = '';
        let insufficientGrades = '';
        let isPromoted = '';

        // Check if the data is for BM or Informatik and assign the correct values
        if (tableId === 'bm-table') {
            subjectsBelow4 = student.bmSubjectsBelow4;  // BM specific
            insufficientGrades = student.bmInsufficientGrades;
            isPromoted = student.isPromoted;
        } else if (tableId === 'informatik-table') {
            subjectsBelow4 = student.informatikSubjectsBelow4;  // Informatik specific
            insufficientGrades = student.insufficientGrades;
            isPromoted = student.isInformatikPromoted;
        }

        row.innerHTML = `
            <td>${student.student_name}</td>
            <td>${student.average || student.informatik_average}</td>
            <td>${subjectsBelow4}</td>
            <td>${insufficientGrades}</td>
            <td>${isPromoted ? 'Ja' : 'Nein'}</td>
        `;

        tableBody.appendChild(row);
    });
}

function filterPromotions() {
    const input = document.querySelector('.filter-input');
    const filter = input.value.toLowerCase();
    const tables = document.querySelectorAll('.promotions-table tbody');

    tables.forEach(table => {
        const rows = table.getElementsByTagName('tr');
        Array.from(rows).forEach(row => {
            const nameCell = row.cells[0];
            if (nameCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                row.style.display = nameText.toLowerCase().includes(filter) ? "" : "none";
            }
        });
    });
}



// Call the function to fetch and display data
fetchPromotionData();
