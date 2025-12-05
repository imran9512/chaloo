<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header & Search -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Browse Tours</h1>
                    <div class="flex items-center mt-1">
                        <p class="text-gray-600 dark:text-gray-400 mr-2">Showing tours related to <span
                                class="font-bold text-indigo-600 dark:text-indigo-400">{{ $userCity ?? '...' }}</span>
                        </p>
                        <button wire:click="changeCity" class="text-xs text-blue-500 hover:underline">(Change
                            City)</button>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <input type="text" wire:model.live="search" placeholder="🔍 Search tours, destinations..."
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                </div>
            </div>

            <!-- City Selection Modal -->
            @if($showCityModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 max-w-md w-full mx-4">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Select Your City</h2>
                            <p class="text-gray-600 dark:text-gray-400">Please enter your city to see relevant tours.</p>
                        </div>

                        <div>
                            <input type="text" wire:model="userCity" wire:keydown.enter="setCity"
                                placeholder="Enter city name (e.g. Lahore)"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm mb-4 text-lg py-3">

                            <button wire:click="setCity"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Show Tours
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div x-data="{ showFilters: false }" class="mt-4">
                <button @click="showFilters = !showFilters"
                    class="flex ml-2 items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span x-text="showFilters ? 'Hide Filters' : 'Show Advanced Filters'"></span>
                </button>

                <div x-show="showFilters" x-transition
                    class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Min Price</label>
                        <input type="number" wire:model.live="minPrice" placeholder="0"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Max Price</label>
                        <input type="number" wire:model.live="maxPrice" placeholder="Any"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Min Days</label>
                        <input type="number" wire:model.live="minDays" placeholder="1"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Max Days</label>
                        <input type="number" wire:model.live="maxDays" placeholder="Any"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tours Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tours as $tour)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">

                    <!-- Image Slider -->
                    <div class="chaloo-slider relative">
                        <!-- Images Container with Fixed Aspect Ratio (1.5:1) -->
                        <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="aspect-ratio: 3/2;">
                            @if(is_array($tour->images) && count($tour->images) > 0)
                                <div class="slider-track"
                                    style="display: flex; height: 100%; transition: transform 0.3s ease-out;">
                                    @foreach($tour->images as $image)
                                        <div class="slider-slide" style="width: 100%; height: 100%; flex-shrink: 0;">
                                            <img src="{{ asset('uploads/' . $image) }}" alt="{{ $tour->name }}"
                                                style="width: 100%; height: 100%; object-fit: cover; pointer-events: none;">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                                    <span class="text-gray-500 dark:text-gray-400 text-2xl">🏖️</span>
                                </div>
                            @endif
                        </div>

                        <!-- Dots with Inline Styles -->
                        @if(is_array($tour->images) && count($tour->images) > 1)
                            <div
                                style="display: flex; justify-content: center; gap: 8px; padding: 12px 0; background-color: #f9fafb;">
                                @foreach($tour->images as $index => $image)
                                    <button class="slider-dot" data-index="{{ $index }}"
                                        style="width: 8px; height: 8px; border-radius: 50%; background-color: #d1d5db; border: none; cursor: pointer; transition: all 0.3s; padding: 0;"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Tour Details -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1">{{ $tour->name }}</h3>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                {{ $tour->duration_days }} Days
                            </span>
                        </div>

                        <!-- Departure City (New) -->
                        @if($tour->departure_city)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span class="font-semibold mr-1">From:</span> {{ $tour->departure_city }}
                            </div>
                        @endif

                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="truncate">
                                @php
                                    $destinations = $tour->destinations;
                                    echo is_array($destinations) ? implode(', ', array_column($destinations, 'city')) : $tour->destinations;
                                @endphp
                            </span>
                        </div>

                        <div class="flex items-center justify-between mb-3 text-sm text-gray-600 dark:text-gray-400">
                            <span>📅 {{ \Carbon\Carbon::parse($tour->departure_date)->format('d M Y') }}</span>
                        </div>

                        @if($tour->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                {{ Str::limit($tour->description, 100) }}
                            </p>
                        @endif

                        <!-- Pricing -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-end justify-between">
                                <div>
                                    @if($tour->price_per_person)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Per Person</p>
                                        <p class="text-xl font-bold text-green-600">Rs.
                                            {{ number_format($tour->price_per_person) }}
                                        </p>
                                    @endif
                                </div>
                                <a href="tel:{{ $tour->user->phone }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    Call
                                </a>
                            </div>

                            @if($tour->price_per_couple)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Couple: Rs. {{ number_format($tour->price_per_couple) }}
                                </p>
                            @endif
                        </div>

                        <!-- Agent Info -->
                        <div
                            class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                By: <span
                                    class="font-semibold text-gray-700 dark:text-gray-300">{{ $tour->user->name }}</span>
                            </p>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">Verified</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                        @if(!$userCity)
                            Please select a city to view tours
                        @else
                            No tours found related to {{ $userCity }}
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(!$userCity)
                            We optimize your experience by showing only relevant tours.
                        @else
                            Try adjusting your search filters or change the city.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if($tours->hasPages())
            <div class="mt-8">
                {{ $tours->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        initSliders();
    });

    document.addEventListener('livewire:navigated', function () {
        initSliders();
    });

    function initSliders() {
        const sliders = document.querySelectorAll('.chaloo-slider');

        sliders.forEach(slider => {
            const track = slider.querySelector('.slider-track');
            const dots = slider.querySelectorAll('.slider-dot');
            const container = slider.querySelector('.bg-gray-200'); // The image container

            if (!track || dots.length === 0) return;

            let currentIndex = 0;
            let startX = 0;
            let currentTranslate = 0;
            let prevTranslate = 0;
            let isDragging = false;
            const totalSlides = dots.length;

            // Touch Events for Mobile Swipe
            track.addEventListener('touchstart', touchStart);
            track.addEventListener('touchend', touchEnd);
            track.addEventListener('touchmove', touchMove);

            // Mouse Events for Desktop Swipe (optional but good for testing)
            track.addEventListener('mousedown', touchStart);
            track.addEventListener('mouseup', touchEnd);
            track.addEventListener('mouseleave', () => { if (isDragging) touchEnd() });
            track.addEventListener('mousemove', touchMove);

            function touchStart(event) {
                isDragging = true;
                startX = getPositionX(event);
                track.style.transition = 'none'; // Disable transition for direct following
            }

            function touchMove(event) {
                if (!isDragging) return;
                const currentX = getPositionX(event);
                const diff = currentX - startX;
                // Add resistance at edges
                if ((currentIndex === 0 && diff > 0) || (currentIndex === totalSlides - 1 && diff < 0)) {
                    currentTranslate = prevTranslate + diff / 3;
                } else {
                    currentTranslate = prevTranslate + diff;
                }
                track.style.transform = `translateX(${currentTranslate}px)`;
            }

            function touchEnd() {
                isDragging = false;
                const movedBy = currentTranslate - prevTranslate;

                // Threshold to change slide
                if (movedBy < -50 && currentIndex < totalSlides - 1) {
                    currentIndex += 1;
                } else if (movedBy > 50 && currentIndex > 0) {
                    currentIndex -= 1;
                }

                updateSlider();
            }

            function getPositionX(event) {
                return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            }

            // Dot click handlers
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function (e) {
                    e.stopPropagation();
                    currentIndex = index;
                    updateSlider();
                });
            });

            function updateSlider() {
                // Calculate percentage translate
                const translatePercent = currentIndex * -100;
                track.style.transition = 'transform 0.3s ease-out';
                track.style.transform = `translateX(${translatePercent}%)`;

                // Update state for swipe
                // We need to know the width in pixels for touch move calculations next time
                // But for now, we reset prevTranslate based on percentage approx or just reset on next touch start
                // Actually, for percentage based slider, mixing px and % is tricky. 
                // Better to stick to % for final state, but px for dragging.
                // Let's reset prevTranslate to the pixel equivalent of the new percentage position
                const slideWidth = track.clientWidth; // Width of one slide (since track width is 100% * count, wait, track is flex container)
                // Actually track width is container width * count. 
                // The container is the parent of track.
                const containerWidth = slider.querySelector('.overflow-hidden').clientWidth;
                prevTranslate = currentIndex * -containerWidth;


                // Update dots - Blue for active, Gray for inactive
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.style.backgroundColor = '#2563eb'; // Blue
                        dot.style.transform = 'scale(1.2)';
                    } else {
                        dot.style.backgroundColor = '#d1d5db'; // Gray
                        dot.style.transform = 'scale(1)';
                    }
                });
            }

            // Initialize first dot
            // We need to set initial prevTranslate
            const containerWidth = slider.querySelector('.overflow-hidden').clientWidth;
            prevTranslate = currentIndex * -containerWidth;
            updateSlider();

            // Update on resize to fix pixel calculations
            window.addEventListener('resize', () => {
                const containerWidth = slider.querySelector('.overflow-hidden').clientWidth;
                prevTranslate = currentIndex * -containerWidth;
            });
        });
    }
</script>