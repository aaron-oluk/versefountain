import './bootstrap';

// Dark Mode Toggle
(function () {
    // Update theme icons based on current mode
    function updateThemeIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');

        if (lightIcon && darkIcon) {
            if (isDark) {
                // In dark mode, show sun icon (to switch to light)
                lightIcon.style.display = 'block';
                darkIcon.style.display = 'none';
            } else {
                // In light mode, show moon icon (to switch to dark)
                lightIcon.style.display = 'none';
                darkIcon.style.display = 'block';
            }
        }
    }

    // Check for saved dark mode preference or default to light mode
    const darkMode = localStorage.getItem('dark-mode');
    if (darkMode === 'enabled') {
        document.documentElement.classList.add('dark');
    }

    // Update icons immediately and on page load
    updateThemeIcons();
    document.addEventListener('DOMContentLoaded', updateThemeIcons);

    // Toggle dark mode function
    window.toggleDarkMode = function () {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('dark-mode', isDark ? 'enabled' : 'disabled');
        updateThemeIcons();
    };
})();

// Global utilities
window.utils = {
    // Format date to relative time
    formatDate(dateString) {
        if (!dateString) return 'Unknown date';

        const date = new Date(dateString);
        if (isNaN(date.getTime())) return 'Invalid date';

        const now = new Date();
        const diffTime = Math.abs(now.getTime() - date.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 1) return 'Yesterday';
        if (diffDays < 7) return `${diffDays} days ago`;
        if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
        if (diffDays < 365) return `${Math.floor(diffDays / 30)} months ago`;

        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Show toast notification
    showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-md ${type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                    'bg-blue-500 text-white'
            }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    },

    // Copy text to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            this.showToast('Copied to clipboard!');
        } catch (error) {
            console.error('Failed to copy text:', error);
            this.showToast('Failed to copy text', 'error');
        }
    },

    // Share content
    async shareContent(data) {
        if (navigator.share) {
            try {
                await navigator.share(data);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Error sharing:', error);
                }
            }
        } else {
            // Fallback: copy to clipboard
            const text = `${data.title}\n\n${data.text}\n\n${data.url}`;
            await this.copyToClipboard(text);
        }
    }
};

// Global event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('.bg-green-50, .bg-red-50');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s ease';
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });

    // Handle form submissions
    document.addEventListener('submit', function (event) {
        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"]');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
        }
    });

    // Handle confirmation dialogs
    document.addEventListener('click', function (event) {
        if (event.target.matches('[data-confirm]')) {
            const message = event.target.getAttribute('data-confirm');
            if (!confirm(message)) {
                event.preventDefault();
                event.stopPropagation();
            }
        }
    });
});

// CSRF token for AJAX requests
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Add CSRF token to all AJAX requests
if (window.csrfToken) {
    const originalFetch = window.fetch;
    window.fetch = function (url, options = {}) {
        if (options.method && options.method !== 'GET') {
            options.headers = {
                ...options.headers,
                'X-CSRF-TOKEN': window.csrfToken
            };
        }
        return originalFetch(url, options);
    };
}

// ============================================
// Vanilla JS Components
// ============================================

// Flash Message System
class FlashMessage {
    constructor(containerId = 'flash-message-container') {
        this.container = document.getElementById(containerId);
        this.messageElement = null;
    }

    show(message, type = 'success') {
        if (!this.container) {
            // Create container if it doesn't exist
            this.container = document.createElement('div');
            this.container.id = 'flash-message-container';
            this.container.className = 'fixed top-16 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full px-4';
            document.body.appendChild(this.container);
        }

        // Remove existing message
        if (this.messageElement) {
            this.messageElement.remove();
        }

        // Create new message
        this.messageElement = document.createElement('div');
        this.messageElement.className = `p-4 rounded-md flex items-center justify-between ${type === 'success'
                ? 'bg-blue-50 border border-blue-200 text-blue-800'
                : 'bg-red-50 border border-red-200 text-red-800'
            }`;

        this.messageElement.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} text-lg"></i>
                <span class="text-sm font-normal">${message}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 ${type === 'success'
                ? 'text-blue-600 hover:text-blue-800'
                : 'text-red-600 hover:text-red-800'
            }">
                <i class="bx bx-x text-lg"></i>
            </button>
        `;

        this.container.appendChild(this.messageElement);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (this.messageElement && this.messageElement.parentElement) {
                this.messageElement.style.transition = 'opacity 0.5s ease';
                this.messageElement.style.opacity = '0';
                setTimeout(() => {
                    if (this.messageElement && this.messageElement.parentElement) {
                        this.messageElement.remove();
                    }
                }, 500);
            }
        }, 5000);
    }

    hide() {
        if (this.messageElement) {
            this.messageElement.remove();
        }
    }
}

// Poem Detail Component
class PoemDetail {
    constructor(container, options = {}) {
        this.container = container;
        this.poemId = options.poemId;
        this.isLiked = options.isLiked || false;
        this.likesCount = options.likesCount || 0;
        this.currentRating = options.currentRating || 0;
        this.avgRating = options.avgRating || 0;
        this.ratingCount = options.ratingCount || 0;
        this.showComments = false;
        this.showShareMenu = false;
        this.poemUrl = options.poemUrl || window.location.href;
        this.apiBaseUrl = options.apiBaseUrl || '/api/poems';
        this.isAuthenticated = options.isAuthenticated || false;

        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken;

        this.init();
    }

    init() {
        // Like button
        const likeBtn = this.container.querySelector('[data-like-button]');
        if (likeBtn) {
            likeBtn.addEventListener('click', () => this.toggleLike());
        }

        // Rating buttons
        for (let i = 1; i <= 5; i++) {
            const ratingBtn = this.container.querySelector(`[data-rating="${i}"]`);
            if (ratingBtn) {
                ratingBtn.addEventListener('click', () => this.ratePoem(i));
            }
        }

        // Comments toggle
        const commentsBtn = this.container.querySelector('[data-comments-toggle]');
        if (commentsBtn) {
            commentsBtn.addEventListener('click', () => this.toggleComments());
        }

        // Share menu toggle
        const shareBtn = this.container.querySelector('[data-share-toggle]');
        if (shareBtn) {
            shareBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleShareMenu();
            });
        }

        // Share actions
        const copyLinkBtn = this.container.querySelector('[data-share-copy]');
        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', () => this.copyLink());
        }

        // Comment form
        const commentForm = this.container.querySelector('[data-comment-form]');
        if (commentForm) {
            commentForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitComment();
            });
        }

        // Close share menu on outside click
        document.addEventListener('click', (e) => {
            if (this.showShareMenu && !this.container.querySelector('[data-share-menu]')?.contains(e.target) &&
                !this.container.querySelector('[data-share-toggle]')?.contains(e.target)) {
                this.toggleShareMenu();
            }
        });
    }

    async toggleLike() {
        if (!this.isAuthenticated) {
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch(`${this.apiBaseUrl}/${this.poemId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.isLiked = data.liked;
                this.likesCount = data.likes_count;
                this.updateLikeDisplay();
            } else {
                console.error('Failed to toggle like:', response.status);
                if (window.flashMessage) {
                    window.flashMessage.show('Failed to like poem', 'error');
                }
            }
        } catch (error) {
            console.error('Error toggling like:', error);
            if (window.flashMessage) {
                window.flashMessage.show('Error: ' + error.message, 'error');
            }
        }
    }

    updateLikeDisplay() {
        const likeBtn = this.container.querySelector('[data-like-button]');
        const likesCountEl = this.container.querySelector('[data-likes-count]');
        const likeIcon = likeBtn?.querySelector('i');

        if (likeBtn) {
            // Remove old color classes and add new ones
            likeBtn.classList.remove('text-red-500', 'text-gray-500', 'hover:text-red-500', 'dark:text-gray-400');
            if (this.isLiked) {
                likeBtn.classList.add('text-red-500');
            } else {
                likeBtn.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-red-500');
            }
        }

        if (likeIcon) {
            likeIcon.className = this.isLiked ? 'bx bxs-heart text-sm' : 'bx bx-heart text-sm';
        }

        if (likesCountEl) {
            likesCountEl.textContent = this.likesCount;
        }
    }

    async ratePoem(rating) {
        if (!this.isAuthenticated) {
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch(`${this.apiBaseUrl}/${this.poemId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ rating }),
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.currentRating = parseInt(data.rating);
                if (data.average_rating !== undefined) {
                    this.avgRating = parseFloat(data.average_rating).toFixed(1);
                }
                if (data.rating_count !== undefined) {
                    this.ratingCount = parseInt(data.rating_count);
                }
                this.updateRatingDisplay();
                if (window.flashMessage) {
                    window.flashMessage.show('Poem rated successfully!', 'success');
                }
            } else {
                console.error('Failed to rate poem:', response.status);
                if (window.flashMessage) {
                    window.flashMessage.show('Failed to rate poem', 'error');
                }
            }
        } catch (error) {
            console.error('Error rating poem:', error);
            if (window.flashMessage) {
                window.flashMessage.show('Error: ' + error.message, 'error');
            }
        }
    }

    updateRatingDisplay() {
        for (let i = 1; i <= 5; i++) {
            const btn = this.container.querySelector(`[data-rating="${i}"]`);
            const icon = btn?.querySelector('i');
            if (btn && icon) {
                const isActive = this.currentRating >= i;
                // Remove old classes
                icon.className = isActive ? 'bx bxs-star text-xs' : 'bx bx-star text-xs';
                
                // Update button classes
                btn.classList.remove('text-yellow-500', 'text-gray-400', 'hover:text-yellow-400', 'dark:text-gray-500');
                if (isActive) {
                    btn.classList.add('text-yellow-500');
                } else {
                    btn.classList.add('text-gray-400', 'dark:text-gray-500', 'hover:text-yellow-400');
                }
            }
        }

        // Update rating display text
        const ratingDisplay = this.container.querySelector('[data-rating-display]');
        if (ratingDisplay && this.avgRating !== undefined && this.ratingCount !== undefined) {
            ratingDisplay.textContent = `${this.avgRating} (${this.ratingCount})`;
        }
    }

    toggleComments() {
        const commentFormContainer = this.container.querySelector('[data-comment-form-container]');
        if (commentFormContainer) {
            if (commentFormContainer.classList.contains('hidden')) {
                commentFormContainer.classList.remove('hidden');
            } else {
                commentFormContainer.classList.add('hidden');
            }
        }
    }

    toggleShareMenu() {
        this.showShareMenu = !this.showShareMenu;
        const shareMenu = this.container.querySelector('[data-share-menu]');
        if (shareMenu) {
            if (this.showShareMenu) {
                shareMenu.classList.remove('hidden');
                shareMenu.classList.add('block');
            } else {
                shareMenu.classList.add('hidden');
                shareMenu.classList.remove('block');
            }
        }
    }

    async copyLink() {
        try {
            await navigator.clipboard.writeText(this.poemUrl);
            if (window.flashMessage) {
                window.flashMessage.show('Link copied to clipboard!', 'success');
            }
            this.toggleShareMenu();
        } catch (error) {
            console.error('Failed to copy link:', error);
        }
    }

    async submitComment() {
        const commentForm = this.container.querySelector('[data-comment-form]');
        const textarea = commentForm?.querySelector('textarea');
        const commentText = textarea?.value.trim();

        if (!commentText) return;

        try {
            const response = await fetch(`${this.apiBaseUrl}/${this.poemId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: commentText }),
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (textarea) textarea.value = '';
                if (window.flashMessage) {
                    window.flashMessage.show('Comment posted successfully!', 'success');
                }
                // Reload page to show new comment
                setTimeout(() => window.location.reload(), 500);
            } else {
                console.error('Failed to post comment:', response.status);
                if (window.flashMessage) {
                    window.flashMessage.show('Failed to post comment', 'error');
                }
            }
        } catch (error) {
            console.error('Error submitting comment:', error);
            if (window.flashMessage) {
                window.flashMessage.show('Error: ' + error.message, 'error');
            }
        }
    }
}

// Poem Form Handler
class PoemForm {
    constructor(formElement) {
        this.form = formElement;
        this.titleInput = this.form.querySelector('[name="title"]');
        this.contentInput = this.form.querySelector('[name="content"]');
        this.isVideoInput = this.form.querySelector('[name="is_video"]');
        this.showPreview = false;
        this.isSubmitting = false;

        this.init();
    }

    init() {
        // Preview toggle
        const previewBtn = this.form.querySelector('[data-preview-toggle]');
        if (previewBtn) {
            previewBtn.addEventListener('click', () => this.togglePreview());
        }

        // Form validation
        this.form.addEventListener('submit', (e) => {
            if (!this.isValid()) {
                e.preventDefault();
                return false;
            }
            this.isSubmitting = true;
        });

        // Content length display
        if (this.contentInput) {
            this.contentInput.addEventListener('input', () => this.updateContentLength());
        }
    }

    isValid() {
        const hasTitle = this.titleInput && this.titleInput.value.trim().length > 0;
        const hasContent = this.contentInput && this.contentInput.value.trim().length > 0;
        const contentNotTooLong = this.contentInput && this.contentInput.value.length <= 10000;
        return hasTitle && hasContent && contentNotTooLong;
    }

    togglePreview() {
        this.showPreview = !this.showPreview;
        const previewSection = this.form.querySelector('[data-preview-section]');
        const previewBtn = this.form.querySelector('[data-preview-toggle]');

        if (previewSection) {
            previewSection.style.display = this.showPreview ? 'block' : 'none';
        }

        if (previewBtn) {
            previewBtn.textContent = this.showPreview ? 'Hide Preview' : 'Show Preview';
        }

        // Update preview content
        if (this.showPreview) {
            const previewTitle = previewSection?.querySelector('[data-preview-title]');
            const previewContent = previewSection?.querySelector('[data-preview-content]');

            if (previewTitle && this.titleInput) {
                previewTitle.textContent = this.titleInput.value || 'Untitled';
            }
            if (previewContent && this.contentInput) {
                previewContent.textContent = this.contentInput.value || 'No content yet';
            }
        }
    }

    updateContentLength() {
        const lengthDisplay = this.form.querySelector('[data-content-length]');
        if (lengthDisplay && this.contentInput) {
            const length = this.contentInput.value.length;
            lengthDisplay.textContent = length;

            // Update color if approaching limit
            if (length > 9000) {
                lengthDisplay.classList.add('text-red-600');
                lengthDisplay.classList.remove('text-gray-500');
            } else {
                lengthDisplay.classList.remove('text-red-600');
                lengthDisplay.classList.add('text-gray-500');
            }
        }
    }
}

// Chat Interface
class ChatInterface {
    constructor(container, options = {}) {
        this.container = container;
        this.roomId = options.roomId;
        this.apiBaseUrl = options.apiBaseUrl || '/chat/rooms';
        this.newMessages = [];
        this.isSending = false;

        this.init();
    }

    init() {
        const messageForm = this.container.querySelector('[data-message-form]');
        if (messageForm) {
            messageForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.sendMessage();
            });
        }

        // Poll for new messages
        this.pollForNewMessages();
    }

    async sendMessage() {
        const messageInput = this.container.querySelector('[data-message-input]');
        const messageContent = messageInput?.value.trim();

        if (!messageContent || this.isSending) return;

        this.isSending = true;
        messageInput.value = '';

        try {
            const response = await fetch(`${this.apiBaseUrl}/${this.roomId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: messageContent })
            });

            if (response.ok) {
                const data = await response.json();
                this.addNewMessage(data);
            } else {
                const errorData = await response.json();
                messageInput.value = messageContent; // Restore on error
                if (window.flashMessage) {
                    window.flashMessage.show(errorData.message || 'Failed to send message', 'error');
                }
            }
        } catch (error) {
            console.error('Error sending message:', error);
            messageInput.value = messageContent; // Restore on error
        } finally {
            this.isSending = false;
        }
    }

    addNewMessage(message) {
        // Handle both local messages and WebSocket messages
        const messageData = {
            id: message.id || Date.now(),
            content: message.message || message.content || '',
            user_name: message.user?.first_name || message.username || message.user_name || 'Anonymous',
            user_initial: ((message.user?.first_name || message.username || message.user_name || 'U')[0]).toUpperCase(),
            time_ago: message.created_at ? this.formatTimeAgo(new Date(message.created_at)) : 'just now'
        };

        this.newMessages.push(messageData);
        this.renderNewMessages();
    }

    formatTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'just now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' minutes ago';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' hours ago';
        return Math.floor(diffInSeconds / 86400) + ' days ago';
    }

    renderNewMessages() {
        const container = this.container.querySelector('[data-new-messages]');
        if (!container) return;

        container.innerHTML = '';
        container.style.display = this.newMessages.length > 0 ? 'block' : 'none';

        this.newMessages.forEach(message => {
            const messageEl = document.createElement('div');
            messageEl.className = 'flex space-x-3 mb-4';
            messageEl.innerHTML = `
                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-normal text-gray-700">${message.user_initial}</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-1">
                        <span class="text-sm font-normal text-gray-900">${message.user_name}</span>
                        <span class="text-xs text-gray-500">${message.time_ago}</span>
                    </div>
                    <div class="bg-gray-50 px-3 py-2">
                        <p class="text-sm text-gray-800 font-light">${message.content}</p>
                    </div>
                </div>
            `;
            container.appendChild(messageEl);
        });

        // Scroll to bottom
        const messagesContainer = this.container.querySelector('[data-messages-container]');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    pollForNewMessages() {
        // Implement polling or WebSocket connection here
        setInterval(() => {
            // Poll for new messages
        }, 5000);
    }
}

// Modal Component
class Modal {
    constructor(modalElement, options = {}) {
        this.modal = modalElement;
        this.name = options.name || modalElement.getAttribute('data-modal-name');
        this.show = options.show || false;
        this.focusableSelector = 'a, button, input:not([type="hidden"]), textarea, select, details, [tabindex]:not([tabindex="-1"])';

        this.init();
    }

    init() {
        // Set initial state
        if (this.show) {
            this.show();
        } else {
            this.hide();
        }

        // Close buttons
        const closeButtons = this.modal.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', () => this.hide());
        });

        // Backdrop click
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.addEventListener('click', () => this.hide());
        }

        // Escape key
        const escapeHandler = (e) => {
            if (e.key === 'Escape' && this.show) {
                this.hide();
            }
        };
        document.addEventListener('keydown', escapeHandler);
        this.modal._escapeHandler = escapeHandler;

        // Tab trapping
        const tabHandler = (e) => {
            if (e.key === 'Tab' && this.show) {
                this.trapFocus(e);
            }
        };
        this.modal.addEventListener('keydown', tabHandler);
        this.modal._tabHandler = tabHandler;

        // Listen for open/close events
        const openHandler = (e) => {
            if (e.detail === this.name) {
                this.show();
            }
        };
        window.addEventListener('open-modal', openHandler);
        this.modal._openHandler = openHandler;

        const closeHandler = (e) => {
            if (e.detail === this.name) {
                this.hide();
            }
        };
        window.addEventListener('close-modal', closeHandler);
        this.modal._closeHandler = closeHandler;
    }

    show() {
        this.show = true;
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        const content = this.modal.querySelector('[data-modal-content]');

        if (backdrop) backdrop.style.display = 'block';
        if (content) content.style.display = 'block';
        this.modal.style.display = 'block';
        document.body.classList.add('overflow-y-hidden');

        // Focus first element
        setTimeout(() => {
            const firstFocusable = this.getFocusables()[0];
            if (firstFocusable) firstFocusable.focus();
        }, 100);
    }

    hide() {
        this.show = false;
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        const content = this.modal.querySelector('[data-modal-content]');

        if (backdrop) backdrop.style.display = 'none';
        if (content) content.style.display = 'none';
        this.modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
    }

    getFocusables() {
        return Array.from(this.modal.querySelectorAll(this.focusableSelector))
            .filter(el => !el.hasAttribute('disabled'));
    }

    trapFocus(e) {
        const focusables = this.getFocusables();
        const firstFocusable = focusables[0];
        const lastFocusable = focusables[focusables.length - 1];
        const currentIndex = focusables.indexOf(document.activeElement);

        if (e.shiftKey) {
            if (document.activeElement === firstFocusable) {
                e.preventDefault();
                lastFocusable.focus();
            }
        } else {
            if (document.activeElement === lastFocusable) {
                e.preventDefault();
                firstFocusable.focus();
            }
        }
    }
}

// Dropdown Component
class Dropdown {
    constructor(dropdownElement) {
        this.dropdown = dropdownElement;
        this.toggle = dropdownElement.querySelector('[data-dropdown-toggle]');
        this.menu = dropdownElement.querySelector('[data-dropdown-menu]');
        this.open = false;

        this.init();
    }

    init() {
        if (this.toggle) {
            this.toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleMenu();
            });
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.open && !this.dropdown.contains(e.target)) {
                this.close();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.open) {
                this.close();
            }
        });
    }

    toggleMenu() {
        this.open = !this.open;
        if (this.menu) {
            this.menu.style.display = this.open ? 'block' : 'none';
        }
    }

    close() {
        this.open = false;
        if (this.menu) {
            this.menu.style.display = 'none';
        }
    }
}

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    // Initialize FlashMessage
    window.flashMessage = new FlashMessage();

    // Initialize modals (only if not already initialized by component script)
    document.querySelectorAll('[data-modal]').forEach(modal => {
        if (!modal.dataset.modalInitialized) {
            const name = modal.getAttribute('data-modal-name');
            new Modal(modal, { name });
            modal.dataset.modalInitialized = 'true';
        }
    });

    // Initialize dropdowns (only if not already initialized by component script)
    document.querySelectorAll('[data-dropdown]').forEach(dropdown => {
        if (!dropdown.dataset.initialized) {
            new Dropdown(dropdown);
            dropdown.dataset.initialized = 'true';
        }
    });
});

// Book CRUD Manager
class BookManager {
    constructor() {
        this.apiBaseUrl = '/api/books';
        this.csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content;
    }

    async fetchAll(filters = {}) {
        try {
            const params = new URLSearchParams(filters);
            const response = await fetch(`${this.apiBaseUrl}?${params}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch books');
            return await response.json();
        } catch (error) {
            console.error('Error fetching books:', error);
            window.utils.showToast('Failed to load books', 'error');
            return [];
        }
    }

    async fetchOne(id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch book');
            return await response.json();
        } catch (error) {
            console.error('Error fetching book:', error);
            window.utils.showToast('Failed to load book', 'error');
            return null;
        }
    }

    async create(bookData) {
        try {
            const response = await fetch(this.apiBaseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(bookData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to create book');
            }

            const book = await response.json();
            window.utils.showToast('Book created successfully! Pending admin approval.', 'success');
            return book;
        } catch (error) {
            console.error('Error creating book:', error);
            window.utils.showToast(error.message || 'Failed to create book', 'error');
            return null;
        }
    }

    async update(id, bookData) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(bookData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to update book');
            }

            const book = await response.json();
            window.utils.showToast('Book updated successfully!', 'success');
            return book;
        } catch (error) {
            console.error('Error updating book:', error);
            window.utils.showToast(error.message || 'Failed to update book', 'error');
            return null;
        }
    }

    async delete(id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to delete book');
            }

            window.utils.showToast('Book deleted successfully!', 'success');
            return true;
        } catch (error) {
            console.error('Error deleting book:', error);
            window.utils.showToast(error.message || 'Failed to delete book', 'error');
            return false;
        }
    }

    async uploadCover(bookId, file) {
        try {
            const formData = new FormData();
            formData.append('cover_image', file);

            const response = await fetch(`${this.apiBaseUrl}/${bookId}/upload-cover`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to upload cover');
            }

            const data = await response.json();
            return data.coverImage;
        } catch (error) {
            console.error('Error uploading cover:', error);
            window.utils.showToast(error.message || 'Failed to upload cover', 'error');
            return null;
        }
    }
}

// Event CRUD Manager
class EventManager {
    constructor() {
        this.apiBaseUrl = '/api/events';
        this.csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content;
    }

    async fetchAll(filters = {}) {
        try {
            const params = new URLSearchParams(filters);
            const response = await fetch(`${this.apiBaseUrl}?${params}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch events');
            return await response.json();
        } catch (error) {
            console.error('Error fetching events:', error);
            window.utils.showToast('Failed to load events', 'error');
            return [];
        }
    }

    async fetchOne(id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch event');
            return await response.json();
        } catch (error) {
            console.error('Error fetching event:', error);
            window.utils.showToast('Failed to load event', 'error');
            return null;
        }
    }

    async create(eventData) {
        try {
            const response = await fetch(this.apiBaseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(eventData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to create event');
            }

            const event = await response.json();
            window.utils.showToast('Event created successfully!', 'success');
            return event;
        } catch (error) {
            console.error('Error creating event:', error);
            window.utils.showToast(error.message || 'Failed to create event', 'error');
            return null;
        }
    }

    async update(id, eventData) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(eventData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to update event');
            }

            const event = await response.json();
            window.utils.showToast('Event updated successfully!', 'success');
            return event;
        } catch (error) {
            console.error('Error updating event:', error);
            window.utils.showToast(error.message || 'Failed to update event', 'error');
            return null;
        }
    }

    async register(eventId) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${eventId}/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to register for event');
            }

            window.utils.showToast('Successfully registered for event!', 'success');
            return await response.json();
        } catch (error) {
            console.error('Error registering for event:', error);
            window.utils.showToast(error.message || 'Failed to register', 'error');
            return null;
        }
    }

    async unregister(eventId) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${eventId}/unregister`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to unregister from event');
            }

            window.utils.showToast('Successfully unregistered from event!', 'success');
            return true;
        } catch (error) {
            console.error('Error unregistering from event:', error);
            window.utils.showToast(error.message || 'Failed to unregister', 'error');
            return false;
        }
    }

    async getRegistrationStatus(eventId) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${eventId}/registration-status`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch registration status');
            return await response.json();
        } catch (error) {
            console.error('Error fetching registration status:', error);
            return null;
        }
    }
}

// Academic Resource CRUD Manager
class AcademicResourceManager {
    constructor() {
        this.apiBaseUrl = '/api/academic-resources';
        this.csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content;
    }

    async fetchAll(filters = {}) {
        try {
            const params = new URLSearchParams(filters);
            const response = await fetch(`${this.apiBaseUrl}?${params}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch resources');
            return await response.json();
        } catch (error) {
            console.error('Error fetching resources:', error);
            window.utils.showToast('Failed to load resources', 'error');
            return [];
        }
    }

    async fetchOne(id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Failed to fetch resource');
            return await response.json();
        } catch (error) {
            console.error('Error fetching resource:', error);
            window.utils.showToast('Failed to load resource', 'error');
            return null;
        }
    }

    async create(resourceData) {
        try {
            const response = await fetch(this.apiBaseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(resourceData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to create resource');
            }

            const resource = await response.json();
            window.utils.showToast('Resource created successfully!', 'success');
            return resource;
        } catch (error) {
            console.error('Error creating resource:', error);
            window.utils.showToast(error.message || 'Failed to create resource', 'error');
            return null;
        }
    }

    async update(id, resourceData) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(resourceData),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to update resource');
            }

            const resource = await response.json();
            window.utils.showToast('Resource updated successfully!', 'success');
            return resource;
        } catch (error) {
            console.error('Error updating resource:', error);
            window.utils.showToast(error.message || 'Failed to update resource', 'error');
            return null;
        }
    }

    async delete(id) {
        try {
            const response = await fetch(`${this.apiBaseUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to delete resource');
            }

            window.utils.showToast('Resource deleted successfully!', 'success');
            return true;
        } catch (error) {
            console.error('Error deleting resource:', error);
            window.utils.showToast(error.message || 'Failed to delete resource', 'error');
            return false;
        }
    }

    async uploadFile(resourceId, file) {
        try {
            const formData = new FormData();
            formData.append('file', file);

            const response = await fetch(`${this.apiBaseUrl}/${resourceId}/upload-file`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to upload file');
            }

            const data = await response.json();
            return data.fileUrl;
        } catch (error) {
            console.error('Error uploading file:', error);
            window.utils.showToast(error.message || 'Failed to upload file', 'error');
            return null;
        }
    }
}

// Form Handler for generic CRUD forms
class CRUDFormHandler {
    constructor(formElement, options = {}) {
        this.form = formElement;
        this.onSubmit = options.onSubmit;
        this.onSuccess = options.onSuccess;
        this.onError = options.onError;
        this.validateFn = options.validate;
        this.isSubmitting = false;

        this.init();
    }

    init() {
        this.form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.handleSubmit();
        });

        // Real-time validation
        const inputs = this.form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    async handleSubmit() {
        if (this.isSubmitting) return;

        // Validate
        if (this.validateFn && !this.validateFn(this.getFormData())) {
            return;
        }

        this.isSubmitting = true;
        this.setSubmitButtonState(true);

        try {
            const formData = this.getFormData();
            
            if (this.onSubmit) {
                const result = await this.onSubmit(formData);
                
                if (result && this.onSuccess) {
                    this.onSuccess(result);
                }
            }
        } catch (error) {
            console.error('Form submission error:', error);
            if (this.onError) {
                this.onError(error);
            }
        } finally {
            this.isSubmitting = false;
            this.setSubmitButtonState(false);
        }
    }

    getFormData() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            // Handle checkboxes
            if (this.form.elements[key]?.type === 'checkbox') {
                data[key] = this.form.elements[key].checked;
            } else {
                data[key] = value;
            }
        }
        
        return data;
    }

    validateField(field) {
        const value = field.value.trim();
        const required = field.hasAttribute('required');
        
        if (required && !value) {
            this.showFieldError(field, 'This field is required');
            return false;
        }
        
        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.showFieldError(field, 'Please enter a valid email');
                return false;
            }
        }
        
        // URL validation
        if (field.type === 'url' && value) {
            try {
                new URL(value);
            } catch {
                this.showFieldError(field, 'Please enter a valid URL');
                return false;
            }
        }
        
        // Number validation
        if (field.type === 'number' && value) {
            const min = field.getAttribute('min');
            const max = field.getAttribute('max');
            const numValue = parseFloat(value);
            
            if (min && numValue < parseFloat(min)) {
                this.showFieldError(field, `Value must be at least ${min}`);
                return false;
            }
            
            if (max && numValue > parseFloat(max)) {
                this.showFieldError(field, `Value must be at most ${max}`);
                return false;
            }
        }
        
        this.clearFieldError(field);
        return true;
    }

    showFieldError(field, message) {
        this.clearFieldError(field);
        
        const errorEl = document.createElement('p');
        errorEl.className = 'mt-1 text-sm text-red-600';
        errorEl.textContent = message;
        errorEl.dataset.fieldError = field.name;
        
        field.classList.add('border-red-500', 'focus:border-red-500');
        field.parentElement.appendChild(errorEl);
    }

    clearFieldError(field) {
        const errorEl = field.parentElement.querySelector(`[data-field-error="${field.name}"]`);
        if (errorEl) {
            errorEl.remove();
        }
        field.classList.remove('border-red-500', 'focus:border-red-500');
    }

    setSubmitButtonState(loading) {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (!submitBtn) return;
        
        if (loading) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.textContent;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        } else {
            submitBtn.disabled = false;
            if (submitBtn.dataset.originalText) {
                submitBtn.textContent = submitBtn.dataset.originalText;
            }
        }
    }

    reset() {
        this.form.reset();
        this.form.querySelectorAll('[data-field-error]').forEach(el => el.remove());
        this.form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'focus:border-red-500');
        });
    }
}

// Export classes for global use
window.FlashMessage = FlashMessage;
window.PoemDetail = PoemDetail;
window.PoemForm = PoemForm;
window.ChatInterface = ChatInterface;
window.Modal = Modal;
window.Dropdown = Dropdown;
window.BookManager = BookManager;
window.EventManager = EventManager;
window.AcademicResourceManager = AcademicResourceManager;
window.CRUDFormHandler = CRUDFormHandler;

// Notifications System
class NotificationsDropdown {
    constructor() {
        this.dropdown = document.querySelector('[data-notifications-dropdown]');
        this.toggle = document.querySelector('[data-notifications-toggle]');
        this.menu = document.getElementById('notifications-menu');
        this.list = document.getElementById('notifications-list');
        this.badge = document.getElementById('notifications-badge');
        this.unreadCountEl = document.getElementById('unread-count');
        this.markAllReadBtn = document.getElementById('mark-all-read');
        this.isOpen = false;
        this.notifications = [];
        this.unreadCount = 0;

        if (this.dropdown) {
            this.init();
        }
    }

    init() {
        // Toggle dropdown
        if (this.toggle) {
            this.toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });
        }

        // Mark all as read
        if (this.markAllReadBtn) {
            this.markAllReadBtn.addEventListener('click', () => this.markAllAsRead());
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.dropdown.contains(e.target)) {
                this.closeDropdown();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeDropdown();
            }
        });

        // Fetch notifications on load
        this.fetchNotifications();

        // Poll for new notifications every 30 seconds
        setInterval(() => this.fetchNotifications(), 30000);
    }

    toggleDropdown() {
        this.isOpen = !this.isOpen;
        if (this.menu) {
            this.menu.style.display = this.isOpen ? 'flex' : 'none';
        }
        if (this.isOpen) {
            this.fetchNotifications();
        }
    }

    closeDropdown() {
        this.isOpen = false;
        if (this.menu) {
            this.menu.style.display = 'none';
        }
    }

    async fetchNotifications() {
        try {
            const response = await fetch('/api/notifications?limit=10', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.notifications = data.notifications || [];
                this.unreadCount = data.unread_count || 0;
                this.render();
            }
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    render() {
        // Update badge
        if (this.badge) {
            if (this.unreadCount > 0) {
                this.badge.classList.remove('hidden');
            } else {
                this.badge.classList.add('hidden');
            }
        }

        // Update unread count text
        if (this.unreadCountEl) {
            this.unreadCountEl.textContent = this.unreadCount;
        }

        // Render notifications list
        if (this.list) {
            if (this.notifications.length === 0) {
                this.list.innerHTML = `
                    <div class="px-4 py-8 text-center">
                        <i class="bx bx-bell-off text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No notifications yet</p>
                    </div>
                `;
            } else {
                this.list.innerHTML = this.notifications.map(notification => this.renderNotification(notification)).join('');

                // Add click handlers for marking as read
                this.list.querySelectorAll('[data-notification-id]').forEach(el => {
                    el.addEventListener('click', () => {
                        const id = el.dataset.notificationId;
                        this.markAsRead(id);
                        if (el.dataset.notificationLink) {
                            window.location.href = el.dataset.notificationLink;
                        }
                    });
                });
            }
        }
    }

    renderNotification(notification) {
        const isUnread = !notification.read_at;
        const timeAgo = this.formatTimeAgo(new Date(notification.created_at));
        const iconBgColors = {
            blue: 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
            green: 'bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400',
            red: 'bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400',
            amber: 'bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400',
            purple: 'bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400',
        };
        const iconBgClass = iconBgColors[notification.icon_bg_color] || iconBgColors.blue;

        return `
            <div
                data-notification-id="${notification.id}"
                data-notification-link="${notification.link || ''}"
                class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-b-0 ${isUnread ? 'bg-blue-50/50 dark:bg-blue-900/10' : ''}"
            >
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-9 h-9 ${iconBgClass} rounded-full flex items-center justify-center">
                        <i class="bx ${notification.icon || 'bx-bell'} text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white ${isUnread ? '' : 'font-normal'}">${notification.title}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${notification.message}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${timeAgo}</p>
                    </div>
                    ${isUnread ? '<span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>' : ''}
                </div>
            </div>
        `;
    }

    formatTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'just now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + 'm ago';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + 'h ago';
        if (diffInSeconds < 604800) return Math.floor(diffInSeconds / 86400) + 'd ago';
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }

    async markAsRead(id) {
        try {
            await fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            // Update local state
            const notification = this.notifications.find(n => n.id == id);
            if (notification && !notification.read_at) {
                notification.read_at = new Date().toISOString();
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.render();
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            await fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            // Update local state
            this.notifications.forEach(n => n.read_at = new Date().toISOString());
            this.unreadCount = 0;
            this.render();
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }
}

// Initialize notifications on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    new NotificationsDropdown();
});

// Export for global use
window.NotificationsDropdown = NotificationsDropdown;

// Auto-initialize PoemDetail when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const poemContainer = document.querySelector('[data-poem-detail]');
    if (!poemContainer) return;

    try {
        // Get data from data attributes
        const poemId = parseInt(poemContainer.getAttribute('data-poem-id'));
        const isLiked = poemContainer.getAttribute('data-is-liked') === 'true';
        const likesCount = parseInt(poemContainer.getAttribute('data-likes-count')) || 0;
        const currentRating = parseInt(poemContainer.getAttribute('data-current-rating')) || 0;
        const avgRating = parseFloat(poemContainer.getAttribute('data-avg-rating')) || 0;
        const ratingCount = parseInt(poemContainer.getAttribute('data-rating-count')) || 0;
        const isAuthenticated = poemContainer.getAttribute('data-is-authenticated') === 'true';
        const poemTitle = poemContainer.getAttribute('data-poem-title');
        const poemContent = poemContainer.getAttribute('data-poem-content');
        const poetryIndexUrl = poemContainer.getAttribute('data-poetry-index-url');
        const apiBaseUrl = '/api/poems';

        // Initialize PoemDetail
        const poemDetail = new PoemDetail(poemContainer, {
            poemId,
            isLiked,
            likesCount,
            currentRating,
            avgRating,
            ratingCount,
            poemUrl: window.location.href,
            apiBaseUrl,
            isAuthenticated
        });

        // Delete poem handler
        const deleteBtn = poemContainer.querySelector('[data-delete-poem]');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', async function() {
                if (!confirm('Are you sure you want to delete this poem?')) {
                    return;
                }
                
                try {
                    const response = await fetch(`${apiBaseUrl}/${poemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        if (window.flashMessage) {
                            window.flashMessage.show('Poem deleted successfully!', 'success');
                        }
                        setTimeout(() => window.location.href = poetryIndexUrl, 1000);
                    } else {
                        if (window.flashMessage) {
                            window.flashMessage.show('Failed to delete poem.', 'error');
                        }
                    }
                } catch (error) {
                    console.error('Error deleting poem:', error);
                    if (window.flashMessage) {
                        window.flashMessage.show('Failed to delete poem.', 'error');
                    }
                }
            });
        }

        // Share handlers
        const shareHandlers = {
            twitter: () => {
                const url = encodeURIComponent(window.location.href);
                const text = encodeURIComponent(`${poemTitle} - ${poemContent.substring(0, 100)}...`);
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=550,height=420');
            },
            facebook: () => {
                const url = encodeURIComponent(window.location.href);
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=550,height=420');
            },
            whatsapp: () => {
                const url = encodeURIComponent(window.location.href);
                const text = encodeURIComponent(`${poemTitle}\n\n${poemContent.substring(0, 100)}...\n\n${window.location.href}`);
                window.open(`https://wa.me/?text=${text}`, '_blank');
            },
            email: () => {
                const subject = encodeURIComponent(`Check out this poem: ${poemTitle}`);
                const body = encodeURIComponent(`${poemContent}\n\nRead more: ${window.location.href}\n\nShared from VerseFountain`);
                window.location.href = `mailto:?subject=${subject}&body=${body}`;
            },
            native: async () => {
                const poemData = {
                    title: poemTitle || 'Poem from VerseFountain',
                    text: poemContent || 'Check out this poem on VerseFountain',
                    url: window.location.href
                };
                
                if (navigator.share) {
                    try {
                        await navigator.share(poemData);
                        if (window.flashMessage) {
                            window.flashMessage.show('Poem shared successfully!', 'success');
                        }
                        return;
                    } catch (error) {
                        if (error.name !== 'AbortError' && error.name !== 'NotAllowedError') {
                            console.error('Share error:', error);
                        }
                    }
                }
                
                // Fallback to copy link
                poemDetail.copyLink();
            }
        };

        // Attach share handlers
        Object.keys(shareHandlers).forEach(key => {
            const btn = poemContainer.querySelector(`[data-share-${key}]`);
            if (btn) {
                btn.addEventListener('click', () => {
                    shareHandlers[key]();
                    poemDetail.toggleShareMenu();
                });
            }
        });
    } catch (error) {
        console.error('[PoemDetail] Initialization error:', error);
    }
});