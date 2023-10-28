<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @if ($getRecord())
        <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }" console.log("state")>
            <!-- Interact with the `state` property in Alpine.js -->
            <div>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($getRecord()->reference, 'C128', 1, 41, [1, 1, 1], true) }}"
                    alt="barcode" />
            </div>
        </div>
    @endif
</x-dynamic-component>
