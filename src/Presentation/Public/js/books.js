/**
 * Initializes the page by setting up event listeners and loading books.
 */
document.addEventListener('DOMContentLoaded', function() {

    // Get the author ID from the input field.
    const authorId = document.getElementById('author-id').value;

    /**
     * Loads the list of books for the given author and displays them in a table.
     */
    function loadBooks() {
        console.log(`Loading books for authorId=${authorId}`);
        Ajax.get(`/books?authorId=${authorId}`)
            .then(response => {
                console.log('Response from server:', response);

                const books = response.books;
                if (!Array.isArray(books)) {
                    console.error('Expected an array of books but got:', books);
                    throw new Error('Invalid response format');
                }

                const bookTableBody = document.querySelector('#books-table tbody');
                bookTableBody.innerHTML = '';
                books.forEach(book => {
                    const bookRow = document.createElement('tr');
                    bookRow.innerHTML = `
                        <td>${book.title}</td>
                        <td>${book.year}</td>
                        <td>
                            <button class="delete-btn" data-id="${book.id}" data-title="${book.title}">Delete</button>
                        </td>
                    `;
                    bookTableBody.appendChild(bookRow);
                });
                addDeleteEventListeners();
            })
            .catch(error => console.error('Error fetching books:', error));
    }

    /**
     * Adds event listeners to delete buttons in the books table.
     */
    function addDeleteEventListeners() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookId = this.getAttribute('data-id');
                const bookTitle = this.getAttribute('data-title');
                showDeleteConfirmation(bookId, bookTitle);
            });
        });
    }

    /**
     * Shows a confirmation modal for deleting a book.
     *
     * @param {string} bookId - The ID of the book to delete.
     * @param {string} bookTitle - The title of the book to delete.
     */
    function showDeleteConfirmation(bookId, bookTitle) {
        const booksSection = document.getElementById('books-section');
        booksSection.style.display = 'none';

        const existingModal = document.getElementById('delete-confirmation');
        if (existingModal) {
            existingModal.remove();
        }

        const deleteConfirmation = document.createElement('div');
        deleteConfirmation.id = 'delete-confirmation';
        deleteConfirmation.className = 'modal';
        deleteConfirmation.innerHTML = `
        <div class="modal-content">
            <h2>Delete Book</h2>
            <p>Are you sure you want to delete the book '<span id="book-title">${bookTitle}</span>'?</p>
            <button id="confirm-delete">Delete</button>
            <button id="cancel-delete">Cancel</button>
        </div>
    `;
        document.body.appendChild(deleteConfirmation);

        document.getElementById('confirm-delete').addEventListener('click', function() {
            Ajax.delete(`/books/delete?bookId=${bookId}`)
                .then(response => {
                    if (response === null) {
                        console.log('Book deleted successfully');
                    } else {
                        console.log('Unexpected response:', response);
                    }
                    document.body.removeChild(deleteConfirmation);
                    booksSection.style.display = 'block';
                    loadBooks();
                })
                .catch(error => console.error('Error deleting book:', error));
        });

        document.getElementById('cancel-delete').addEventListener('click', function() {
            document.body.removeChild(deleteConfirmation);
            booksSection.style.display = 'block';
        });
    }

    /**
     * Opens a form to add a new book and handles the form submission.
     */
    document.getElementById('add-book-btn').addEventListener('click', function() {
        const booksSection = document.getElementById('books-section');
        booksSection.style.display = 'none';

        const addBookSection = document.createElement('div');
        addBookSection.id = 'add-book-section';
        addBookSection.innerHTML = `
            <h2>Add a new book</h2>
            <form id="add-book-form">
                <label for="book-title">Book Title</label>
                <input type="text" id="book-title" placeholder="Book Title" required>

                <label for="book-year">Year</label>
                <input type="text" id="book-year" placeholder="Year" required>

                <input type="hidden" id="author-id" value="${authorId}">
                <button type="submit">Add Book</button>
                <button type="button" id="cancel-add-book">Cancel</button>
            </form>
        `;
        document.querySelector('.container').appendChild(addBookSection);

        document.getElementById('add-book-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const title = document.getElementById('book-title').value;
            const year = document.getElementById('book-year').value;

            const newBook = { title, year, authorId };
            Ajax.post(`/books?authorId=${authorId}`, newBook)
                .then(response => {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    console.log('Book added:', response);
                    document.getElementById('add-book-form').reset();
                    addBookSection.remove();
                    booksSection.style.display = 'block';
                    const bookRow = document.createElement('tr');
                    bookRow.innerHTML = `
                        <td>${newBook.title}</td>
                        <td>${newBook.year}</td>
                        <td>
                            <button class="delete-btn" data-id="${response.id}" data-title="${response.title}">Delete</button>
                        </td>
                    `;
                    document.querySelector('#books-table tbody').appendChild(bookRow);
                    addDeleteEventListeners();
                })
                .catch(error => console.error('Error adding book:', error));
        });

        document.getElementById('cancel-add-book').addEventListener('click', function() {
            addBookSection.remove();
            booksSection.style.display = 'block';
        });
    });

    // Load books for the given author when the page is initialized.
    loadBooks();

});
