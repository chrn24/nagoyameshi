<nav style="display: flex; justify-content: space-between; align-items: center; padding: 12px 24px; background-color: #f8f9fa;">
    {{-- 左：ロゴ --}}
    <div>
        <a href="{{ route('top') }}" style="font-size: 1.5rem; font-weight: bold; color: #333; text-decoration: none;">
            Nagoyameshi
        </a>
    </div>

    {{-- 右：ログイン状態によって表示内容を切り替え --}}
    <div>
        @auth
            <a href="{{ route('users.mypage') }}" style="margin-right: 10px; padding: 6px 12px; background-color: #17a2b8; color: white; text-decoration: none; border-radius: 4px;">
             マイページ
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="padding: 6px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px;">
                    ログアウト
                </button>
            </form>
        @else
            <a href="{{ route('register') }}" style="margin-right: 10px; padding: 6px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">
                会員登録
            </a>
            <a href="{{ route('login') }}" style="padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">
                ログイン
            </a>
        @endauth
    </div>
</nav>
