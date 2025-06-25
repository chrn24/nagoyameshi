@extends('layouts.app')

@section('content')
<h1>トップページ</h1>


<form action="{{ route('shops.search') }}" method="GET">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="店舗名を入力">
    <button type="submit">検索</button>
</form>

@foreach ($categories as $category)
    <a href="{{ route('shops.search', ['category_id' => $category->id]) }}">
        #{{ $category->name }}
    </a>
@endforeach

<h2>人気のお店</h2>

@foreach ($popularShops as $shop)
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        {{-- 店舗画像にリンク --}}
        <a href="{{ route('shops.show', $shop->id) }}">
          <img src="{{ asset($shop->image) }}" alt="{{ $shop->name }}" style="width: 120px; height: auto; margin-right: 20px;">
        </a>

        <div>
            <p style="margin: 2px 0;"><strong>カテゴリ:</strong> {{ $shop->category->name ?? '未分類' }}</p>
            {{-- 店名にリンク --}}
            <h4 style="margin: 2px 0;">
                <a href="{{ route('shops.show', $shop->id) }}" style="text-decoration: none; color: #333;">
                    {{ $shop->name }}
                </a>
            </h4>
            <p style="margin: 2px 0;">価格帯: ¥{{ number_format($shop->price_min) }} ～ ¥{{ number_format($shop->price_max) }}</p>
            <p style="margin: 2px 0;">お気に入り: {{ $shop->favorites_count }}件</p>
        </div>
    </div>
@endforeach
@endsection


