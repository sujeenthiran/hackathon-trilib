document.addEventListener('DOMContentLoaded', function() {
    const eventForm = document.getElementById('eventForm');
    const eventList = document.getElementById('eventList');

    function loadEvents() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'recuperer_evenements.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Succès de la requête
                eventList.innerHTML = xhr.responseText;
            } else {
                // Le serveur a retourné une erreur
                console.error('Erreur lors de la récupération des événements');
            }
        };

        xhr.onerror = function() {
            console.error('Erreur réseau lors de la récupération des événements');
        };

        xhr.send();
    }

    loadEvents();

    eventForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const eventName = document.getElementById('eventName').value;
        const eventLocation = document.getElementById('eventLocation').value;
        const eventDate = document.getElementById('eventDate').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajouter_evenement.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Succès de la requête
                console.log('Événement ajouté avec succès!');
                loadEvents(); // Charger à nouveau les événements après l'ajout
            } else {
                // Le serveur a retourné une erreur
                console.error('Erreur lors de l\'ajout de l\'événement');
            }
        };

        xhr.onerror = function() {
            console.error('Erreur réseau lors de l\'envoi de la requête');
        };

        const params = `nom=${eventName}&lieu=${eventLocation}&date=${eventDate}`;
        xhr.send(params);
    });
});
