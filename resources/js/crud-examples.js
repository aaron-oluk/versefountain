// Example: Using CRUD Managers in your pages

// ============================================
// 1. BOOKS CRUD OPERATIONS
// ============================================

// Initialize manager
const bookManager = new BookManager();

// Fetch all books with filters
async function loadBooks() {
    const books = await bookManager.fetchAll({ genre: 'Fiction', approved: true });
    renderBooks(books);
}

// Fetch single book
async function loadBook(id) {
    const book = await bookManager.fetchOne(id);
    if (book) {
        displayBookDetails(book);
    }
}

// Create new book
async function createBook() {
    const bookData = {
        title: 'The Great Gatsby',
        author: 'F. Scott Fitzgerald',
        genre: 'Fiction',
        description: 'A classic American novel...',
        coverImage: 'https://example.com/cover.jpg'
    };
    
    const book = await bookManager.create(bookData);
    if (book) {
        console.log('Book created:', book);
        // Redirect or update UI
    }
}

// Update existing book
async function updateBook(id) {
    const updates = {
        description: 'Updated description...',
        genre: 'Classic Fiction'
    };
    
    const book = await bookManager.update(id, updates);
    if (book) {
        console.log('Book updated:', book);
    }
}

// Delete book
async function deleteBook(id) {
    if (confirm('Are you sure you want to delete this book?')) {
        const success = await bookManager.delete(id);
        if (success) {
            // Remove from UI or redirect
            window.location.href = '/books';
        }
    }
}

// Upload cover image
async function uploadBookCover(bookId, fileInput) {
    const file = fileInput.files[0];
    if (file) {
        const coverUrl = await bookManager.uploadCover(bookId, file);
        if (coverUrl) {
            console.log('Cover uploaded:', coverUrl);
            // Update preview
        }
    }
}

// ============================================
// 2. EVENTS CRUD OPERATIONS
// ============================================

// Initialize manager
const eventManager = new EventManager();

// Fetch all events
async function loadEvents() {
    const events = await eventManager.fetchAll({ category: 'poetry' });
    renderEvents(events);
}

// Create new event
async function createEvent() {
    const eventData = {
        name: 'Poetry Night',
        date: '2026-02-15',
        time: '19:00',
        location: 'Downtown Library',
        category: 'poetry',
        price: 15.00,
        capacity: 50,
        description: 'Join us for an evening of poetry...'
    };
    
    const event = await eventManager.create(eventData);
    if (event) {
        console.log('Event created:', event);
    }
}

// Update event
async function updateEvent(id) {
    const updates = {
        capacity: 75,
        price: 20.00
    };
    
    const event = await eventManager.update(id, updates);
    if (event) {
        console.log('Event updated:', event);
    }
}

// Register for event
async function registerForEvent(eventId) {
    const result = await eventManager.register(eventId);
    if (result) {
        // Update UI to show registered status
        document.querySelector('[data-register-btn]').textContent = 'Registered';
        document.querySelector('[data-register-btn]').disabled = true;
    }
}

// Unregister from event
async function unregisterFromEvent(eventId) {
    if (confirm('Are you sure you want to unregister?')) {
        const success = await eventManager.unregister(eventId);
        if (success) {
            // Update UI
            document.querySelector('[data-register-btn]').textContent = 'Register';
            document.querySelector('[data-register-btn]').disabled = false;
        }
    }
}

// Check registration status
async function checkRegistrationStatus(eventId) {
    const status = await eventManager.getRegistrationStatus(eventId);
    if (status) {
        updateRegisterButton(status.isRegistered);
    }
}

// ============================================
// 3. ACADEMIC RESOURCES CRUD OPERATIONS
// ============================================

// Initialize manager
const resourceManager = new AcademicResourceManager();

// Fetch all resources
async function loadResources() {
    const resources = await resourceManager.fetchAll({ 
        type: 'research_paper',
        subject: 'Literature' 
    });
    renderResources(resources);
}

// Create new resource
async function createResource() {
    const resourceData = {
        title: 'Literary Analysis of Modern Poetry',
        type: 'research_paper',
        author: 'Dr. Jane Smith',
        subject: 'Literature',
        language: 'English',
        description: 'An in-depth analysis...'
    };
    
    const resource = await resourceManager.create(resourceData);
    if (resource) {
        console.log('Resource created:', resource);
    }
}

// Update resource
async function updateResource(id) {
    const updates = {
        description: 'Updated description with new findings...',
        language: 'English, Spanish'
    };
    
    const resource = await resourceManager.update(id, updates);
    if (resource) {
        console.log('Resource updated:', resource);
    }
}

// Delete resource
async function deleteResource(id) {
    if (confirm('Are you sure you want to delete this resource?')) {
        const success = await resourceManager.delete(id);
        if (success) {
            window.location.href = '/academics';
        }
    }
}

// Upload resource file
async function uploadResourceFile(resourceId, fileInput) {
    const file = fileInput.files[0];
    if (file) {
        const fileUrl = await resourceManager.uploadFile(resourceId, file);
        if (fileUrl) {
            console.log('File uploaded:', fileUrl);
        }
    }
}

// ============================================
// 4. USING CRUD FORM HANDLER
// ============================================

// Example: Generic form with validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#my-crud-form');
    
    if (form) {
        const formHandler = new CRUDFormHandler(form, {
            // Custom validation
            validate(formData) {
                if (!formData.title || formData.title.length < 3) {
                    window.utils.showToast('Title must be at least 3 characters', 'error');
                    return false;
                }
                return true;
            },
            
            // Handle submission
            async onSubmit(formData) {
                // Determine which manager to use based on form type
                const formType = form.dataset.formType;
                
                switch(formType) {
                    case 'book':
                        return await bookManager.create(formData);
                    case 'event':
                        return await eventManager.create(formData);
                    case 'resource':
                        return await resourceManager.create(formData);
                    default:
                        throw new Error('Unknown form type');
                }
            },
            
            // Success callback
            onSuccess(result) {
                const formType = form.dataset.formType;
                window.utils.showToast(`${formType} created successfully!`, 'success');
                
                // Redirect based on type
                setTimeout(() => {
                    window.location.href = `/${formType}s`;
                }, 1500);
            },
            
            // Error callback
            onError(error) {
                console.error('Form error:', error);
                window.utils.showToast(error.message || 'An error occurred', 'error');
            }
        });
    }
});

// ============================================
// 5. EXAMPLE: DELETE BUTTON WITH CONFIRMATION
// ============================================

function setupDeleteButtons() {
    document.querySelectorAll('[data-delete-book]').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.deleteBook;
            const bookTitle = this.dataset.bookTitle;
            
            if (confirm(`Are you sure you want to delete "${bookTitle}"?`)) {
                const success = await bookManager.delete(bookId);
                if (success) {
                    this.closest('[data-book-item]').remove();
                }
            }
        });
    });
}

// ============================================
// 6. EXAMPLE: INLINE EDIT FUNCTIONALITY
// ============================================

function setupInlineEdit() {
    document.querySelectorAll('[data-edit-book]').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.editBook;
            const container = this.closest('[data-book-item]');
            
            // Get current values
            const titleEl = container.querySelector('[data-book-title]');
            const descEl = container.querySelector('[data-book-description]');
            
            const currentTitle = titleEl.textContent;
            const currentDesc = descEl.textContent;
            
            // Create inline form
            titleEl.innerHTML = `<input type="text" value="${currentTitle}" class="w-full px-2 py-1 border rounded">`;
            descEl.innerHTML = `<textarea class="w-full px-2 py-1 border rounded">${currentDesc}</textarea>`;
            
            // Show save/cancel buttons
            this.style.display = 'none';
            container.querySelector('[data-save-book]').style.display = 'inline-block';
            container.querySelector('[data-cancel-edit]').style.display = 'inline-block';
        });
    });
    
    document.querySelectorAll('[data-save-book]').forEach(btn => {
        btn.addEventListener('click', async function() {
            const bookId = this.dataset.saveBook;
            const container = this.closest('[data-book-item]');
            
            const titleInput = container.querySelector('[data-book-title] input');
            const descTextarea = container.querySelector('[data-book-description] textarea');
            
            const updates = {
                title: titleInput.value,
                description: descTextarea.value
            };
            
            const book = await bookManager.update(bookId, updates);
            if (book) {
                // Update display
                const titleEl = container.querySelector('[data-book-title]');
                const descEl = container.querySelector('[data-book-description]');
                
                titleEl.textContent = book.title;
                descEl.textContent = book.description;
                
                // Toggle buttons
                this.style.display = 'none';
                container.querySelector('[data-cancel-edit]').style.display = 'none';
                container.querySelector('[data-edit-book]').style.display = 'inline-block';
            }
        });
    });
}

// ============================================
// 7. EXAMPLE: SEARCH/FILTER WITH DEBOUNCE
// ============================================

function setupSearch() {
    const searchInput = document.querySelector('[data-search-books]');
    if (!searchInput) return;
    
    const debouncedSearch = window.utils.debounce(async (query) => {
        const books = await bookManager.fetchAll({ search: query });
        renderBooks(books);
    }, 300);
    
    searchInput.addEventListener('input', (e) => {
        debouncedSearch(e.target.value);
    });
}

// ============================================
// 8. HELPER FUNCTIONS
// ============================================

function renderBooks(books) {
    const container = document.querySelector('[data-books-container]');
    if (!container) return;
    
    container.innerHTML = books.map(book => `
        <div class="book-card" data-book-item data-book-id="${book.id}">
            <img src="${book.coverImage || '/images/placeholder.jpg'}" alt="${book.title}">
            <h3 data-book-title>${book.title}</h3>
            <p data-book-description>${book.description || 'No description'}</p>
            <div class="actions">
                <button data-edit-book="${book.id}">Edit</button>
                <button data-delete-book="${book.id}" data-book-title="${book.title}">Delete</button>
                <button data-save-book="${book.id}" style="display:none;">Save</button>
                <button data-cancel-edit style="display:none;">Cancel</button>
            </div>
        </div>
    `).join('');
    
    setupDeleteButtons();
    setupInlineEdit();
}

function renderEvents(events) {
    // Similar implementation
}

function renderResources(resources) {
    // Similar implementation
}
