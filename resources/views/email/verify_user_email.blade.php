<x-mail::message>
# Verify Email

{{$data['body']}}

<x-mail::button :url="$data['url']">
Verify
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
