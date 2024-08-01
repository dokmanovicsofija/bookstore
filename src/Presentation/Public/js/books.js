/**
 * Initializes the page by setting up event listeners and loading books.
 */
document.addEventListener('DOMContentLoaded', function () {
    // Extract authorId from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const authorId = urlParams.get('id');

    /**
     * Creates and appends a back button to the page.
     */
    function createBackButton() {
        const container = document.querySelector('.container');

        const backButton = document.createElement('a');
        backButton.href = '/src';
        backButton.id = 'back-to-authors';
        backButton.className = 'back';
        backButton.textContent = 'Back to Authors';

        container.appendChild(backButton);
    }

    /**
     * Hides the back button if it exists.
     */
    function hideBackButton() {
        const backButton = document.getElementById('back-to-authors');
        if (backButton) {
            backButton.style.display = 'none';
        }
    }

    /**
     * Shows the back button if it exists.
     */
    function showBackButton() {
        const backButton = document.getElementById('back-to-authors');
        if (backButton) {
            backButton.style.display = 'block';
        }
    }

    /**
     * Creates the table header and the 'Add Book' button.
     */
    function createTableHeader() {
        const booksSection = document.getElementById('books-section');

        const header = document.createElement('h1');
        header.textContent = 'Books by Author';
        booksSection.appendChild(header);

        const table = document.createElement('table');
        table.id = 'books-table';

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        const headers = ['Book', 'Year', 'Actions'];
        headers.forEach(text => {
            const th = document.createElement('th');
            th.textContent = text;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        table.appendChild(tbody);

        booksSection.appendChild(table);

        const addButton = document.createElement('button');
        addButton.id = 'add-book-btn';
        addButton.textContent = 'Add Book';
        booksSection.appendChild(addButton);
    }

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

                    const titleCell = document.createElement('td');
                    titleCell.textContent = book.title;
                    bookRow.appendChild(titleCell);

                    const yearCell = document.createElement('td');
                    yearCell.textContent = book.year;
                    bookRow.appendChild(yearCell);

                    const actionsCell = document.createElement('td');
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'delete-btn';
                    deleteButton.dataset.id = book.id;
                    deleteButton.dataset.title = book.title;
                    deleteButton.textContent = 'Delete';
                    actionsCell.appendChild(deleteButton);
                    bookRow.appendChild(actionsCell);

                    bookTableBody.appendChild(bookRow);
                });
                addDeleteEventListeners();
            })
            .catch(error => console.error('Error fetching books:', error));
    }

    /**
     * Adds event listeners to delete buttons for each book.
     */
    function addDeleteEventListeners() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const bookId = this.getAttribute('data-id');
                const bookTitle = this.getAttribute('data-title');
                showDeleteConfirmation(bookId, bookTitle);
            });
        });
    }

    /**
     * Shows a confirmation dialog for deleting a book.
     * @param {string} bookId - The ID of the book to delete.
     * @param {string} bookTitle - The title of the book to delete.
     */
    function showDeleteConfirmation(bookId, bookTitle) {
        const booksSection = document.getElementById('books-section');
        booksSection.style.display = 'none';
        hideBackButton();

        const existingModal = document.getElementById('delete-confirmation');
        if (existingModal) {
            existingModal.remove();
        }

        const deleteConfirmation = document.createElement('div');
        deleteConfirmation.id = 'delete-confirmation';
        deleteConfirmation.className = 'modal';

        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        deleteConfirmation.appendChild(modalContent);

        const title = document.createElement('h2');
        title.textContent = 'Delete Book';
        modalContent.appendChild(title);

        const message = document.createElement('p');
        message.innerHTML = `Are you sure you want to delete the book '<span id="book-title">${bookTitle}</span>'?`;
        modalContent.appendChild(message);

        const confirmButton = document.createElement('button');
        confirmButton.id = 'confirm-delete';
        confirmButton.textContent = 'Delete';
        modalContent.appendChild(confirmButton);

        const cancelButton = document.createElement('button');
        cancelButton.id = 'cancel-delete';
        cancelButton.textContent = 'Cancel';
        modalContent.appendChild(cancelButton);

        document.body.appendChild(deleteConfirmation);

        document.getElementById('confirm-delete').addEventListener('click', function () {
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

        document.getElementById('cancel-delete').addEventListener('click', function () {
            document.body.removeChild(deleteConfirmation);
            booksSection.style.display = 'block';
            showBackButton();
        });
    }

    /**
     * Opens the form for adding a new book.
     */
    function openAddBookForm() {
        const booksSection = document.getElementById('books-section');
        booksSection.style.display = 'none';

        const addBookSection = document.createElement('div');
        addBookSection.id = 'add-book-section';

        const header = document.createElement('h2');
        header.textContent = 'Add a new book';
        addBookSection.appendChild(header);

        const form = document.createElement('form');
        form.id = 'add-book-form';

        const titleLabel = document.createElement('label');
        titleLabel.setAttribute('for', 'book-title');
        titleLabel.textContent = 'Book Title';
        form.appendChild(titleLabel);

        const titleInput = document.createElement('input');
        titleInput.type = 'text';
        titleInput.id = 'book-title';
        titleInput.placeholder = 'Book Title';
        titleInput.required = true;
        form.appendChild(titleInput);

        const yearLabel = document.createElement('label');
        yearLabel.setAttribute('for', 'book-year');
        yearLabel.textContent = 'Year';
        form.appendChild(yearLabel);

        const yearInput = document.createElement('input');
        yearInput.type = 'text';
        yearInput.id = 'book-year';
        yearInput.placeholder = 'Year';
        yearInput.required = true;
        form.appendChild(yearInput);

        const authorInput = document.createElement('input');
        authorInput.type = 'hidden';
        authorInput.id = 'author-id';
        authorInput.value = authorId;
        form.appendChild(authorInput);

        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.textContent = 'Add Book';
        form.appendChild(submitButton);

        const cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.id = 'cancel-add-book';
        cancelButton.textContent = 'Cancel';
        form.appendChild(cancelButton);

        addBookSection.appendChild(form);
        document.querySelector('.container').appendChild(addBookSection);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const title = document.getElementById('book-title').value;
            const year = document.getElementById('book-year').value;

            const newBook = {title, year, authorId};
            Ajax.post(`/books?authorId=${authorId}`, newBook)
                .then(response => {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    console.log('Book added:', response);
                    form.reset();
                    addBookSection.remove();
                    booksSection.style.display = 'block';
                    const bookRow = document.createElement('tr');
                    const titleCell = document.createElement('td');
                    titleCell.textContent = newBook.title;
                    bookRow.appendChild(titleCell);

                    const yearCell = document.createElement('td');
                    yearCell.textContent = newBook.year;
                    bookRow.appendChild(yearCell);

                    const actionsCell = document.createElement('td');
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'delete-btn';
                    deleteButton.dataset.id = response.id;
                    deleteButton.dataset.title = response.title;
                    deleteButton.textContent = 'Delete';
                    actionsCell.appendChild(deleteButton);
                    bookRow.appendChild(actionsCell);

                    document.querySelector('#books-table tbody').appendChild(bookRow);
                    addDeleteEventListeners();
                })
                .catch(error => console.error('Error adding book:', error));
        });

        // Handle cancel button click
        document.getElementById('cancel-add-book').addEventListener('click', function () {
            addBookSection.remove();
            booksSection.style.display = 'block';
        });
    }

    createTableHeader();
    loadBooks();
    createBackButton();

    // Add event listener for the 'Add Book' button
    document.getElementById('add-book-btn').addEventListener('click', openAddBookForm);

});