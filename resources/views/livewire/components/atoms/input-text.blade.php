<div class="w-full md:w-{{$columns}}/12 mb-4 md:mb-0 md:pr-2 relative">
    <label for="{{ $name }}" class="block mb-1 text-gray-700">{{ $label }}</label>
    <div class="relative">
        <input type="text" id="{{ $name }}" name="{{ $name }}"
               @if(!$error)
                   placeholder="{{ $label }}"

               @endif

               class="w-full border rounded-md py-2 px-3 focus:outline-none
                      @if($success) border-green-500 @elseif($error) border-red-500  @else border-gray-300 @endif"
               value="{{ $value }}"  autocomplete="off">
        @if($error)
            <p class="absolute inset-y-0 left-2 h-1 top-0 flex items-start pr-3 text-red-500 text-xs transition-opacity duration-500 ease-in-out opacity-100 animate-slide-in" style="top: 10%;">
                {{ $error }}
            </p>
        @endif
    </div>
</div>

@push('styles')
	<style>
		@keyframes slideIn {
			0% {
				opacity: 0;
				transform: translateY(-100%);
			}
			80% {
				opacity: 0.3;
			}
			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}
		.animate-slide-in {
			animation: slideIn 0.5s ease-in-out;
		}
	</style>
@endpush
