document.getElementById('logout-button').addEventListener('click', async function(event) {
    event.preventDefault();

    try {
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        });

        if (response.ok) {
            localStorage.removeItem('token');
            window.location.href = '/login';  // Weiterleitung zur Login-Seite nach dem Logout
        } else {
            document.getElementById('error-message').textContent = 'Logout failed. Please try again.';
        }
    } catch (error) {
        document.getElementById('error-message').textContent = 'An error occurred. Please try again.';
    }
});
