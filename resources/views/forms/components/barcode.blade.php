<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <div>
            @if (!$getRecord())
        asd
        @else
        <div><img src="data:image/png;base64,{{ ((DNS1D::getBarcodePNG($getRecord()->reference,'C128',1,41,array(1,1,1), true))) }}" alt="barcode"   />
    </div>
        @endif



        </div>
    </div>
</x-dynamic-component>
