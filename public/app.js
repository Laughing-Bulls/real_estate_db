document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('viewingForm');
    form.onsubmit = function (e) {
        e.preventDefault(); // Prevent the default form submission

        const viewingId = document.getElementById('viewing_id').value;
        const url = `http://localhost:3000/getviewing?id=${viewingId}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        const para = document.createElement('p');
                        para.textContent = `Viewing ID: ${item.viewing_id}, Details: ${item.details}`;
                        resultDiv.appendChild(para);
                    });
                } else {
                    resultDiv.textContent = 'No data found for this ID.';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById('result').textContent = 'Failed to load data.';
            });
    };
});
