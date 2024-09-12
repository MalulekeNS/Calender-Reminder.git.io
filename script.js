document.addEventListener('DOMContentLoaded', () => {
    const calendar = document.getElementById('calendar');
    const form = document.getElementById('class-form');
    const subjectInput = document.getElementById('subject');
    const timeInput = document.getElementById('time');
    const studentsInput = document.getElementById('students');

    let reminders = [];

    // Function to render the calendar with reminders
    function renderCalendar() {
        calendar.innerHTML = '';

        reminders.forEach(reminder => {
            const reminderElement = document.createElement('div');
            reminderElement.className = 'reminder';
            reminderElement.style.border = '1px solid red';
            reminderElement.style.padding = '10px';
            reminderElement.style.marginBottom = '10px';

            reminderElement.innerHTML = `
                <strong>${reminder.subject}</strong><br>
                Time: ${reminder.time}<br>
                Students: ${reminder.students}
            `;

            calendar.appendChild(reminderElement);
        });
    }

    // Function to load reminders from the server
    function loadReminders() {
        fetch('load_events.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    reminders = data.reminders || [];
                    renderCalendar();
                } else {
                    alert('Error loading reminders: ' + data.message);
                }
            })
            .catch(error => console.error('Error fetching reminders:', error));
    }

    // Form submission event handler
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const newReminder = {
            subject: subjectInput.value,
            time: timeInput.value,
            students: studentsInput.value
        };

        // Send the new reminder to the PHP backend
        fetch('add_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newReminder)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Add the server-generated ID to the new reminder
                newReminder.id = data.id; 
                reminders.push(newReminder);
                renderCalendar();
                form.reset();
            } else {
                alert('Error saving reminder: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the reminder');
        });
    });

    // Load reminders on page load
    loadReminders();
});
// Save settings to the PHP backend
document.getElementById('save-settings').addEventListener('click', function() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const theme = document.getElementById('theme').value;

    const settings = {
        username: username,
        email: email,
        password: password,
        theme: theme
    };

    fetch('save_settings.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(settings)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Settings saved!');
        } else {
            alert('Error saving settings: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the settings');
    });
});

// Load settings from the PHP backend
function loadSettings() {
    fetch('load_settings.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('username').value = data.settings.username || '';
            document.getElementById('email').value = data.settings.email || '';
            document.getElementById('theme').value = data.settings.theme || 'black-red';
        } else {
            alert('Error loading settings: ' + data.message);
        }
    })
    .catch(error => console.error('Error fetching settings:', error));
}

document.addEventListener('DOMContentLoaded', loadSettings);
