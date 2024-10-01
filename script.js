
document.getElementById('addStudentBtn').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('studentForm').reset(); // Clear the form
    document.getElementById('modalTitle').innerText = 'Add New Student'; // Set title
    document.getElementById('studentId').value = ''; // Clear student ID
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'none';
});

// Handle inline editing and populate modal
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id');
        const name = row.querySelector('.name').innerText;
        const subject = row.querySelector('.subject').innerText;
        const marks = row.querySelector('.marks').innerText;

        // Populate the modal with existing student data
        document.getElementById('studentName').value = name;
        document.getElementById('studentSubject').value = subject;
        document.getElementById('studentMarks').value = marks;
        document.getElementById('studentId').value = id; // Set student ID for updating

        document.getElementById('modal').style.display = 'block'; // Show modal
        document.getElementById('modalTitle').innerText = 'Edit Student'; // Set title
    });
});

// Handle delete functionality
document.querySelectorAll('.deleteBtn').forEach(button => {
    button.addEventListener('click', function() {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id');
        // Handle delete logic here (e.g., send an AJAX request)
        console.log(`Delete student ID: ${id}`);
        row.remove(); // Remove row from UI for demonstration
    });
});

