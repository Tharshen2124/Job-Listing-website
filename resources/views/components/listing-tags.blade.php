@props(['tagsCsv'])

@php 

$tags = explode(',', $tagsCsv );


/**
 * explode takes in a string separates it depending on what u put in the first param.
 * second param will be the prop
 * basically it will turn into an array and put it into $tags
*/

@endphp


<ul class="flex">
    @foreach($tags as $tag)
    <li
        class="bg-[#222222] text-white rounded-3xl px-4 py-1 mr-2 hover:bg-[#555555]"
    >
        <a href="/?tag={{ $tag }}">{{ $tag }}</a>
    </li>
    @endforeach
</ul>