@props(['title', 'description', 'filename'])

<div class="bg-white border rounded-lg p-4 shadow">
  <div class="flex justify-between items-center mb-2 gap-6">
    <div>
      <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
      <p class="text-sm text-gray-600">{{ $description }}</p>
    </div>
    <a href="{{ url('/template/view/' . $filename) }}"
      class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"
      target="_blank">
      Download
    </a>
  </div>
</div>
