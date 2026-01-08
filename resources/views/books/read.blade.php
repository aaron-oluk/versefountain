@extends('layouts.app')

@section('title', ($book->title ?? 'Reading') . ' - VerseFountain')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
<style>
    .reading-content {
        font-family: 'Lora', Georgia, serif;
    }
    .reading-content.font-sans {
        font-family: 'Montserrat', system-ui, sans-serif;
    }
    .reading-content.font-mono {
        font-family: 'SF Mono', 'Monaco', 'Consolas', monospace;
    }
    .ui-font {
        font-family: 'Montserrat', sans-serif;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-white">
    <!-- Top Navigation -->
    <header class="sticky top-0 bg-white border-b border-gray-200 z-40">
        <div class="flex items-center justify-between px-4 sm:px-6 h-14">
            <!-- Left: Back Button -->
            <div class="flex items-center gap-3 w-48">
                <a href="/books" class="flex items-center text-gray-500 hover:text-gray-900 transition-colors ui-font">
                    <i class="bx bx-chevron-left text-xl"></i>
                    <span class="text-sm font-medium">Library</span>
                </a>
            </div>

            <!-- Center: Title -->
            <div class="flex-1 text-center ui-font">
                <h1 class="text-sm font-semibold text-gray-900">{{ $book->title ?? 'The Waste Land' }}</h1>
                <p class="text-xs text-gray-500">{{ $book->author ?? 'T.S. Eliot' }}</p>
            </div>

            <!-- Right: Actions -->
            <div class="flex items-center gap-1 w-48 justify-end">
                <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Text Size" id="font-toggle">
                    <i class="bx bx-font text-lg"></i>
                </button>
                <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Bookmark">
                    <i class="bx bx-bookmark text-lg"></i>
                </button>
                <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Search">
                    <i class="bx bx-search text-lg"></i>
                </button>
                <button class="p-2 text-blue-600 bg-blue-50 rounded-lg transition-colors" title="Notes" id="notes-toggle">
                    <i class="bx bx-message-square-detail text-lg"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Main Reading Area -->
        <main class="flex-1 max-w-3xl mx-auto px-6 sm:px-12 lg:px-16 py-10 reading-content" id="reading-content">
            <!-- Part Title -->
            <div class="mb-10">
                <p class="text-blue-600 text-xs font-semibold tracking-widest mb-2 uppercase ui-font">Part I</p>
                <h2 class="text-3xl font-bold text-gray-900 mb-0 leading-tight">The Burial of the Dead</h2>
            </div>

            <!-- Dedication -->
            <div class="mb-10 text-gray-600 italic">
                <p class="mb-0">For Ezra Pound</p>
                <p class="mb-0">il miglior fabbro.</p>
            </div>

            <!-- Poem Content -->
            <div class="text-gray-800 leading-loose space-y-6 text-lg">
                <p>
                    April is the cruellest month, breeding<br>
                    Lilacs out of the dead land, mixing<br>
                    Memory and desire, stirring<br>
                    Dull roots with spring rain.<br>
                    Winter kept us warm, covering<br>
                    Earth in forgetful snow, feeding<br>
                    A little life with dried tubers.
                </p>

                <p>
                    Summer surprised us, coming over the Starnbergersee<br>
                    With a shower of rain; we stopped in the colonnade,<br>
                    And went on in sunlight, into the Hofgarten,<br>
                    And drank coffee, and talked for an hour.<br>
                    Bin gar keine Russin, stamm' aus Litauen, echt deutsch.<br>
                    And when we were children, staying at the arch-duke's,<br>
                    My cousin's, he took me out on a sled,<br>
                    And I was frightened. He said, Marie,<br>
                    Marie, hold on tight. And down we went.<br>
                    In the mountains, there you feel free.
                </p>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside id="reading-sidebar" class="hidden xl:block w-80 bg-gray-50 border-l border-gray-200 p-5 overflow-y-auto fixed right-0 top-14 bottom-14" style="height: calc(100vh - 7rem);">
            <!-- Appearance Panel -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide ui-font">Appearance</h3>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors" id="close-sidebar">
                        <i class="bx bx-x text-lg"></i>
                    </button>
                </div>

                <div class="space-y-5">
                    <!-- Font Selection -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 ui-font">Font</p>
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-600 rounded-md hover:bg-white hover:shadow-sm transition-all ui-font font-btn" data-font="sans">
                                Sans
                            </button>
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-900 bg-white rounded-md shadow-sm font-btn" data-font="serif" style="font-family: 'Lora', serif;">
                                Serif
                            </button>
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-600 rounded-md hover:bg-white hover:shadow-sm transition-all font-btn" data-font="mono" style="font-family: monospace;">
                                Mono
                            </button>
                        </div>
                    </div>

                    <!-- Font Size -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 ui-font">Size</p>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">A</span>
                            <input type="range" min="14" max="24" value="18" id="font-size-slider"
                                   class="flex-1 h-1.5 bg-gray-200 rounded-full appearance-none cursor-pointer accent-blue-600">
                            <span class="text-base text-gray-400">A</span>
                        </div>
                    </div>

                    <!-- Theme -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 ui-font">Theme</p>
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-900 bg-white rounded-md shadow-sm ui-font theme-btn" data-theme="light">
                                Light
                            </button>
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-600 rounded-md hover:bg-gray-800 hover:text-white transition-all ui-font theme-btn" data-theme="dark">
                                Dark
                            </button>
                            <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-600 rounded-md hover:bg-amber-50 transition-all ui-font theme-btn" data-theme="sepia">
                                Sepia
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="bx bx-check text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-gray-900 ui-font">Me</p>
                        <p class="text-[10px] text-gray-500 ui-font">Just now</p>
                    </div>
                </div>

                <!-- Highlighted Quote -->
                <div class="pl-3 border-l-2 border-yellow-400 mb-3">
                    <p class="text-xs text-gray-700 italic mb-1" style="font-family: 'Lora', serif;">"April is the cruellest month"</p>
                    <p class="text-xs text-gray-500 ui-font">Compare with Chaucer's "Canterbury Tales" opening where April is sweet.</p>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-gray-400 ui-font">Private Note</span>
                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="bx bx-trash text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Community Highlights -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4 shadow-sm">
                <div class="flex items-center gap-2 text-xs text-gray-600 ui-font">
                    <i class="bx bx-group text-base text-gray-400"></i>
                    <span>45 other readers highlighted this section.</span>
                </div>
            </div>

            <!-- Add Note Input -->
            <div class="bg-white rounded-xl border border-gray-200 p-3 shadow-sm">
                <div class="relative">
                    <input type="text" placeholder="Add a note..."
                           class="w-full px-3 py-2 pr-10 bg-gray-50 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm placeholder-gray-400 ui-font">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors">
                        <i class="bx bx-send text-lg"></i>
                    </button>
                </div>
            </div>
        </aside>
    </div>

    <!-- Bottom Progress Bar -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 sm:px-6 py-3 z-50">
        <div class="flex items-center justify-between max-w-7xl mx-auto ui-font">
            <!-- Left: Navigation -->
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="bx bx-chevron-left text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">Chapter Progress</span>
                    <div class="w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 transition-all rounded-full" style="width: 35%"></div>
                    </div>
                    <span class="text-xs text-gray-500">35%</span>
                </div>
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="bx bx-chevron-right text-xl"></i>
                </button>
            </div>

            <!-- Right: Info -->
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <i class="bx bx-time-five"></i>
                    <span>5 min left</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <i class="bx bx-file"></i>
                    <span>Page 14 / 42</span>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const readingContent = document.getElementById('reading-content');
    const sidebar = document.getElementById('reading-sidebar');
    const notesToggle = document.getElementById('notes-toggle');
    const closeSidebar = document.getElementById('close-sidebar');
    const fontButtons = document.querySelectorAll('.font-btn');
    const themeButtons = document.querySelectorAll('.theme-btn');
    const fontSizeSlider = document.getElementById('font-size-slider');

    // Toggle sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('hidden');
        sidebar.classList.toggle('xl:block');
    }

    notesToggle?.addEventListener('click', toggleSidebar);
    closeSidebar?.addEventListener('click', toggleSidebar);

    // Font selection
    fontButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const font = this.dataset.font;
            readingContent.classList.remove('font-sans', 'font-mono');
            if (font === 'sans') {
                readingContent.classList.add('font-sans');
            } else if (font === 'mono') {
                readingContent.classList.add('font-mono');
            }

            // Update button states
            fontButtons.forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
                b.classList.add('text-gray-600');
            });
            this.classList.add('bg-white', 'shadow-sm', 'text-gray-900');
            this.classList.remove('text-gray-600');
        });
    });

    // Font size
    fontSizeSlider?.addEventListener('input', function() {
        readingContent.style.fontSize = this.value + 'px';
    });

    // Theme selection
    themeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const theme = this.dataset.theme;
            const main = readingContent.closest('.min-h-screen');

            // Reset styles
            main.classList.remove('bg-gray-900', 'bg-amber-50');
            readingContent.classList.remove('text-gray-100', 'text-amber-900');

            if (theme === 'dark') {
                main.classList.add('bg-gray-900');
                readingContent.classList.add('text-gray-100');
            } else if (theme === 'sepia') {
                main.classList.add('bg-amber-50');
                readingContent.classList.add('text-amber-900');
            }

            // Update button states
            themeButtons.forEach(b => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-gray-900');
                b.classList.add('text-gray-600');
            });
            this.classList.add('bg-white', 'shadow-sm', 'text-gray-900');
            this.classList.remove('text-gray-600');
        });
    });
});
</script>

<style>
    /* Range slider styling */
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 16px;
        height: 16px;
        background: #3b82f6;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    input[type="range"]::-moz-range-thumb {
        width: 16px;
        height: 16px;
        background: #3b82f6;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
</style>
@endsection
