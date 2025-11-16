// ==================== GENERATE TO-DO LIST (New - with Save & Checkbox for show page) ====================
function generateTodoList(noteId) {
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '⏳ Generating...';

    fetch(`/notes/${noteId}/generate-todo`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.message);
        } else {
            displayTodoList(data.todo, noteId);
            alert('✅ To-Do List berhasil dibuat dan disimpan!');
        }
        button.disabled = false;
        button.innerHTML = originalText;
    })
    .catch(error => {
        alert('Terjadi kesalahan: ' + error);
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function displayTodoList(todos, noteId) {
    const container = document.getElementById('todoListContainer');
    const itemsDiv = document.getElementById('todoItems');
    
    if (!container || !itemsDiv) return;
    
    itemsDiv.innerHTML = '';
    
    todos.forEach((todo, index) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = `todo-item ${todo.completed ? 'completed' : ''}`;
        
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'todo-checkbox';
        checkbox.checked = todo.completed;
        checkbox.addEventListener('change', function() {
            updateTodoStatus(noteId, index, this.checked, this);
        });
        
        const textSpan = document.createElement('span');
        textSpan.className = 'todo-text';
        textSpan.textContent = todo.text;
        
        itemDiv.appendChild(checkbox);
        itemDiv.appendChild(textSpan);
        itemsDiv.appendChild(itemDiv);
    });
    
    container.style.display = 'block';
}

function updateTodoStatus(noteId, index, completed, checkboxElement) {
    console.log('Updating todo:', noteId, index, completed);
    
    const todoItem = checkboxElement.closest('.todo-item');
    
    fetch(`/notes/${noteId}/update-todo-item`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            index: index, 
            completed: completed 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data);
        
        if (!data.error) {
            if (completed) {
                todoItem.classList.add('completed');
            } else {
                todoItem.classList.remove('completed');
            }
            console.log('Status updated successfully');
        } else {
            alert('Error: ' + data.message);
            checkboxElement.checked = !completed;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal update status: ' + error.message);
        checkboxElement.checked = !completed;
    });
}