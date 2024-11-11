document.getElementById('login-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Reset previous error messages
    document.getElementById('error-message').textContent = '';

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ email, password }),
        });

        if (response.ok) {
            const data = await response.json();
            localStorage.setItem('token', data.token);
            window.location.href = '/home';  // Weiterleitung zur Startseite
        } else {
            const errorData = await response.json();
            // Zeige Fehler an
            document.getElementById('error-message').textContent = errorData.error || 'Login fehlgeschlagen';
            document.getElementById('error-message').style.color = 'red';
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'Ein Fehler ist aufgetreten. Bitte versuche es später erneut.';
        document.getElementById('error-message').style.color = 'red';
    }
});
