@extends('layouts.app')

@section('title', 'Reader - VerseFountain')

@section('content')
  <div id="reader-root" class="grid lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8">
        <div id="reader-content" class="prose max-w-none">
          <div class="text-center mb-6">
            <div class="text-sm text-blue-700 font-semibold">PART I</div>
            <h1 class="text-3xl font-bold">The Burial of the Dead</h1>
          </div>
          <p><em>For Ezra Pound — il miglior fabbro.</em></p>
          <p>April is the cruellest month, breeding Lilacs out of the dead land, mixing Memory and desire, stirring Dull roots with spring rain...</p>
          <p>Winter kept us warm, covering Earth in forgetful snow...</p>
          <p>Summer surprised us, coming over the Starnbergersee...</p>
        </div>
      </div>
    </div>
    <div class="space-y-6">
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
          <div class="font-medium">Appearance</div>
          <button id="appearance-open" class="inline-flex items-center justify-center px-3 py-1 rounded-md text-xs font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 bg-gray-100 text-gray-800 hover:bg-gray-200 focus:ring-gray-300">Open</button>
        </div>
        <div class="text-sm text-gray-600 mt-2">Adjust font, size, and theme.</div>
      </div>
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
        <div class="font-medium mb-2">Notes</div>
        <div class="text-sm text-gray-500">Add a note...</div>
      </div>
    </div>

    <!-- Appearance Modal -->
    <div id="appearance-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/30" data-close="modal"></div>
      <div class="relative bg-white dark:bg-gray-900 rounded-lg shadow-xl w-full max-w-lg p-6">
        <div class="text-sm font-semibold text-gray-700 dark:text-gray-200">APPEARANCE</div>
        <div class="mt-4 grid grid-cols-3 gap-2">
          <button data-font="font-sans" class="py-1 rounded bg-gray-100 text-gray-700">Sans</button>
          <button data-font="prose" class="py-1 rounded bg-blue-600 text-white">Serif</button>
          <button data-font="font-mono" class="py-1 rounded bg-gray-100 text-gray-700">Mono</button>
        </div>
        <div class="mt-4">
          <div class="text-sm mb-2">Font size</div>
          <input id="font-size" type="range" min="14" max="22" value="18" class="w-full" />
        </div>
        <div class="mt-4 grid grid-cols-3 gap-2">
          <button data-theme="light" class="py-1 rounded bg-blue-600 text-white">Light</button>
          <button data-theme="dark" class="py-1 rounded bg-gray-100 text-gray-700">Dark</button>
          <button data-theme="sepia" class="py-1 rounded bg-gray-100 text-gray-700">Sepia</button>
        </div>
        <div class="mt-6 text-right">
          <button id="appearance-close" class="inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 bg-gray-100 text-gray-800 hover:bg-gray-200 focus:ring-gray-300">Close</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    (function(){
      const modal = document.getElementById('appearance-modal');
      const openBtn = document.getElementById('appearance-open');
      const closeBtn = document.getElementById('appearance-close');
      const reader = document.getElementById('reader-content');
      const size = document.getElementById('font-size');

      function setTheme(v){
        localStorage.setItem('vf-theme', v);
        document.documentElement.classList.toggle('dark', v==='dark');
        document.documentElement.classList.toggle('sepia', v==='sepia');
        if(v!=='dark' && v!=='sepia'){
          document.documentElement.classList.remove('dark','sepia');
        }
      }

      // Initialize theme
      setTheme(localStorage.getItem('vf-theme') || 'light');

      openBtn?.addEventListener('click', () => modal.classList.remove('hidden'));
      closeBtn?.addEventListener('click', () => modal.classList.add('hidden'));
      modal?.addEventListener('click', (e)=>{ if(e.target.dataset.close==='modal'){ modal.classList.add('hidden'); }});

      // Font buttons
      modal?.querySelectorAll('[data-font]').forEach(btn => {
        btn.addEventListener('click', () => {
          reader.classList.remove('font-sans','prose','font-mono');
          reader.classList.add(btn.dataset.font);
          modal.querySelectorAll('[data-font]').forEach(b=>b.classList.remove('bg-blue-600','text-white'));
          btn.classList.add('bg-blue-600','text-white');
        })
      });

      // Size slider
      size?.addEventListener('input', () => { reader.style.fontSize = size.value+'px'; });

      // Theme buttons
      modal?.querySelectorAll('[data-theme]').forEach(btn => {
        btn.addEventListener('click', () => {
          setTheme(btn.dataset.theme);
          modal.querySelectorAll('[data-theme]').forEach(b=>b.classList.remove('bg-blue-600','text-white'));
          btn.classList.add('bg-blue-600','text-white');
        })
      });
    })();
  </script>
  @endpush
@endsection
