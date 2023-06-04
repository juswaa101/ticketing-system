<x-mail::message>
# {{ $data['title'] }}

{{ $data['body'] }}

<x-mail::button :url="$data['url']">
Visit
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
