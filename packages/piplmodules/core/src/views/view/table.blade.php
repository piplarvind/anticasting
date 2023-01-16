@if($items->count())
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                @foreach($fields as $field)
                    <th>{{ trans($trans_path.'.'.$trans_extension.$field['name']) }}</th>
                    {{-- <th>Author</th>
                    <th>Upload Date</th>
                    <th>Last update</th>
                    <th>Operations</th> --}}
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    @foreach($fields as $field)
                        <td>
                            @if(isset($field['tree']))
                                @php
                                    $value = $item;
                                @endphp

                                @foreach($field['tree'] as $child)
                                    @php
                                        if(isset($value->$child)){
                                            $value = $value->$child;
                                        }else{
                                            $value = '';
                                        }
                                    @endphp

                                    @if($value && end($field['tree']) === $child)
                                        {{ $value }}
                                    @endif

                                @endforeach
                            @endif
                        </td>
                    @endforeach

                    @if(isset($operations))
                        <td>
                            @foreach($operations as $operation)
                            @php
                                $url = str_replace('{', '$id', $operation['url']);
                                $url = str_replace('}', '', $url);
                                // dd($url);
                               // print $url;
                            @endphp

                                <a href="{!! $url !!}">{{ $operation['name'] }}</a>
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>






{{--         <tfoot>
            <tr>
                <th>File</th>
                <th>Author</th>
                <th>Upload Date</th>
                <th>Last update</th>
                <th>Operations</th>
            </tr>
        </tfoot> --}}
    </table>
@endif


{{-- @include('Core::view.table', [
    'items' => $items,
    'fields' => [
                    ['name' => 'id', 'tree' => ['id'], 'if_empty' => ''],
                    ['name' => 'image', 'tree' => ['media', 'main_image', 'thumbnail'], 'if_empty' => ''],
                    ['name' => 'name', 'tree' => ['name'], 'if_empty' => ''],
                    ['name' => 'author', 'tree' => ['author', 'name'], 'if_empty' => ''],
                    ['name' => 'created_at', 'tree' => ['created_at'], 'if_empty' => ''],
                    ['name' => 'updated_at', 'tree' => ['updated_at'], 'if_empty' => ''],

    ],
    'trans_path' => 'Products::products',
    'trans_extension' => '',
    'operations' => [

                        ['name' => 'edit' , 'url' => '/products/{id}/edit', 'font_icon' => 'fa-edit'],

    ]

]) --}}