@extends('layouts.app')

@section('title', 'Reader - VerseFountain')

@section('content')
  <div class="relative min-h-screen bg-white" id="reader-shell">
    <div class="max-w-5xl mx-auto px-4 pb-24">
      <div class="flex items-center justify-between h-14 gap-4 sticky top-0 bg-white/95 backdrop-blur z-20 border-b border-gray-200">
        <div class="flex items-center gap-3 text-sm text-gray-600">
          <a href="javascript:history.back()" class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100 text-gray-700">
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700">←</span>
            Library
          </a>
          <span class="text-gray-400">|</span>
          <div class="flex flex-col leading-tight">
            <span class="text-xs uppercase tracking-wide text-blue-600 font-semibold">Part I</span>
            <span class="text-base font-semibold text-gray-900">The Burial of the Dead</span>
            <span class="text-xs text-gray-500">T.S. Eliot</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <button id="appearance-toggle" class="flex items-center gap-2 px-3 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded bg-white border border-gray-200 text-gray-700">A</span>
            Appearance
          </button>
        </div>
      </div>

      <div class="grid lg:grid-cols-[2fr_320px] gap-8 mt-10">
        <div>
          <article id="reader-content" class="prose max-w-3xl mx-auto prose-lg text-gray-900 leading-relaxed font-serif">
            <div class="text-center mb-8">
              <div class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Part I</div>
              <h1 class="text-4xl font-bold mb-2">The Burial of the Dead</h1>
              <div class="text-sm text-gray-500">T.S. Eliot</div>
              <div class="mt-4 text-sm italic text-gray-600">For Ezra Pound — il miglior fabbro.</div>
            </div>

            <p>April is the cruellest month, breeding<br>
              Lilacs out of the dead land, mixing<br>
              Memory and desire, stirring<br>
              Dull roots with spring rain.</p>

            <p>Winter kept us warm, covering<br>
              Earth in forgetful snow, feeding<br>
              A little life with dried tubers.</p>

            <p>Summer surprised us, coming over the Starnbergersee<br>
              With a shower of rain; we stopped in the colonnade,<br>
              And went on in sunlight, into the Hofgarten,<br>
              And drank coffee, and talked for an hour.</p>

            <p>In the mountains, there you feel free.<br>
              I read, much of the night, and go south in the winter.</p>
          </article>
        </div>

        <aside class="relative">
          <div id="appearance-panel" class="absolute right-0 top-0 w-full max-w-xs bg-white border border-gray-200 rounded-xl shadow-xl p-4 space-y-4 hidden">
            <div class="text-xs font-semibold text-gray-500 uppercase">Appearance</div>

            <div class="space-y-2">
              <div class="text-sm text-gray-700">Font</div>
              <div class="grid grid-cols-3 gap-2">
                <button data-font="font-sans" class="appearance-btn py-2 rounded-md border border-gray-200 text-sm font-medium text-gray-700 bg-gray-50">Sans</button>
                <button data-font="font-serif" class="appearance-btn py-2 rounded-md border border-blue-500 text-sm font-medium text-blue-700 bg-blue-50">Serif</button>
                <button data-font="font-mono" class="appearance-btn py-2 rounded-md border border-gray-200 text-sm font-medium text-gray-700 bg-gray-50">Mono</button>
              </div>
            </div>

            <div class="space-y-2">
              <div class="text-sm text-gray-700">Text size</div>
              <input id="font-size" type="range" min="14" max="22" value="18" class="w-full" />
            </div>

            <div class="space-y-2">
              <div class="text-sm text-gray-700">Theme</div>
              <div class="grid grid-cols-3 gap-2">
                <button data-theme="light" class="theme-btn py-2 rounded-md border border-blue-500 bg-blue-50 text-blue-700 text-sm font-medium">Light</button>
                <button data-theme="dark" class="theme-btn py-2 rounded-md border border-gray-200 bg-gray-900 text-white text-sm font-medium">Dark</button>
                <button data-theme="sepia" class="theme-btn py-2 rounded-md border border-gray-200 bg-amber-50 text-amber-800 text-sm font-medium">Sepia</button>
              </div>
            </div>

            <div class="space-y-2">
              <div class="text-sm text-gray-700">Notes</div>
              <textarea class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Add a note..."></textarea>
              <button class="w-full py-2 rounded-md bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Save Note</button>
            </div>
          </div>

          <div class="hidden lg:block text-sm text-gray-500">
            <div class="text-xs uppercase font-semibold text-gray-400 mb-3">Notes</div>
            <div class="border border-dashed border-gray-200 rounded-lg p-4">Add a note...</div>
          </div>
        </aside>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    (function(){
      const panel = document.getElementById('appearance-panel');
      const toggle = document.getElementById('appearance-toggle');
      const reader = document.getElementById('reader-content');
      const size = document.getElementById('font-size');

      const savedTheme = localStorage.getItem('vf-reader-theme') || 'light';
      const savedFont = localStorage.getItem('vf-reader-font') || 'font-serif';
      const savedSize = localStorage.getItem('vf-reader-size') || 18;

      function applyTheme(theme){
        document.documentElement.classList.toggle('dark', theme === 'dark');
        document.documentElement.classList.toggle('sepia', theme === 'sepia');
        if(theme === 'light'){
          document.documentElement.classList.remove('dark','sepia');
        }
        localStorage.setItem('vf-reader-theme', theme);
        panel?.querySelectorAll('.theme-btn').forEach(btn => {
          btn.classList.remove('border-blue-500','bg-blue-50','text-blue-700');
          if(btn.dataset.theme === theme){
            btn.classList.add('border-blue-500','bg-blue-50','text-blue-700');
          }
        });
      }

      function applyFont(font){
        reader.classList.remove('font-sans','font-serif','font-mono');
        reader.classList.add(font);
        localStorage.setItem('vf-reader-font', font);
        panel?.querySelectorAll('.appearance-btn').forEach(btn => {
          btn.classList.remove('border-blue-500','bg-blue-50','text-blue-700');
          btn.classList.add('border-gray-200','bg-gray-50','text-gray-700');
          if(btn.dataset.font === font){
            btn.classList.remove('border-gray-200','bg-gray-50','text-gray-700');
            btn.classList.add('border-blue-500','bg-blue-50','text-blue-700');
          }
        });
      }

      function applySize(value){
        reader.style.fontSize = `${value}px`;
        localStorage.setItem('vf-reader-size', value);
      }

      // Initialize
      applyTheme(savedTheme);
      applyFont(savedFont);
      applySize(savedSize);
      size.value = savedSize;

      // Toggle panel
      toggle?.addEventListener('click', () => {
        panel?.classList.toggle('hidden');
      });

      // Font buttons
      panel?.querySelectorAll('.appearance-btn').forEach(btn => {
        btn.addEventListener('click', () => applyFont(btn.dataset.font));
      });

      // Theme buttons
      panel?.querySelectorAll('.theme-btn').forEach(btn => {
        btn.addEventListener('click', () => applyTheme(btn.dataset.theme));
      });

      // Size slider
      size?.addEventListener('input', () => applySize(size.value));
    })();
  </script>
  @endpush
@endsection
