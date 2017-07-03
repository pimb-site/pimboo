@foreach ($users as $user)

{{ $user->id }}
{{ $user->photo }}
{{ $user->name }}
{{ $user->email }}

@endforeach