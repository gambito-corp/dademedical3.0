<div class="overflow-y-scroll overflow-x-hidden">
    <nav>
        @forelse($menu as $index => $item)
            <li class="list-none">
                @if(isset($item['dropdown']))
                    <button wire:click="toggleDropdown({{ $index }})" class="md:min-w-56 text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white flex items-center focus:outline-none">
                        <i class="{{$item['icon']}} mr-2"></i>
                        @if($hide)
                            @if($item['isExpanded'])
                                <i class="fas fa-angle-up ocultar"></i>
                            @else
                                <i class="fas fa-angle-down ocultar"></i>
                            @endif
                        @endif
                        <span class="opacity-transition {{$first == false && $hide ? 'opacity-0' : ''}}">{{$item['name']}}</span>
                        @if($item['isExpanded'])
                            <i class="fas fa-angle-up ml-8"></i>
                        @else
                            <i class="fas fa-angle-down ml-8"></i>
                        @endif
                    </button>
                    <ul class="dropdown-menu @if($item['isExpanded'] || $this->isActiveSubmenu($item['dropdown'])) open @endif transition-all duration-300 ease-in-out">
                        @forelse($item['dropdown'] as $subIndex => $subItem)
                            <li class="@if(Route::is($subItem['route'])) active @endif md:min-w-56 text-gray-500 py-2.5 px-4 my-2 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white flex items-center focus:outline-none"> <!-- Agrega la clase "active" si la ruta está activa -->
                                <a href="{{ route($subItem['route']) }}" class="flex items-center">
                                    <i class="{{ $subItem['icon'] }} mr-2"></i>
                                    <span class="opacity-transition {{$first == false && $hide ? 'opacity-0' : ''}}">
                                        {{ $subItem['name'] }}
                                    </span>
                                </a>
                            </li>
                        @empty
                            <li>No hay elementos en el menú desplegable.</li>
                        @endforelse
                    </ul>
                @else
                    <a class="block rounded md:min-w-56 text-gray-500 py-2.5 px-4 my-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-500 hover:text-white @if(Route::is($item['route'])) active @endif" href="{{ route($item['route']) }}">
                        <i class="{{ $item['icon'] }} mr-2"></i>
                        <span class="opacity-transition {{$first == false && $hide ? 'opacity-0' : ''}}">{{$item['name']}}</span>
                    </a>
                @endif
            </li>
        @empty
            <p>No hay elementos en el menú.</p>
        @endforelse
    </nav>
</div>
