document.addEventListener('DOMContentLoaded', function () {
    var isAuthenticated = true;
    var userRole = 'admin';

    if (!isAuthenticated) {
        alert("Vous devez être connecté pour accéder au calendrier.");
        return;
    }

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: "fr",
        timeZone: "Europe/Paris", // Affichage en fuseau horaire local
        selectable: userRole === 'admin', // Autoriser la sélection uniquement pour les admins
        editable: userRole === 'admin', // Autoriser l'édition uniquement pour les admins
        select: function (info) {
            if (userRole === 'admin') {
                var action = prompt('Entrez 1 pour ajouter un rendez-vous ou 2 pour bloquer le créneau :');
                var calendarApi = info.view.calendar;

                calendarApi.unselect();

                if (action === '1') {
                    var title = prompt('Entrez le nom du rendez-vous :');
                    if (title) {
                        var startDate = new Date(info.startStr);
                        var endDate = new Date(info.endStr);

                        // Supprimer l'heure des dates pour éviter les heures à 00h
                        startDate.setUTCHours(0, 0, 0, 0);
                        endDate.setUTCHours(0, 0, 0, 0);

                        // Convertir en format ISO pour FullCalendar
                        var startStr = startDate.toISOString().split('T')[0]; // Conserver uniquement la date
                        var endStr = endDate.toISOString().split('T')[0]; // Conserver uniquement la date

                        var event = {
                            title: title,
                            start: startStr,
                            end: endStr,
                            type: 'appointment' // Type d'événement pour différencier les rendez-vous des créneaux bloqués
                        };

                        saveEventToBackend(event, function(savedEvent) {
                            calendar.addEvent({
                                id: savedEvent.id,
                                title: savedEvent.title,
                                start: savedEvent.start,
                                end: savedEvent.end,
                                backgroundColor: 'blue', // Couleur pour les rendez-vous
                                borderColor: 'blue'
                            });
                        });
                    } else {
                        alert("Veuillez entrer un nom pour le rendez-vous.");
                    }
                } else if (action === '2') {
                    var event = {
                        title: 'Créneau bloqué',
                        start: info.startStr.split('T')[0], // Conserver uniquement la date
                        end: info.endStr.split('T')[0], // Conserver uniquement la date
                        type: 'blocked' // Type d'événement pour indiquer que le créneau est bloqué
                    };

                    saveEventToBackend(event, function(savedEvent) {
                        calendar.addEvent({
                            id: savedEvent.id,
                            title: savedEvent.title,
                            start: savedEvent.start,
                            end: savedEvent.end,
                            backgroundColor: 'red', // Couleur pour les créneaux bloqués
                            borderColor: 'red'
                        });
                    });
                }
            } else {
                alert("Vous n'avez pas les permissions nécessaires pour ajouter ou bloquer des créneaux.");
            }
        },
        eventClick: function (info) {
            if (userRole === 'admin') {
                if (confirm("Voulez-vous supprimer cet élément ?")) {
                    deleteEventFromBackend(info.event.id, function() {
                        info.event.remove();
                    });
                }
            } else {
                alert("Vous n'avez pas les permissions nécessaires pour supprimer des événements.");
            }
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('/api/meetings')
                .then(response => response.json())
                .then(data => {
                    // Convertir les dates UTC récupérées du backend en dates locales pour FullCalendar
                    data.forEach(event => {
                        event.start = convertUTCToLocalDate(event.start);
                        event.end = convertUTCToLocalDate(event.end);
                    });
                    successCallback(data);
                })
                .catch((error) => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
        }
    });

    calendar.render();

    function convertUTCToLocalDate(utcDateStr) {
        // Convertir la date UTC en date locale
        var utcDate = new Date(utcDateStr);
        var localDate = new Date(utcDate.getTime() - (utcDate.getTimezoneOffset() * 60000));
        return localDate.toISOString().split('T')[0]; // Conserver uniquement la date
    }

    function saveEventToBackend(event, callback) {
        console.log('Sending event to backend:', event);
        fetch('/api/meetings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(event)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from backend:', data);
            if (callback) {
                callback({
                    id: data.id,
                    title: event.title,
                    start: event.start,
                    end: event.end
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    function deleteEventFromBackend(eventId, callback) {
        console.log('Deleting event from backend with id:', eventId);
        fetch('/api/meetings/' + eventId, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from backend:', data);
            if (callback) {
                callback();
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
});
