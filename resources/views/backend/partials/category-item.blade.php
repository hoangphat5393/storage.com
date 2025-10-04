@php
    $level = $level ?? 0;
    if ($level == 0) {
        $categories = App\Models\Backend\Category::where('parent', 0)->where('type', $category_type)->orderByDesc('sort')->get();
    }
@endphp

<ul id="muti_menu_post" class="muti_menu_right_category">
    @foreach ($categories as $category)
        @php
            $checked = '';
            if (in_array($category->id, $array_checked)) {
                $checked = 'checked';
            }
        @endphp
        <li class="category_menu_list">
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input category_item_input" id="checkbox_cmc_{{ $category->id }}" name="category_id[]" {{ $checked }} value="{{ $category->id }}">
                <label class="form-check-label" for="checkbox_cmc_{{ $category->id }}">{{ $category->name }}</label>
            </div>

            @if ($category->children($category_type)->get())
                @include('backend.partials.category-item', [
                    'categories' => $category->children($category_type)->get(),
                    'level' => $level + 1,
                ])
            @endif
        </li>
    @endforeach
</ul>
