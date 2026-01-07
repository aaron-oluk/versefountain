@extends('layouts.app')

@section('title', ($book->title ?? 'Reading') . ' - VerseFountain')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Top Navigation -->
    <header class="sticky top-0 bg-white border-b border-gray-200 z-40">
        <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
            <div class="flex items-center gap-4">
                <a href="/books" class="flex items-center text-gray-600 hover:text-gray-900">
                    <i class="bx bx-arrow-back text-xl mr-2"></i>
                    <span class="text-sm font-medium">Library</span>
                </a>
            </div>
            <div class="flex-1 text-center">
                <h1 class="text-lg font-semibold text-gray-900">{{ $book->title ?? 'The Waste Land' }}</h1>
                <p class="text-xs text-gray-600">{{ $book->author ?? 'T.S. Eliot' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Text Settings">
                    <i class="bx bx-text text-xl"></i>
                </button>
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Bookmark">
                    <i class="bx bx-bookmark text-xl"></i>
                </button>
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Search">
                    <i class="bx bx-search text-xl"></i>
                </button>
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors bg-blue-50 text-blue-600" title="Notes">
                    <i class="bx bx-message-dots text-xl"></i>
                </button>
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Menu">
                    <i class="bx bx-menu text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Main Reading Area -->
        <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="prose prose-lg max-w-none">
                <div class="text-center mb-8">
                    <p class="text-blue-600 text-sm font-medium mb-2">PART I</p>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">The Burial of the Dead</h2>
                    <div class="w-16 h-0.5 bg-blue-600 mx-auto mb-4"></div>
                </div>
                <div class="pl-8 border-l-2 border-gray-200 mb-8 italic text-gray-700">
                    <p>For Ezra Pound</p>
                    <p>il miglior fabbro.</p>
                </div>
                <div class="text-gray-900 leading-relaxed space-y-4">
                    <p>April is the cruellest month, breeding<br>
                    Lilacs out of the dead land, mixing<br>
                    Memory and desire, stirring<br>
                    Dull roots with spring rain.<br>
                    Winter kept us warm, covering<br>
                    Earth in forgetful snow, feeding<br>
                    A little life with dried tubers.</p>
                    <p>Summer surprised us, coming over the Starnbergersee<br>
                    With a shower of rain; we stopped in the colonnade,<br>
                    And went on in sunlight, into the Hofgarten,<br>
                    And drank coffee, and talked for an hour.<br>
                    Bin gar keine Russin, stamm' aus Litauen, echt deutsch.<br>
                    And when we were children, staying at the arch-duke's,<br>
                    My cousin's, he took me out on a sled,<br>
                    And I was frightened. He said, Marie,<br>
                    Marie, hold on tight. And down we went.<br>
                    In the mountains, there you feel free.</p>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="hidden xl:block w-80 bg-gray-50 border-l border-gray-200 p-6 overflow-y-auto" style="max-height: calc(100vh - 4rem);">
            <!-- Appearance Panel -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-semibold text-gray-900 uppercase">Appearance</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="bx bx-x text-lg"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <!-- Font Selection -->
                    <div>
                        <p class="text-xs text-gray-600 mb-2">Font</p>
                        <div class="flex gap-2">
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Sans
                            </button>
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg">
                                Serif
                            </button>
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                                Mono
                            </button>
                        </div>
                    </div>
                    <!-- Font Size -->
                    <div>
                        <p class="text-xs text-gray-600 mb-2">Size</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">A</span>
                            <input type="range" min="12" max="24" value="16" class="flex-1">
                            <span class="text-xs text-gray-400">A</span>
                        </div>
                    </div>
                    <!-- Theme -->
                    <div>
                        <p class="text-xs text-gray-600 mb-2">Theme</p>
                        <div class="flex gap-2">
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg">
                                Light
                            </button>
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg">
                                Dark
                            </button>
                            <button class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-amber-50 rounded-lg">
                                Sepia
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                        ME
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Me</p>
                        <p class="text-xs text-gray-500">Just now</p>
                    </div>
                </div>
                <div class="pl-4 border-l-2 border-yellow-300 mb-3">
                    <p class="text-sm text-gray-700 italic">"April is the cruellest month"<br>Compare with Chaucer's "Canterbury Tales" opening where April is sweet.</p>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-600">
                    <div class="flex items-center gap-1">
                        <i class="bx bx-lock"></i>
                        <span>Private Note</span>
                    </div>
                    <button class="text-red-600 hover:text-red-700">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Community Highlights -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-700">
                    <i class="bx bx-group text-lg"></i>
                    <span>45 other readers highlighted this section.</span>
                </div>
            </div>

            <!-- Add Note -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <input type="text" placeholder="Add a note..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
        </aside>
    </div>

    <!-- Bottom Progress Bar -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-600 hover:text-gray-900">
                    <i class="bx bx-chevron-left text-xl"></i>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-700">Chapter Progress</span>
                    <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600" style="width: 35%"></div>
                    </div>
                    <span class="text-xs text-gray-600">35%</span>
                </div>
                <button class="p-2 text-gray-600 hover:text-gray-900">
                    <i class="bx bx-chevron-right text-xl"></i>
                </button>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="bx bx-time"></i>
                    <span>5 min left</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="bx bx-book"></i>
                    <span>Page 14 / 42</span>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

