@php
    //$parent_id = $parent_id ?? 0;
    //$dategories = \App\Models\ShopCategory::where('parent', $parent_id)->orderByDesc('preority')->get();
@endphp

@if (count($categories) > 0)
    @foreach ($categories as $item)
        <tr class="tr-item item-level-{{ isset($level) ? $level : 0 }}">
            <td class="text-center">
                <div class="icheck-info d-inline">
                    <input type="checkbox" id="{{ $item->id }}" name="seq_list[]" value="{{ $item->id }}">
                    <label for="{{ $item->id }}"></label>
                </div>
            </td>
            <td class="text-center">
                <input type="text" id="sort" class="form-control quick_change_value text-center" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" value="{{ $item->sort }}" reload-on-change>
            </td>
            <td class="title">
                <a class="row-title " href="{{ route('admin.product-category.edit', [$item->id]) }}">
                    <div>
                        {{ str_repeat('-----', $level) }}
                        <b style='color: #056FAD;'>
                            {{ $item->name }}
                        </b>
                    </div>
                </a>
            </td>
            <td class="text-center">
                @if ($item->image != null)
                    <img src="{{ get_image($item->icon) }}" style="height: 70px">
                @endif
            </td>
            <td class="text-center">
                {{ $item->updated_at }}
                <br>
                <input type="checkbox" id="status" class="quick_change_value" @checked($item->status == 1) value="1" value-off="0" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" data-toggle="toggle" data-on="Công khai" data-off="Bản nháp" data-onstyle="success" data-offstyle="light">
            </td>
        </tr>
        @if (count($item->children('product')->get()) > 0)
            @include('admin.product-category.includes.category_item', [
                'categories' => $item->children('product')->get(),
                'level' => $level + 1,
            ])
        @endif
    @endforeach
@endif
