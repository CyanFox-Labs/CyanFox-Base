@props([
    'label' => null,
    'options' => [],
    'selected' => [],
    'id' => \Illuminate\Support\Str::uuid()->toString(),
])

<div
    wire:ignore
    x-data="{ values: @entangle($attributes->wire('model')), choices: null }"
    x-init="
        choices = new Choices($refs.multiple, {
            itemSelectText: '',
            removeItems: true,
            removeItemButton: true,
        });

        for (const [value, label] of Object.entries(values)) {
            choices.setChoiceByValue(value || label)
        }

        $refs.multiple.addEventListener('change', function (event) {
            values = []
            Array.from($refs.multiple.options).forEach(function (option) {
                values.push(option.value || option.text)
            })
        })
    "
>

    <label for="{{ $id }}" class="pt-0 label label-text font-semibold">
            <span>
                {{ $label }}

                @if($attributes->get('required'))
                    <span class="text-error">*</span>
                @endif
            </span>
    </label>

    <select x-ref="multiple" multiple="multiple" id="{{ $id }}">
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ in_array($key, $selected) ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
</div>
