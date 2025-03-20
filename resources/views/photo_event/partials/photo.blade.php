<div class="bg-[#d9d9d9] flex flex-col h-50">
    <div class="flex justify-between mx-2 gap-4">
        <p class="text-black truncate" id="file-name-text" data-id="{{ $row->id }}" data-current-value="{{ $row->getFileName() }}">{{ $row->getFileName() }}</p>
        <div class="relative">
            <i style="font-size: 20px;" class="mt-1 fa-solid fa-ellipsis-vertical cursor-pointer file-options-button text-black"></i>
            <div class="file-options-menu hidden absolute mt-2 bg-white shadow-lg rounded-lg w-40 overflow-hidden transition-all duration-300 opacity-0 transform scale-95">
                <a href="#" class="block px-4 py-2 text-black hover:bg-gray-100 transition-all duration-300 rename-button" data-id="{{ $row->id_photo_event }}">Rename</a>
                <a href="#" class="block px-4 py-2 text-black hover:bg-gray-100 transition-all duration-300 delete-button" data-id="{{ $row->id_photo_event }}">Delete</a>
                <a href="{{ $row->getImage() }}" class="block px-4 py-2 text-black hover:bg-gray-100 transition-all duration-300" download>Download</a>
            </div>
        </div>
    </div>
    <hr class="border-black w-full">
    <div class="w-full h-full overflow-hidden flex items-center justify-center">
        <img class="w-full h-full object-cover" src="{{ $row->getImage() }}" alt="">
    </div>
</div>
