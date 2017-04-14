<li id="status-{{ $status->id }}">
  <a href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar" />
  </a>
  <span class="user" >
    <a href="{{ route('users.show', $user->id ) }}">{{ $user->name }}</a>
  </span>
  <span class="timestamp" >
    {{ $status->created_at->diffForHumans() }}
  </span>
  <span class="content">{{ $status->content }}</span>
  <!-- $status 实例代表的是单条微薄的数据，　$user 实例代表的是该微博发布者的数据。
  $status->created_at->diffForHumans() 该方法的作用是将日期进行友好化处理，
  我们可以使用tinker来查看该方法的具体输出情况：php artisan tinker
  在tinker 中输出第一位用户的创建时间如下：
  $created_at = App\Models\User::first()->created_at
  eg:"date: 1998-12-06 03:15:31.000000"
  $created_at->diffForHumans()
  eg:"8 years ago" -->

  @can('destroy', $status)
    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger status-delete-btn">删除</button>
    </form>
  @endcan
</li>
