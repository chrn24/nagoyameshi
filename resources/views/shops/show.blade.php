@extends('layouts.app')
@section('content')
<h1>店舗詳細</h1>


<img src="{{ asset($shop->image) }}" alt="{{ $shop->name }}" style="max-width: 300px;">
<p><strong>カテゴリ:</strong> {{ $shop->category->name ?? 'なし' }}</p>
<h1>店舗名：{{ $shop->name }}</h1>
<p>説明：{{ $shop->description }}</p>

<p>お気に入り数: {{ $shop->favorites->count() }}</p>
{{-- ハートマークボタン（後ほどロジック追加予定） --}}
<button>♡ お気に入り</button>

<p>価格帯: ¥{{ number_format($shop->price_min) }} ～ ¥{{ number_format($shop->price_max) }}</p>
<p>営業時間: {{ $shop->business_hours }}</p>
<p>店休日: {{ $shop->closed_day }}</p>
<p>郵便番号: {{ $shop->zip_code }}</p>
<p>住所: {{ $shop->address }}</p>
<p>電話番号: {{ $shop->phone_number }}</p>

<hr>

{{-- 有料会員のみリンク表示 --}}
@auth
    @if (auth()->user()->is_premium)
        <a href="{{ route('reservations.create', ['shop' => $shop->id]) }}">予約する</a>
        <a href="{{ route('reviews.create', ['shop' => $shop->id]) }}">レビュー投稿</a>
    @else
        <a href="{{ route('users.upgrade') }}">予約する</a>
        <a href="{{ route('users.upgrade') }}">レビュー投稿</a>
    @endif
@else
    <a href="{{ route('users.upgrade') }}">予約する</a>
    <a href="{{ route('users.upgrade') }}">レビュー投稿</a>
@endauth


{{-- レビュー一覧 --}}
<h2>レビュー一覧</h2>
@foreach ($shop->reviews as $review)
    <div style="margin-bottom: 10px;">
        <p>評価：{{ $review->rating }}</p>
        <p>{{ $review->comment }}</p>
        <a href="{{ route('reviews.edit', ['review' => $review->id]) }}">編集</a>
        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">削除</button>
        </form>
    </div>
@endforeach

<br>
<a href="{{ route('top') }}">トップページに戻る</a>
@endsection
