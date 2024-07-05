document.addEventListener('DOMContentLoaded', function () {
    // Simuler une vérification d'authentification et de rôle
    var isAuthenticated = true; // Cette variable devrait être définie en fonction de l'état de connexion réel de l'utilisateur
    var userRole = 'admin'; // Cette variable devrait être définie en fonction du rôle réel de l'utilisateur

    if (!isAuthenticated) {
        alert("Vous devez être connecté pour accéder au calendrier.");
        return;
    }

    if (userRole !== 'admin') {
        alert("Vous n'avez pas les permissions nécessaires pour accéder au calendrier.");
        return;
    }

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: "fr",
        timeZone: "Europe/Paris",
        selectable: true,
        editable: true,
        select: function (info) {
            var action = prompt('Entrez 1 pour ajouter un événement ou 2 pour bloquer le créneau:');
            var calendarApi = info.view.calendar;

            calendarApi.unselect(); // clear date selection

            if (action === '1') {
                var title = prompt('Entrer un rendez-vous :');
                if (title) {
                    calendarApi.addEvent({
                        title: title,
                        start: info.startStr,
                        end: info.endStr,
                        allDay: info.allDay
                    });
                }
            } else if (action === '2') {
                var reason = prompt('Raison pour bloquer ce créneau :');
                if (reason) {
                    calendarApi.addEvent({
                        title: 'Pas disponible: ' + reason,
                        start: info.startStr,
                        end: info.endStr,
                        allDay: info.allDay,
                        backgroundColor: 'red', // Indique visuellement que le créneau est bloqué
                        borderColor: 'red'
                    });
                }
            }
        },
        eventClick: function (info) {
            if (confirm("Voulez-vous supprimer cet élément?")) {
                info.event.remove();
            }
        }
    });

    calendar.render();
});