@section('js.files')
<link href='js/prism/prism.css' rel='stylesheet'>
<script type='text/javascript' src='js/prism/prism.js'></script>
@append



@if( error!='' )
{{$error}} <br> @endif
<pre><code class="language-php line-numbers no-whitespace-normalization"> {{$mensaje}}  </code></pre>
