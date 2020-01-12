<!-- START_{{$parsedRoute['id']}} -->
@if($parsedRoute['title'] != '')## {{ $parsedRoute['title']}}
@else## {{$parsedRoute['uri']}}
@endif
@if($parsedRoute['description'])

{!! $parsedRoute['description'] !!}
@endif

> Example request:

```bash
curl -X {{$parsedRoute['methods'][0]}} "{{config('app.url')}}/{{$parsedRoute['uri']}}" \
-H "Accept: application/json"@if(count($parsedRoute['parameters'])) \
@foreach($parsedRoute['parameters'] as $attribute => $parameter)
    -d "{{$attribute}}"="{{$parameter['value']}}" \
@endforeach
@endif

```

@if(in_array('GET',$parsedRoute['methods']))
> Example response:

```json
@if(is_object($parsedRoute['response']) || is_array($parsedRoute['response']))
{!! json_encode($parsedRoute['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@else
{!! json_encode(json_decode($parsedRoute['response']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
@endif
```
@endif

### HTTP Request
@foreach($parsedRoute['methods'] as $method)
`{{$method}} {{$parsedRoute['uri']}}`

@endforeach
@if(count($parsedRoute['parameters']))
#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
@foreach($parsedRoute['parameters'] as $attribute => $parameter)
    {{$attribute}} | {{$parameter['type']}} | @if($parameter['required']) required @else optional @endif | {!! implode(' ',$parameter['description']) !!}
@endforeach
@endif

<!-- END_{{$parsedRoute['id']}} -->
