@component('mail::message')
# Remote Access

User {{ optional($user)->name ?? $user->getAuthIdentifier() }} has grant you temporary remote access on {{ config('app.name') }}
```
{{ $content }}
```

@component('mail::button', ['url' => $url])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
