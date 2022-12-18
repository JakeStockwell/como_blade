<div>
    <li class="flex align-center flex-col">
        <h4 @click="selected !== {{ $id }} ? selected = {{ $id }} : selected = null"
        {{ $attributes->merge(['class' => 'cursor-pointer px-5 py-3 bg-indigo-300 text-white text-center inline-block hover:opacity-75 hover:shadow'])}}>
                Accordion item 1
        </h4>
        <p x-show="selected == {{ $id }}" class="border py-4 px-2">
            {{ $slot }}
        </p>
    </li>
</div>