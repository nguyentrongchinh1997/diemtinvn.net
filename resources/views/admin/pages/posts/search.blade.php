@foreach ($posts as $post)
    <tr>
        <td>
            {{ $stt++ }}
        </td>
        <td>
            <img src='{{asset("upload/thumbnails/$post->image")}}' width="100px">
        </td>
        <td>
            <a target="_blank" href="{{route('client.detail', ['slug' => $post->slug, 'p' => $post->id])}}">
                {{ $post->title }}
            </a>
        </td>
        <td>
            {{ $post->subCategory->name }} <br>({{ $post->subCategory->category->name }})
        </td>
        <td>
            {{ $post->view }}
        </td>
        <td>
            <a href="{{$post->url_origin}}" target="_blank">
                {{ $post->web }}
            </a>
        </td>
        <td>
            {{ $post->date }}
        </td>
        <td>
            <a href="{{route('admin.post.edit', ['id' => $post->id])}}">
                <i class="icon-pencil3 edit-category"></i>
            </a>
        </td>
        <td>
            <a onclick="return question()" href="{{ route('admin.post.delete', ['id' => $post->id]) }}">
                <i class="icon-remove3"></i>
            </a>
        </td>
        <script type="text/javascript">
            function question()
            {
                if (confirm('Bạn có muốn xóa không')) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
    </tr>
@endforeach