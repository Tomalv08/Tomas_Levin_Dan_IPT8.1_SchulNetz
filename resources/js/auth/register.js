document.getElementById('register-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ name, email, password, password_confirmation }),
        });

        if (response.ok) {
            window.location.href = '/login';  // Weiterleitung zur Login-Seite nach erfolgreicher Registrierung
        } else {
            const errorData = await response.json();
            document.getElementById('error-message').textContent = Object.values(errorData).join(', ');
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred. Please try again.';
    }
});
