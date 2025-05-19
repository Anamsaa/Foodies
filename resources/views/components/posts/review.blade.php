
{{-- Componente para reviews --}}
<div class="review">
    <div class="review-header">
        <img src="{{ asset($profilePic) }}" alt="Foto de {{ $username }}">
        <div class="review-info">
            <h3>{{ $username }}</h3>
            <p>{{ $timestamp }}</p>
            <p>{{ $restaurantName }}, {{ $location }}</p>
        </div>
    </div>
    <div class="review-content">
        <img src="{{ asset($image) }}" alt="{{ $restaurantName }}">
        <div class="review-rating">
            <h4>{{ $rating }}/10</h4>
        </div>
        <p>{{ $reviewText }}</p>
    </div>
    <div class="review-actions">
        <button>{{ $likes }} Me gusta</button>
        <button>{{ $comments }} Comentarios</button>
    </div>
</div>

{{-- Ejemplo de como se usa @foreach dentro de una vista para pasar datos desde el controlador--}}
<!-- 
@foreach($posts as $post)
    <x-post 
        :profilePic="$post->user->profile_pic"
        :username="$post->user->name"
        :timestamp="$post->created_at->diffForHumans()"
        :restaurantName="$post->restaurant->name"
        :location="$post->restaurant->location"
        :image="$post->image"
        :rating="$post->rating"
        :reviewText="$post->review_text"
        :likes="$post->likes"
        :comments="$post->comments"
/>
@endforeach -->