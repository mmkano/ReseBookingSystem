document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.like-btn').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            let form = button.closest('form');
            if (!form) {
                console.error('Form not found for button:', button);
                return;
            }
            let action = form.getAttribute('action');
            let token = form.querySelector('input[name="_token"]').value;

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.text())
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (error) {
                    console.error('JSON Parse Error:', error);
                    return;
                }
                if (data.status === 'liked') {
                    button.classList.add('liked');
                    button.querySelector('i').classList.remove('far');
                    button.querySelector('i').classList.add('fas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
